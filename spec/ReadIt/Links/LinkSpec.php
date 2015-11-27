<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use CodeUp\ReadIt\Links\Readitor;
use CodeUp\ReadIt\Links\Vote;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class LinkSpec extends ObjectBehavior
{
    /** @var Readitor */
    private $readitor;

    function let()
    {
        $this->readitor = Readitor::with(1, 'Luis Montealegre');
        $this->beConstructedThrough('post', [
            'http://www.montealegreluis.com',
            'My blog',
            $this->readitor
        ]);
    }

    function it_should_only_allow_http_uris(Readitor $readitor)
    {
        $this->beConstructedThrough('post', [
            $invalidURL = 'ftp://www.montealegreluis.com',
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
            $invalidTitle = '',
            $readitor
        ]);
        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->duringInstantiation()
        ;
    }

    function it_should_know_its_identifier()
    {
        $this->id()->shouldBeNull();
    }

    function it_should_allow_adding_votes()
    {
        $this->upvote();
        $this->upvote();
        $this->information()->votes()->shouldBe(2);
    }

    function it_should_allow_subtracting_votes()
    {
        $this->downvote();
        $this->downvote();
        $this->information()->votes()->shouldBe(-2);
    }

    function it_should_toggle_a_downvote()
    {
        $this->downvote();
        $this->toggle(Vote::downvote($this->getWrappedObject(), $this->readitor));
        $this->information()->votes()->shouldBe(1);
    }

    function it_should_toggle_an_upvote()
    {
        $this->upvote();
        $this->toggle(Vote::upvote($this->getWrappedObject(), $this->readitor));
        $this->information()->votes()->shouldBe(-1);
    }

    function it_should_cancel_an_upvote()
    {
        $this->upvote();
        $this->cancel(Vote::upvote($this->getWrappedObject(), $this->readitor));
        $this->information()->votes()->shouldBe(0);
    }

    function it_should_cancel_a_downvote()
    {
        $this->downvote();
        $this->cancel(Vote::downvote($this->getWrappedObject(), $this->readitor));
        $this->information()->votes()->shouldBe(0);
    }
}
