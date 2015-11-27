<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace spec\CodeUp\ReadIt\Links;

use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\Readitor;
use DateTime;
use PhpSpec\ObjectBehavior;

class VoteSpec extends ObjectBehavior
{
    /** @var Readitor */
    private $readitor;

    /** @var Link */
    private $link;

    function let()
    {
        $this->readitor = Readitor::with(1, 'Luis Montealegre');
        $this->link = Link::post(
            'http://www.montealegreluis.com',
            'My blog',
            $this->readitor,
            DateTime::createFromFormat('Y-m-d H:i:s', '2015-11-27 13:20:02')->getTimestamp()
        );
    }

    function it_shoul_create_a_downvote()
    {
        $this->beConstructedThrough('downvote', [$this->link, $this->readitor]);

        $this->isNegative()->shouldBe(true);
    }

    function it_shoul_create_an_upvote()
    {
        $this->beConstructedThrough('upvote', [$this->link, $this->readitor]);

        $this->isPositive()->shouldBe(true);
    }

    function it_should_switch_from_negative_to_positive()
    {
        $this->beConstructedThrough('downvote', [$this->link, $this->readitor]);

        $this->toggle();

        $this->isPositive()->shouldBe(true);
    }

    function it_should_switch_from_positive_to_negative()
    {
        $this->beConstructedThrough('upvote', [$this->link, $this->readitor]);

        $this->toggle();

        $this->isNegative()->shouldBe(true);
    }
}
