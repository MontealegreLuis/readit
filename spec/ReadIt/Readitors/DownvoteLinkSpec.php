<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Readitors;

use CodeUp\ReadIt\Links\Links;
use CodeUp\ReadIt\Links\UnknownLink;
use CodeUp\ReadIt\Links\Votes;
use PhpSpec\Specs\VoteLinkSpec;
use Prophecy\Argument;

class DownvoteLinkSpec extends VoteLinkSpec
{
    function it_should_downvote_a_link(Links $links, Votes $votes)
    {
        // Given
        $this->anExistingLink($links);
        $this->readitorHasNotVotedForLink($votes);

        // Then
        $this->linkGetsUpdated($links);
        $this->linkIsAddedToReaditorsVotes($votes);

        // When
        $this->vote(1, $this->readitor);
    }

    function it_should_cancel_a_previous_downvote(Links $links, Votes $votes)
    {
        // Given
        $this->anExistingLink($links);
        $this->readitorHasDownvotedForLink($votes);

        // Then
        $this->linkGetsUpdated($links);
        $this->linkIsRemovedFromReaditorsVotes($votes);

        // When
        $this->vote(1, $this->readitor);
    }

    function it_should_toggle_a_vote(Links $links, Votes $votes)
    {
        // Given
        $this->anExistingLink($links);
        $this->readitorHasUpvotedForLink($votes);

        // Then
        $this->linkGetsUpdated($links);
        $this->readitorsVoteGetsUpdated($votes);

        // When
        $this->vote(1, $this->readitor);
    }

    function it_should_fail_if_link_is_unknown(Links $links)
    {
        // Given
        $this->anUnknownLink($links);

        // When
        $this->shouldThrow(UnknownLink::class)->duringVote(1, $this->readitor);
    }
}
