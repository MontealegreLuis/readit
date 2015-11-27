<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Http\Controllers;

use CodeUp\ReadIt\Links\Links;
use Illuminate\Http\Request;

class ViewLinksAction extends Controller
{
    /** @var Links */
    private $links;

    /**
     * @param Links $links
     */
    public function __construct(Links $links)
    {
        $this->links = $links;
    }

    /**
     * Show all the posted links, the ones with more votes are shown first
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('links.index', [
            'links' => $this->links->orderedByVotes(),
            'current' => $request->server('REQUEST_TIME'),
        ]);
    }
}
