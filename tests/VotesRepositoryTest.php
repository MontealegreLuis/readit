<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Repositories;

use App\User;
use CodeUp\ReadIt\Links\Link;
use CodeUp\ReadIt\Links\Readitor;
use CodeUp\ReadIt\Links\Vote;
use CodeUp\ReadIt\Links\VoteInformation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class VotesRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function it_should_save_the_vote_of_a_readitor()
    {
        $vote = Vote::from(factory(VoteInformation::class, 'upvote')->make());
        $votes = new VotesRepository();

        $vote = $votes->add($vote);

        $this->seeInDatabase('votes', [
            'id' => $vote->id(),
            'link_id' => $vote->linkId(),
            'readitor_id' => $vote->readitorId(),
            'type' => $vote->type(),
        ]);
    }

    /** @test */
    function it_should_get_an_existing_readitor_vote()
    {
        $user = factory(User::class)->create();
        $readitor = Readitor::with($user->id, $user->name);
        $link = Link::post('http://www.montealegreluis.com', 'My blog', $readitor);
        $link = Link::from((new LinksRepository())->add($link->information()));
        $votes = new VotesRepository();
        $votes->add(Vote::upvote($link, $readitor));

        $vote = $votes->givenTo($link, $readitor);

        $this->assertInstanceOf(Vote::class, $vote);
    }

    /** @test */
    function it_should_retrieve_no_vote_if_readitor_has_not_voted_for_link()
    {
        $user = factory(User::class)->create();
        $readitor = Readitor::with($user->id, $user->name);
        $link = Link::post('http://www.montealegreluis.com', 'My blog', $readitor);
        $link = Link::from((new LinksRepository())->add($link->information()));
        $votes = new VotesRepository();

        $vote = $votes->givenTo($link, $readitor);

        $this->assertNull($vote);
    }

    /** @test */
    function it_should_remove_readitor_vote()
    {
        $user = factory(User::class)->create();
        $readitor = Readitor::with($user->id, $user->name);
        $link = Link::post('http://www.montealegreluis.com', 'My blog', $readitor);
        $link = Link::from((new LinksRepository())->add($link->information()));
        $votes = new VotesRepository();
        $votes->add($vote = Vote::upvote($link, $readitor));

        $votes->remove($vote);

        $this->notSeeInDatabase('votes', ['id' => $vote->id()]);
    }
}
