<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\Vote;
use DateTime;
use PhpSpec\ObjectBehavior;

class ReaditorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('with', [1, 'Luis Montealegre']);
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

    function it_should_post_a_link()
    {
        $link = $this->post(
            'http://www.montealegreluis.com',
            'My blog',
            DateTime::createFromFormat('Y-m-d H:i:s', '2015-11-27 13:20:02')->getTimestamp()
        );
        $link->information()->url()->__toString()->shouldBe('http://www.montealegreluis.com');
        $link->information()->title()->shouldBe('My blog');
        $link->information()->readitor()->name()->shouldBe('Luis Montealegre');
        $link->information()->readitor()->id()->shouldBe(1);
    }

    function it_should_cancel_a_vote(Link $link, Vote $vote)
    {
        $vote->isNegative()->willReturn(false);

        $this->cancelVote($link, $vote);

        $link->cancel($vote)->shouldHaveBeenCalled();
    }
}
