<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Repositories;

use CodeUp\ReadIt\Links\LinkInformation;
use CodeUp\ReadIt\Links\Links;
use Illuminate\Database\Eloquent\Model;

class LinksRepository extends Model implements Links
{
    protected $table = 'links';

    protected $fillable = ['url', 'title', 'votes', 'readitor_id'];

    public function add(LinkInformation $link)
    {
        $link = $this->create([
            'url' => $link->url(),
            'title' => $link->title(),
            'votes' => $link->votes(),
            'readitor_id' => $link->readitor()->id(),
        ]);

        return new LinkInformation($link->toArray());
    }

    /**
     * @param int $id
     * @return LinkInformation|null
     */
    public function withId($id)
    {
        $link = $this
            ->query()
            ->getQuery()
            ->where('id', '=', $id)
            ->first()
        ;

        return is_array($link) ? new LinkInformation($link) : null;
    }

    /**
     * @return LinkInformation[]
     */
    public function orderedByVotes()
    {
        $links = $this
            ->query()
            ->getQuery()
            ->orderBy('votes', 'desc')
            ->join('users', 'users.id', '=', 'links.readitor_id')
            ->get()
        ;

        return array_map(function(array $information) {
            return new LinkInformation($information);
        }, $links);
    }

    public function refresh(LinkInformation $link)
    {
        // TODO: Implement refresh() method.
    }
}
