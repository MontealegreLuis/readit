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

/**
 * A readitor can only upvote for a link once, if a second attempt is done,
 * first vote will be removed.
 */
class UpvoteLink extends VoteLink
{
    /**
     * Cancel the vote if readitor is trying to upvote again.
     * Switch to an upvote if readitor previously downvoted this link.
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
        if ($vote->isPositive()) {
            $this->cancelVote($vote, $readitor, $link);
        } else {
            $this->toggleVote($vote, $readitor, $link);
        }
    }

    /**
     * Upvote link
     *
     * @param Readitor $readitor
     * @param Link $link
     */
    protected function applyVote(Readitor $readitor, Link $link)
    {
        $vote = $readitor->upvoteLink($link);
        $this->votes->add($vote);
    }
}
