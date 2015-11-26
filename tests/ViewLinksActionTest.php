<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Controllers;

use App\Repositories\LinksRepository;
use CodeUp\ReadIt\Links\LinkInformation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class ViewLinksActionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_should_show_the_list_of_posted_links()
    {
        $links = new LinksRepository();
        $links->add(factory(LinkInformation::class)->make());
        $links->add(factory(LinkInformation::class)->make());
        $links->add(factory(LinkInformation::class)->make());
        $links->add(factory(LinkInformation::class)->make());
        $links->add(factory(LinkInformation::class)->make());

        $response = $this->call('GET', '/');
        $data = $response->original->getData();

        $this->assertViewHas('links');
        $this->assertInternalType('array', $data['links']);
        $this->assertCount(5, $data['links']);
        $this->assertContainsOnlyInstancesOf(LinkInformation::class, $data['links']);
    }
}
