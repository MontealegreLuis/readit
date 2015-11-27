<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Readitors;

use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\Readitor;
use CodeUp\ReadIt\Links\Vote;

class DownvoteLink extends VoteLink
{
    /**
     * Cancel the vote if readitor is trying to downvote again.
     * Switch to a downvote if readitor previously upvoted this link.
     *
     * @param Vote $vote
     * @param Readitor $readitor
     * @param Link $link
     */
    protected function handleExistingVote(
        Vote $vote,
        Readitor $readitor,
        Link $link
    ) {
        if ($vote->isNegative()) {
            $this->cancelVote($vote, $readitor, $link);
        } else {
            $this->toggleVote($vote, $readitor, $link);
        }
    }

    /**
     * Downvote link
     *
     * @param Readitor $readitor
     * @param Link $link
     */
    protected function applyVote(Readitor $readitor, Link $link)
    {
        $vote = $readitor->downvoteLink($link);
        $this->votes->add($vote);
    }
}
