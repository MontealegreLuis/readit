<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LinkSpec extends ObjectBehavior
{
    function it_should_allow_adding_a_vote()
    {
        $this->beConstructedThrough('post', [
            'http://www.montealegreluis.com',
            'My blog'
        ]);
        $this->upvote();
        $this->upvote();
        $this->information()->votes()->shouldBe(2);
    }

    function it_should_allow_subtracting_a_vote()
    {
        $this->beConstructedThrough('post', [
            'http://www.montealegreluis.com',
            'My blog'
        ]);
        $this->downvote();
        $this->downvote();
        $this->information()->votes()->shouldBe(-2);
    }
}
