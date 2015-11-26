<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use CodeUp\ReadIt\Links\ReaditorInformation;
use League\Uri\Schemes\Http as HttpUri;
use PhpSpec\ObjectBehavior;

class LinkInformationSpec extends ObjectBehavior
{
    function it_should_know_how_many_votes_it_has()
    {
        $this->beConstructedWith(['votes' => 100]);

        $this->votes()->shouldBe(100);
    }

    function it_should_know_its_title()
    {
        $this->beConstructedWith(['title' => 'My blog']);

        $this->title()->shouldBe('My blog');
    }

    function it_should_know_its_url()
    {
        $this->beConstructedWith([
            'url' => 'http://www.montealegreluis.com'
        ]);

        $this->url()->shouldBeAnInstanceOf(HttpUri::class);
        $this->url()->__toString()->shouldBe('http://www.montealegreluis.com');
    }

    function it_should_know_its_id()
    {
        $this->beConstructedWith(['id' => 100]);

        $this->id()->shouldBe(100);
    }

    function it_should_know_its_readitor()
    {
        $this->beConstructedWith([
            'readitor_id' => 1,
            'name' => 'Luis Montealegre',
        ]);

        $this->readitor()->shouldBeAnInstanceOf(ReaditorInformation::class);
    }
}
