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
use DateTime;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class VotesRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @var Link */
    private $link;

    /** @var Readitor */
    private $readitor;

    /** @before */
    function init()
    {
        $user = factory(User::class)->create();
        $this->readitor = Readitor::with($user->id, $user->name);
        $this->link = Link::post(
            'http://www.montealegreluis.com',
            'My blog',
            $this->readitor,
            DateTime::createFromFormat('Y-m-d H:i:s', '2015-11-27 13:20:02')->getTimestamp()
        );
    }

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
        $link = Link::from((new LinksRepository())->add($this->link->information()));
        $votes = new VotesRepository();
        $votes->add(Vote::upvote($link, $this->readitor));

        $vote = $votes->givenTo($link, $this->readitor);

        $this->assertInstanceOf(Vote::class, $vote);
    }

    /** @test */
    function it_should_retrieve_no_vote_if_readitor_has_not_voted_for_link()
    {
        $link = Link::from((new LinksRepository())->add($this->link->information()));
        $votes = new VotesRepository();

        $vote = $votes->givenTo($link, $this->readitor);

        $this->assertNull($vote);
    }

    /** @test */
    function it_should_remove_readitor_vote()
    {
        $link = Link::from((new LinksRepository())->add($this->link->information()));
        $votes = new VotesRepository();
        $votes->add($vote = Vote::upvote($link, $this->readitor));

        $votes->remove($vote);

        $this->notSeeInDatabase('votes', ['id' => $vote->id()]);
    }
}
