<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\Readitor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VoteSpec extends ObjectBehavior
{
    function it_shoul_create_a_downvote()
    {
        $readitor = Readitor::with(1, 'Luis Montealegre');
        $link = Link::post('http://www.montealegreluis.com', 'My blog', $readitor);

        $this->beConstructedThrough('downvote', [$link, $readitor]);

        $this->isNegative()->shouldBe(true);
    }

    function it_shoul_create_an_upvote()
    {
        $readitor = Readitor::with(1, 'Luis Montealegre');
        $link = Link::post('http://www.montealegreluis.com', 'My blog', $readitor);

        $this->beConstructedThrough('upvote', [$link, $readitor]);

        $this->isPositive()->shouldBe(true);
    }
}
