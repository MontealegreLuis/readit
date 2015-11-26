<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class PostLinkActionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function it_should_post_a_link_to_the_site()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->visit('/links/create')
            ->type('http://www.montealegreluis.com', 'url')
            ->type('My blog', 'title')
            ->press('Send')
            ->seePageIs('/')
            ->see('My blog')
            ->seeInDatabase('links', [
                'url' => 'http://www.montealegreluis.com',
                'title' => 'My Blog',
                'votes' => 0,
                'readitor_id' => $user->id
            ])
        ;
    }
}
