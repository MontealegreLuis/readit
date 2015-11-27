<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Links;

/**
 * Persistence layer for votes
 */
interface Votes
{
    /**
     * @param Link $link
     * @param Readitor $byReaditor
     * @return Vote|null
     */
    public function givenTo(Link $link, Readitor $byReaditor);

    /**
     * @param Vote $vote
     */
    public function add(Vote $vote);

    /**
     * @param Vote $vote
     */
    public function remove(Vote $vote);

    /**
     * @param Vote $vote
     */
    public function refresh(Vote $vote);
}
