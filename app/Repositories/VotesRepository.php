<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Repositories;

use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\Readitor;
use CodeUp\ReadIt\Links\Vote;
use CodeUp\ReadIt\Links\VoteInformation;
use CodeUp\ReadIt\Links\Votes;
use Illuminate\Database\Eloquent\Model;

class VotesRepository extends Model implements Votes
{
    protected $table = 'votes';

    protected $fillable = ['link_id', 'readitor_id', 'type'];

    /**
     * @param Link $link
     * @param Readitor $byReaditor
     * @return Vote|null
     */
    public function givenTo(Link $link, Readitor $byReaditor)
    {
        $vote = $this
            ->query()
            ->getQuery()
            ->where('link_id', '=', $link->id())
            ->where('readitor_id', '=', $byReaditor->id())
            ->first()
        ;

        if (!$vote) {
            return null;
        }

        return Vote::from(new VoteInformation($vote));
    }

    /**
     * @param Vote $vote
     * @return VoteInformation
     */
    public function add(Vote $vote)
    {
        $information = $vote->information();
        $voteInformation = $this->create([
            'link_id' => $information->linkId(),
            'readitor_id' => $information->readitorId(),
            'type' => $information->type(),
        ]);

        return new VoteInformation($voteInformation->toArray());
    }

    /**
     * @param Vote $vote
     */
    public function remove(Vote $vote)
    {
        $this->destroy($vote->id());
    }

    /**
     * @param Vote $vote
     */
    public function refresh(Vote $vote)
    {
        $information = $vote->information();

        $this
            ->query()
            ->where('id', $vote->id())
            ->update([
                'link_id' => $information->linkId(),
                'readitor_id' => $information->readitorId(),
                'type' => $information->type(),
            ]);
        ;
    }
}
