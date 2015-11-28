<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Http\Controllers;

use Auth;
use CodeUp\ReadIt\Links\Readitor;
use CodeUp\ReadIt\Links\UnknownLink;
use CodeUp\ReadIt\Readitors\VoteLink;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VoteLinkAction extends Controller
{
    /** @var VoteLink */
    private $action;

    /**
     * Guest users cannot vote for links
     *
     * @param VoteLink $voteLink
     */
    public function __construct(VoteLink $voteLink)
    {
        $this->action = $voteLink;
        $this->middleware('auth');
    }

    /**
     * @param int $linkId
     * @return \CodeUp\ReadIt\Links\LinkInformation
     */
    public function vote($linkId)
    {
        try {
            $link = $this->action->vote(
                $linkId,
                Readitor::with(Auth::user()->id, Auth::user()->name)
            );

            return ['votes' => $link->information()->votes()];
        } catch (UnknownLink $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
