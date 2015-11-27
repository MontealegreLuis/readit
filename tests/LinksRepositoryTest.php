<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Repositories;

use App\User;
use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\LinkInformation;
use CodeUp\ReadIt\Links\Readitor;
use DateTime;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class LinksRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @var User */
    private $user;

    /** @var Generator */
    private $generator;

    /** @before */
    function init()
    {
        $this->user = $this->getUserForReaditor();
        $this->generator = Factory::create();
    }

    /** @test */
    function it_should_add_a_posted_link()
    {
        $link = Link::post(
            'http://www.montealegreluis.com',
            'My Blog',
            Readitor::with($this->user->id, $this->user->name),
            DateTime::createFromFormat('Y-m-d H:i:s', '2015-11-27 13:20:02')->getTimestamp()
        );
        $links = new LinksRepository();

        $links->add($link->information());

        $this->seeInDatabase('links', [
            'url' => 'http://www.montealegreluis.com',
            'title' => 'My Blog',
            'votes' => 0,
            'readitor_id' => $this->user->id,
            'posted_at' => 1448630402,
        ]);
    }

    /** @test */
    function it_should_retrieve_all_posted_links_ordered_by_votes()
    {
        $timestamp = DateTime::createFromFormat('Y-m-d H:i:s', '2015-11-27 13:20:02')->getTimestamp();

        $links = new LinksRepository();
        // Rank = 99, link created 5 minutes ago
        $links->add($this->getLinkWith(100, -1, $timestamp));
        // Rank = 98, link created 7010 minutes ago (almost five days)
        $links->add($this->getLinkWith(1500, -1402, $timestamp));
        // Rank = 13, link created 10 minutes ago
        $links->add($this->getLinkWith(15, -2, $timestamp));
        // Rank = 9, link created 400 minutes ago (almost 7 hours)
        $links->add($this->getLinkWith(89, -80, $timestamp));

        $orderdedLinks = $links->orderedByVotes($timestamp);

        $this->assertEquals(100, $orderdedLinks[0]->votes());
        $this->assertEquals(1500, $orderdedLinks[1]->votes());
        $this->assertEquals(15, $orderdedLinks[2]->votes());
        $this->assertEquals(89, $orderdedLinks[3]->votes());
    }

    /** @test */
    function it_should_find_a_link_by_its_id()
    {
        $link = factory(LinkInformation::class)->make();
        $links = new LinksRepository();
        $link = $links->add($link);

        $foundLink = $links->withId($link->id());

        $this->assertEquals($link->id(), $foundLink->information()->id());
        $this->assertEquals($link->url(), $foundLink->information()->url());
        $this->assertEquals($link->title(), $foundLink->information()->title());
        $this->assertEquals($link->votes(), $foundLink->information()->votes());
    }

    /**
     * @test
     * @expectedException \CodeUp\ReadIt\Links\UnknownLink
     */
    function it_should_not_find_a_link_with_invalid_id()
    {
        $links = new LinksRepository();

        $links->withId($invalidId = 1000);
    }

    /**
     * @return User
     */
    private function getUserForReaditor()
    {
        return factory(User::class)->create();
    }

    /**
     * Generate a link with a `posted_at` value that will decay it `$votes`
     * votes if links are viewed at `$fromTime` timestamp.
     *
     * @param int $votes
     * @param int $decayingVotes
     * @param int $fromTime
     * @return LinkInformation
     */
    private function getLinkWith($votes, $decayingVotes, $fromTime)
    {
        return new LinkInformation([
            'url' => $this->generator->url,
            'title' => $this->generator->sentence(8),
            'votes' => $votes,
            'readitor_id' => $this->user->id,
            'name' => $this->user->name,
            'posted_at' => $this->timestampToDecay($fromTime, -$decayingVotes),
        ]);
    }

    /**
     * Calculates the timestamp that a link should have in order to decay
     * `$votes` votes.
     *
     * @param int $timestamp
     * @param int $votes
     * @return int
     */
    private function timestampToDecay($timestamp, $votes)
    {
        return $timestamp - $votes * 60 * 5;
    }
}
