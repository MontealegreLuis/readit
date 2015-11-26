<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use CodeUp\ReadIt\Links\AlreadyVotedForLink;
use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\ReaditorInformation;
use CodeUp\ReadIt\Links\VotedLinks;
use PhpSpec\ObjectBehavior;

class ReaditorSpec extends ObjectBehavior
{
    function let(VotedLinks $votedLinks)
    {
        $this->beConstructedWith($votedLinks);
    }

    function it_should_upvote_a_link(Link $link)
    {
        $this->upvoteLink($link);

        $link->upvote()->shouldHaveBeenCalled();
    }

    function it_should_downvote_a_link(Link $link)
    {
        $this->downvoteLink($link);

        $link->downvote()->shouldHaveBeenCalled();
    }

    function it_cannot_vote_twice_for_the_same_link(
        VotedLinks $votedLinks,
        ReaditorInformation $readitor
    ) {
        $link = Link::post(
            'http://www.montealegreluis.com',
            'My blog',
            $readitor->getWrappedObject()
        );
        $votedLinks->contains(null)->willReturn(true);

        $this->shouldThrow(AlreadyVotedForLink::class)->duringUpvoteLink($link);
    }
}
