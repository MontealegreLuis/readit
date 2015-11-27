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

abstract class VoteLink
{
    /** @var Links */
    protected $links;

    /** @var Votes */
    protected $votes;

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
     * @return Link
     * @throws \CodeUp\ReadIt\Links\UnknownLink
     */
    public function vote($linkId, Readitor $readitor)
    {
        $link = $this->links->withId($linkId);

        if ($existingVote = $this->votes->givenTo($link, $readitor)) {
            $this->handleExistingVote($existingVote, $readitor, $link);
        } else {
            $this->applyVote($readitor, $link);
        }

        $this->links->refresh($link->information());

        return $link;
    }

    /**
     * @param Vote $vote
     * @param Readitor $readitor
     * @param Link $link
     */
    protected function cancelVote(Vote $vote, Readitor $readitor, Link $link)
    {
        $readitor->cancelVote($link, $vote);
        $this->votes->remove($vote);
    }

    /**
     * @param Vote $vote
     * @param Readitor $readitor
     * @param Link $link
     */
    protected function toggleVote(Vote $vote, Readitor $readitor, Link $link)
    {
        $readitor->toggleVote($link, $vote);
        $this->votes->refresh($vote);
    }

    /**
     * @param Vote $vote
     * @param Readitor $readitor
     * @param Link $link
     */
    abstract protected function handleExistingVote(
        Vote $vote,
        Readitor $readitor,
        Link $link
    );

    /**
     * @param Readitor $readitor
     * @param Link $link
     */
    abstract protected function applyVote(Readitor $readitor, Link $link);
}
