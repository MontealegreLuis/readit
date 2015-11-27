<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Links;

use Assert\Assertion;

/**
 * A Readitor can post links to the site. Links can be upvoted and downvoted by
 * other Readitors.
 * Links popularity decay 1 vote every five minutes.
 */
class Link
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $url;

    /** @var int */
    private $votes;

    /** @var ReaditorInformation */
    private $readitor;

    /** @var int */
    private $timestamp;

    /**
     * @param string $url
     * @param string $title
     * @param Readitor $readitor
     * @param int $timestamp
     */
    private function __construct($url, $title, Readitor $readitor, $timestamp)
    {
        $this->setUrl($url);
        $this->setTitle($title);
        $this->votes = 0;
        $this->readitor = $readitor;
        $this->timestamp = $timestamp;
    }

    /**
     * @param LinkInformation $information
     * @return Link
     */
    public static function from(LinkInformation $information)
    {
        $link = new Link(
            (string) $information->url(),
            $information->title(),
            Readitor::from($information->readitor()),
            $information->timestamp()
        );
        $link->id = $information->id();
        $link->votes = $information->votes();
        $link->readitor = Readitor::from($information->readitor());

        return $link;
    }

    /**
     * @param string $url
     * @param string $title
     * @param Readitor $readitor
     * @param int $timestamp
     * @return Link
     */
    public static function post($url, $title, Readitor $readitor, $timestamp)
    {
        return new Link($url, $title, $readitor, $timestamp);
    }

    /**
     * Add one vote to this link
     */
    public function upvote()
    {
        $this->votes++;
    }

    /**
     * Subtract one vote to this link
     */
    public function downvote()
    {
        $this->votes--;
    }

    /**
     * If a readitor toggles its vote, votes count should increase by 2 if vote,
     * was negative, it should decrease by 2 if it was positive.
     *
     * @param Vote $vote
     */
    public function toggle(Vote $vote)
    {
        if ($vote->isNegative()) {
            $this->votes += 2;
        } else {
            $this->votes -= 2;
        }
    }

    /**
     * Update this link count by adding or subtracting a vote, depending on its
     * vote type
     *
     * @param Vote $vote
     */
    public function cancel(Vote $vote)
    {
        if ($vote->isNegative()) {
            $this->upvote();
        } else {
            $this->downvote();
        }
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return LinkInformation
     */
    public function information()
    {
        return new LinkInformation([
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'votes' => $this->votes,
            'posted_at' => $this->timestamp,
            'readitor_id' => $this->readitor->information()->id(),
            'name' => $this->readitor->information()->name(),
        ]);
    }

    /**
     * @param string $url
     */
    private function setUrl($url)
    {
        Assertion::url($url, 'Only valid HTTP URLs are valid');
        $this->url = $url;
    }

    /**
     * @param string $title
     */
    private function setTitle($title)
    {
        Assertion::string($title, 'Link title should be text');
        Assertion::notEmpty($title, 'Link title should not be empty');
        $this->title = $title;
    }
}
