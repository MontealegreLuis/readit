<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Links;

/**
 * A Readitor can post links to the site, and upvote and downvote other
 * readitors links.
 */
class Readitor
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /**
     * @param int $id
     * @param string $name
     */
    private function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param ReaditorInformation $information
     * @return Readitor
     */
    public static function from(ReaditorInformation $information)
    {
        return new Readitor($information->id(), $information->name());
    }

    /**
     * @param int $id
     * @param string $name
     * @return Readitor
     */
    public static function with($id, $name)
    {
        return new Readitor($id, $name);
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return ReaditorInformation
     */
    public function information()
    {
        return new ReaditorInformation([
            'readitor_id' => $this->id,
            'name' => $this->name,
        ]);
    }

    /**
     * @param string $url
     * @param string $title
     * @return Link
     */
    public function post($url, $title)
    {
        return Link::post($url, $title, $this);
    }

    /**
     * @param Link $link
     * @return Vote
     */
    public function upvoteLink(Link $link)
    {
        $link->upvote();

        return Vote::upvote($link, $this);
    }

    /**
     * @param Link $link
     * @return Vote
     */
    public function downvoteLink(Link $link)
    {
        $link->downvote();

        return Vote::downvote($link, $this);
    }

    /**
     * It cancel either an upvote or a downvote by updating a link's votes count
     *
     * @param Link $link
     * @param Vote $vote
     */
    public function cancelVote(Link $link, Vote $vote)
    {
        $link->cancel($vote);
    }

    /**
     * It toggles upvotes and downvotes and updates link's votes count
     *
     * @param Link $link
     * @param Vote $vote
     */
    public function toggleVote(Link $link, Vote $vote)
    {
        $link->toggle($vote);
        $vote->toggle();
    }
}
