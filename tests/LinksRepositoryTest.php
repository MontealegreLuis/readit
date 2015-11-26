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
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class LinksRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function it_should_add_a_posted_link()
    {
        $user = $this->getUserForReaditor();
        $link = Link::post(
            'http://www.montealegreluis.com',
            'My Blog',
            Readitor::with($user->id, $user->name)
        );
        $links = new LinksRepository();

        $links->add($link->information());

        $this->seeInDatabase('links', [
            'url' => 'http://www.montealegreluis.com',
            'title' => 'My Blog',
            'votes' => 0,
            'readitor_id' => $user->id
        ]);
    }

    /** @test */
    function it_should_retrieve_all_posted_links_ordered_by_votes()
    {
        $user = $this->getUserForReaditor();
        $faker = Factory::create();
        $links = new LinksRepository();
        $links->add($this->getLinkWithVotes($faker, 100, $user));
        $links->add($this->getLinkWithVotes($faker, 1500, $user));
        $links->add($this->getLinkWithVotes($faker, 15, $user));
        $links->add($this->getLinkWithVotes($faker, 89, $user));

        $orderdedLinks = $links->orderedByVotes();

        $this->assertEquals(1500, $orderdedLinks[0]->votes());
        $this->assertEquals(100, $orderdedLinks[1]->votes());
        $this->assertEquals(89, $orderdedLinks[2]->votes());
        $this->assertEquals(15, $orderdedLinks[3]->votes());
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

    /** @test */
    function it_should_not_find_a_link_with_invalid_id()
    {
        $links = new LinksRepository();

        $link = $links->withId($invalidId = 1000);

        $this->assertNull($link);
    }

    /**
     * @return User
     */
    private function getUserForReaditor()
    {
        return factory(User::class)->create();
    }

    /**
     * @param Generator $faker
     * @param int $votes
     * @param User $user
     * @return LinkInformation
     */
    private function getLinkWithVotes(Generator $faker, $votes, User $user)
    {
        return new LinkInformation([
            'url' => $faker->url,
            'title' => $faker->sentence(8),
            'votes' => $votes,
            'readitor' => Readitor::with($user->id, $user->name)->information(),
        ]);
    }
}
