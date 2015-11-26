<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use PhpSpec\ObjectBehavior;

class ReaditorInformationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([
            'readitor_id' => 1,
            'name' => 'Luis Montealegre'
        ]);
    }

    function it_should_know_its_id()
    {
        $this->id()->shouldBe(1);
    }

    function it_should_know_its_name()
    {
        $this->name()->shouldBe('Luis Montealegre');
    }
}
