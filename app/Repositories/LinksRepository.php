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
use CodeUp\ReadIt\Links\ReaditorInformation;
use CodeUp\ReadIt\Links\UnknownLink;
use Illuminate\Database\Eloquent\Model;

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
            'url' => $link->url(),
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
        $link = $this->getReaditorQueryBuilder()
            ->where('links.id', '=', $id)
            ->first()
        ;

        if (!$link) {
            throw new UnknownLink("Cannot find link with ID {$id}");
        }

        return Link::from($this->hydrateLink($link));
    }

    /**
     * @return LinkInformation[]
     */
    public function orderedByVotes()
    {
        $links = $this->getReaditorQueryBuilder()->get();

        return array_map([$this, 'hydrateLink'], $links);
    }

    public function refresh(LinkInformation $link)
    {
        $this->update([
            'id' => $link->id(),
            'title' => $link->title(),
            'url' => $link->url(),
            'votes' => $link->votes(),
        ]);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    private function getReaditorQueryBuilder()
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
                'users.id as readitor_id',
                'users.name',
            ])
            ->orderBy('votes', 'desc')
            ->join('users', 'users.id', '=', 'links.readitor_id')
        ;
    }

    /**
     * @param array $information
     * @return LinkInformation
     */
    private function hydrateLink(array $information)
    {
        $information['readitor'] = new ReaditorInformation($information);

        return new LinkInformation($information);
    }
}
