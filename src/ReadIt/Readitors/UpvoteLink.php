<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Readitors;

use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\Links;
use CodeUp\ReadIt\Links\Readitor;
use CodeUp\ReadIt\Links\Vote;
use CodeUp\ReadIt\Links\Votes;

/**
 * A readitor can only upvote for a link once, if a second attempt is done,
 * first vote will be removed.
 */
class UpvoteLink
{
    /** @var Links */
    private $links;

    /** @var Votes */
    private $votes;

    /**
     * @param Links $links
     * @param Votes $votes
     */
    public function __construct(Links $links, Votes $votes)
    {
        $this->links = $links;
        $this->votes = $votes;
    }

    /**
     * @param int $linkId
     * @param Readitor $readitor
     * @return \CodeUp\ReadIt\Links\Link
     * @throws \CodeUp\ReadIt\Links\UnknownLink
     */
    public function upvote($linkId, Readitor $readitor)
    {
        $link = $this->links->withId($linkId);

        $existingVote = $this->votes->givenTo($link, $readitor);
        if ($existingVote && $existingVote->isPositive()) {
            $this->removeVote($readitor, $existingVote, $link);
        } else {
            $this->addVote($readitor, $link);
        }
        $this->links->refresh($link->information());

        return $link;
    }

    /**
     * @param Readitor $readitor
     * @param Vote $existingVote
     * @param Link $link
     */
    private function removeVote(Readitor $readitor, Vote $existingVote, Link $link)
    {
        $readitor->downvoteLink($link);
        $this->votes->remove($existingVote);
    }

    /**
     * @param Readitor $readitor
     * @param Link $link
     */
    private function addVote(Readitor $readitor, Link $link)
    {
        $vote = $readitor->upvoteLink($link);
        $this->votes->add($vote);
    }
}
