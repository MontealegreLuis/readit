<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Repositories;

use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\LinkInformation;
use CodeUp\ReadIt\Links\Links;
use CodeUp\ReadIt\Links\Readitor;
use CodeUp\ReadIt\Links\ReaditorInformation;
use CodeUp\ReadIt\Links\UnknownLink;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class LinksRepository extends Model implements Links
{
    public $timestamps = false;

    protected $table = 'links';

    protected $fillable = ['url', 'title', 'votes', 'posted_at', 'readitor_id'];

    /**
     * @param LinkInformation $link
     * @return LinkInformation It will contain the ID assigned by the database
     */
    public function add(LinkInformation $link)
    {
        $linkInformation = $this->create([
            'url' => (string) $link->url(),
            'title' => $link->title(),
            'votes' => $link->votes(),
            'posted_at' => $link->timestamp(),
            'readitor_id' => $link->readitor()->id(),
        ]);
        $information = $linkInformation->toArray();
        $information['name'] = $link->readitor()->name();
        $information['readitor'] = new ReaditorInformation($information);

        return new LinkInformation($information);
    }

    /**
     * @param int $id
     * @return Link
     * @throws UnknownLink
     */
    public function withId($id)
    {
        $link = $this->getLinksQueryBuilder()
            ->where('links.id', '=', $id)
            ->first()
        ;

        if (!$link) {
            throw new UnknownLink("Cannot find link with ID {$id}");
        }

        return Link::from($this->hydrateLink($link));
    }

    /**
     * Subtract a vote for every 5 minutes since the link was posted
     *
     * @param int $since
     * @param Readitor $readitor Optional if user is a guest
     * @return \CodeUp\ReadIt\Links\LinkInformation[]
     */
    public function orderedByRank($since, Readitor $readitor = null)
    {
        $builder = $this->getLinksQueryBuilder();
        if ($readitor) {
            $builder
                ->addSelect([
                    'votes.link_id',
                    'votes.readitor_id AS current_readitor',
                    'votes.type'
                ])
                ->leftJoin('votes', function(JoinClause $join) use ($readitor) {
                    $join
                        ->on('votes.readitor_id', '=', 'users.id')
                        ->on('votes.link_id', '=', 'links.id')
                        ->on('votes.readitor_id', '=', DB::raw($readitor->id()))
                    ;
                })
            ;
        }

        $links = $builder
            ->addSelect(DB::raw("links.votes - ROUND((({$since} - links.posted_at) / (60 * 5))) AS rank"))
            ->orderBy('rank', 'desc')
            ->orderBy('votes', 'desc')
            ->orderBy('posted_at', 'desc')
            ->get()
        ;

        return array_map([$this, 'hydrateLink'], $links);
    }

    public function refresh(LinkInformation $link)
    {
        $this
            ->query()
            ->where('id', $link->id())
            ->update([
                'title' => $link->title(),
                'url' => (string) $link->url(),
                'votes' => $link->votes(),
            ]);
        ;
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    private function getLinksQueryBuilder()
    {
        return $this
            ->query()
            ->getQuery()
            ->select([
                'links.id',
                'links.url',
                'links.title',
                'links.votes',
                'links.posted_at',
                'users.id AS readitor_id',
                'users.name',
            ])
            ->join('users', 'users.id', '=', 'links.readitor_id')
        ;
    }

    /**
     * @param array $information
     * @return LinkInformation
     */
    private function hydrateLink(array $information)
    {
        return new LinkInformation($information);
    }
}
