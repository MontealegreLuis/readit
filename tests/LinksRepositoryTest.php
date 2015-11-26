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
use CodeUp\ReadIt\Links\ReaditorInformation;
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
            new ReaditorInformation($user->id, $user->name)
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
        $links->add($this->getPostedLink($faker, 100, $user));
        $links->add($this->getPostedLink($faker, 1500, $user));
        $links->add($this->getPostedLink($faker, 15, $user));
        $links->add($this->getPostedLink($faker, 89, $user));

        $orderdedLinks = $links->orderedByVotes();

        $this->assertEquals(1500, $orderdedLinks[0]->votes());
        $this->assertEquals(100, $orderdedLinks[1]->votes());
        $this->assertEquals(89, $orderdedLinks[2]->votes());
        $this->assertEquals(15, $orderdedLinks[3]->votes());
    }

    /**
     * @return User
     */
    private function getUserForReaditor()
    {
        $user = factory(User::class)->make();
        $user->save();

        return $user;
    }

    /**
     * @param Generator $faker
     * @param int $votes
     * @param User $user
     * @return LinkInformation
     */
    private function getPostedLink(Generator $faker, $votes, User $user)
    {
        return new LinkInformation([
            'url' => $faker->url,
            'title' => $faker->sentence(8),
            'votes' => $votes,
            'readitor_id' => $user->id,
            'name' => $user->name,
        ]);
    }
}