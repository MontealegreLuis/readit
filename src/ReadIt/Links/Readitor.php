<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Links;

/**
 * A Readitor can post links to the site, and upvote and downvote other
 * readitors links.
 */
class Readitor
{
    /**
     * @var VotedLinks IDs of the links voted by this Readitor
     */
    private $votedLinks;

    /**
     * @param VotedLinks $votedLinks
     */
    public function __construct(VotedLinks $votedLinks)
    {
        $this->votedLinks = $votedLinks;
    }

    /**
     * @param Link $link
     */
    public function upvoteLink(Link $link)
    {
        $this->guardAgainstDuplicateVotes($link);
        $link->upvote();
        $this->votedLinks->add($link->id());
    }

    /**
     * @param Link $link
     */
    public function downvoteLink(Link $link)
    {
        $this->guardAgainstDuplicateVotes($link);
        $link->downvote();
        $this->votedLinks->add($link->id());
    }

    /**
     * @param Link $link
     * @throws AlreadyVotedForLink If the link has already been voted by this readitor
     */
    private function guardAgainstDuplicateVotes(Link $link)
    {
        if ($this->votedLinks->contains($link->id())) {
            throw new AlreadyVotedForLink("Cannot vote twice for link {$link->id()}");
        }
    }
}
