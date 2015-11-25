<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class LinkSpec extends ObjectBehavior
{
    function it_should_only_allow_http_uris()
    {
        $this->beConstructedThrough('post', [
            'ftp://www.montealegreluis.com',
            'My blog'
        ]);
        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->duringInstantiation()
        ;
    }

    function it_should_not_allow_empty_titles()
    {
        $this->beConstructedThrough('post', [
            'http://www.montealegreluis.com',
            ''
        ]);
        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->duringInstantiation()
        ;
    }

    function it_should_know_its_identifier()
    {
        $this->beConstructedThrough('post', [
            'http://www.montealegreluis.com',
            'My blog'
        ]);

        $this->id()->shouldBeNull();
    }

    function it_should_allow_adding_votes()
    {
        $this->beConstructedThrough('post', [
            'http://www.montealegreluis.com',
            'My blog'
        ]);
        $this->upvote();
        $this->upvote();
        $this->information()->votes()->shouldBe(2);
    }

    function it_should_allow_subtracting_votes()
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
