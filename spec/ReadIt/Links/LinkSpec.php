<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use CodeUp\ReadIt\Links\Readitor;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class LinkSpec extends ObjectBehavior
{
    function it_should_only_allow_http_uris(Readitor $readitor)
    {
        $this->beConstructedThrough('post', [
            'ftp://www.montealegreluis.com',
            'My blog',
            $readitor,
        ]);
        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->duringInstantiation()
        ;
    }

    function it_should_not_allow_empty_titles(Readitor $readitor)
    {
        $this->beConstructedThrough('post', [
            'http://www.montealegreluis.com',
            '',
            $readitor
        ]);
        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->duringInstantiation()
        ;
    }

    function it_should_know_its_identifier(Readitor $readitor)
    {
        $this->beConstructedThrough('post', [
            'http://www.montealegreluis.com',
            'My blog',
            $readitor
        ]);

        $this->id()->shouldBeNull();
    }

    function it_should_allow_adding_votes(Readitor $readitor)
    {
        $this->beConstructedThrough('post', [
            'http://www.montealegreluis.com',
            'My blog',
            $readitor
        ]);
        $this->upvote();
        $this->upvote();
        $this->information()->votes()->shouldBe(2);
    }

    function it_should_allow_subtracting_votes(Readitor $readitor)
    {
        $this->beConstructedThrough('post', [
            'http://www.montealegreluis.com',
            'My blog',
            $readitor
        ]);
        $this->downvote();
        $this->downvote();
        $this->information()->votes()->shouldBe(-2);
    }
}
