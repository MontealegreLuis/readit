<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Readitors;

use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\LinkInformation;
use CodeUp\ReadIt\Links\Links;
use CodeUp\ReadIt\Links\Readitor;
use CodeUp\ReadIt\Links\UnknownLink;
use CodeUp\ReadIt\Links\Vote;
use CodeUp\ReadIt\Links\Votes;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpvoteLinkSpec extends ObjectBehavior
{
    function let(Links $links, Votes $votes)
    {
        $this->beConstructedWith($links, $votes);
    }

    function it_should_upvote_a_link(Links $links, Votes $votes)
    {
        $readitor = Readitor::with(1, 'Luis Montealegre');
        $link = Link::from(new LinkInformation([
            'id' => 1,
            'votes' => 10,
            'url' => 'http://www.montealegreluis.com',
            'title' => 'My blog',
        ]));

        // Given
        $this->anExistingLink($links, $link);
        $this->readitorHasNotVotedForLink($votes, $link, $readitor);

        // Then
        $this->linkGetsUpdated($links);
        $this->linkIsAddedToReaditorsVotes($votes);

        // When
        $this->upvote(1, $readitor);
    }

    function it_should_remove_vote_if_link_was_previously_upvoted(
        Links $links,
        Votes $votes
    ) {
        $readitor = Readitor::with(1, 'Luis Montealegre');
        $link = Link::from(new LinkInformation([
            'id' => 1,
            'votes' => 10,
            'url' => 'http://www.montealegreluis.com',
            'title' => 'My blog',
        ]));

        // Given
        $this->anExistingLink($links, $link);
        $this->readitorHasUpvotedForLink($votes, $link, $readitor);

        // Then
        $this->linkGetsUpdated($links);
        $this->linkIsRemovedFromReaditorsVotes($votes);

        // When
        $this->upvote(1, $readitor);
    }

    function it_should_fail_if_link_is_unknown(Links $links)
    {
        $readitor = Readitor::with(1, 'Luis Montealegre');

        // Given
        $this->anUnknownLink($links);

        // When
        $this->shouldThrow(UnknownLink::class)->duringUpvote(1, $readitor);
    }

    /**
     * @param Votes $votes
     * @param Link $link
     * @param $readitor
     */
    private function readitorHasNotVotedForLink(
        Votes $votes,
        Link $link,
        Readitor $readitor
    ) {
        $votes->givenTo($link, $readitor)->willReturn(null);
    }

    /**
     * @param Votes $votes
     * @param Link $link
     * @param Readitor $readitor
     */
    private function readitorHasUpvotedForLink(
        Votes $votes,
        Link $link,
        Readitor $readitor
    ) {
        $votes
            ->givenTo($link, $readitor)
            ->willReturn(Vote::upvote($link, $readitor))
        ;
    }

    /**
     * @param Links $links
     * @param Link $link
     */
    private function anExistingLink(Links $links, Link $link)
    {
        $links->withId(1)->willReturn($link);
    }

    /**
     * @param Links $links
     */
    private function anUnknownLink(Links $links)
    {
        $links->withId(1)->willThrow(new UnknownLink());
    }

    /**
     * @param Links $links
     */
    private function linkGetsUpdated(Links $links)
    {
        $links->refresh(Argument::type(LinkInformation::class))->shouldBeCalled();
    }

    /**
     * @param Links $links
     * @param Link $link
     * @param $linkInformation
     */
    private function linkGetsAnDownvote(
        Links $links,
        Link $link,
        LinkInformation $linkInformation
    ) {
        $link->downvote()->shouldBeCalled();
        $links->refresh($linkInformation)->shouldBeCalled();
    }

    /**
     * @param Votes $votes
     */
    private function linkIsAddedToReaditorsVotes(Votes $votes)
    {
        $votes->add(Argument::type(Vote::class))->shouldBeCalled();
    }

    /**
     * @param Votes $votes
     */
    private function linkIsRemovedFromReaditorsVotes(Votes $votes)
    {
        $votes->remove(Argument::type(Vote::class))->shouldBeCalled();
    }
}
