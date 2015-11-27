<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace PhpSpec\Specs;

use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\LinkInformation;
use CodeUp\ReadIt\Links\Links;
use CodeUp\ReadIt\Links\Readitor;
use CodeUp\ReadIt\Links\UnknownLink;
use CodeUp\ReadIt\Links\Vote;
use CodeUp\ReadIt\Links\Votes;
use DateTime;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

abstract class VoteLinkSpec extends ObjectBehavior
{
    /** @var Readitor */
    protected $readitor;

    /** @var Link */
    protected $link;

    function let(Links $links, Votes $votes)
    {
        $this->beConstructedWith($links, $votes);
        $this->readitor = Readitor::with(1, 'Luis Montealegre');
        $this->link = Link::from(new LinkInformation([
            'id' => 1,
            'votes' => 10,
            'url' => 'http://www.montealegreluis.com',
            'title' => 'My blog',
            'timestamp' => DateTime::createFromFormat('Y-m-d H:i:s', '2015-11-27 13:20:02')->getTimestamp(),
        ]));
    }

    /**
     * @param Links $links
     */
    protected function anExistingLink(Links $links)
    {
        $links->withId(1)->willReturn($this->link);
    }

    /**
     * @param Votes $votes
     */
    protected function readitorHasNotVotedForLink(Votes $votes)
    {
        $votes->givenTo($this->link, $this->readitor)->willReturn(null);
    }

    /**
     * @param Links $links
     */
    protected function linkGetsUpdated(Links $links)
    {
        $links->refresh(Argument::type(LinkInformation::class))->shouldBeCalled();
    }

    /**
     * @param Votes $votes
     */
    protected function linkIsAddedToReaditorsVotes(Votes $votes)
    {
        $votes->add(Argument::type(Vote::class))->shouldBeCalled();
    }

    /**
     * @param Votes $votes
     */
    protected function readitorHasDownvotedForLink(Votes $votes) {
        $votes
            ->givenTo($this->link, $this->readitor)
            ->willReturn(Vote::downvote($this->link, $this->readitor))
        ;
    }

    /**
     * @param Votes $votes
     */
    protected function linkIsRemovedFromReaditorsVotes(Votes $votes)
    {
        $votes->remove(Argument::type(Vote::class))->shouldBeCalled();
    }

    /**
     * @param Votes $votes
     */
    protected function readitorHasUpvotedForLink(Votes $votes)
    {
        $votes
            ->givenTo($this->link, $this->readitor)
            ->willReturn(Vote::upvote($this->link, $this->readitor))
        ;
    }

    /**
     * @param Votes $votes
     */
    protected function readitorsVoteGetsUpdated(Votes $votes)
    {
        $votes->refresh(Argument::type(Vote::class))->shouldBeCalled();
    }

    /**
     * @param Links $links
     */
    protected function anUnknownLink(Links $links)
    {
        $links->withId(1)->willThrow(new UnknownLink());
    }
}
