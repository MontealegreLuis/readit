<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Http\Controllers;

use Auth;
use CodeUp\ReadIt\Links\Links;
use CodeUp\ReadIt\Links\Readitor;
use CodeUp\ReadIt\Links\UnknownLink;
use CodeUp\ReadIt\Readitors\UpvoteLink;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpvoteLinkAction extends Controller
{
    /** @var Links */
    private $action;

    /**
     * @param UpvoteLink $upvoteLink
     */
    public function __construct(UpvoteLink $upvoteLink)
    {
        $this->action = $upvoteLink;
    }

    /**
     * @param int $linkId
     * @return \CodeUp\ReadIt\Links\LinkInformation
     */
    public function upvote($linkId)
    {
        try {
            $link = $this->action->upvote(
                $linkId,
                Readitor::with(Auth::user()->id, Auth::user()->name)
            );

            return ['votes' => $link->information()->votes()];
        } catch (UnknownLink $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
