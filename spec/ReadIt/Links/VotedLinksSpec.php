<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VotedLinksSpec extends ObjectBehavior
{
    function it_should_be_created_empty()
    {
        $this->beConstructedThrough('withoutLinks');
        $this->count()->shouldBe(0);
    }

    function it_should_be_created_with_a__set_of_links_IDs()
    {
        $this->beConstructedThrough('withLinks', [[1, 2, 3]]);
        $this->count()->shouldBe(3);
    }

    function it_should_know_if_a_given_id_is_already_voted()
    {
        $this->beConstructedThrough('withLinks', [[1, 2, 3]]);
        $this->contains(2)->shouldBe(true);
    }

    function it_should_add_a_new_voted_link()
    {
        $this->beConstructedThrough('withoutLinks');
        $this->add(2);
        $this->contains(2)->shouldBe(true);
    }
}
