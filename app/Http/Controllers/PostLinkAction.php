<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Http\Controllers;

use App\Http\Requests\PostLinkRequest;
use Auth;
use CodeUp\ReadIt\Links\Links;
use CodeUp\ReadIt\Links\Readitor;

class PostLinkAction extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('links.create');
    }

    /**
     * @param PostLinkRequest $request
     * @param Links $links
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PostLinkRequest $request, Links $links)
    {
        $readitor = Readitor::with(Auth::user()->id, Auth::user()->name);
        $link = $readitor->post(
            $request->get('url'),
            $request->get('title'),
            $request->server('REQUEST_TIME')
        );
        $links->add($link->information());

        return redirect('/');
    }
}
