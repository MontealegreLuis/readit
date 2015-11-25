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

    /**
     * @param string $url
     * @param string $title
     */
    private function __construct($url, $title)
    {
        $this->setUrl($url);
        $this->setTitle($title);
        $this->votes = 0;
    }

    /**
     * @param string $url
     * @param string $title
     * @return Link
     */
    public static function post($url, $title)
    {
        return new Link($url, $title);
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
     * @return LinkInformation
     */
    public function information()
    {
        return new LinkInformation([
            'title' => $this->title,
            'url' => $this->url,
            'votes' => $this->votes,
        ]);
    }

    /**
     * @param string $url
     */
    private function setUrl($url)
    {
        Assertion::url($url);
        $this->url = $url;
    }

    /**
     * @param string $title
     */
    private function setTitle($title)
    {
        Assertion::string($title);
        Assertion::notEmpty($title);
        $this->title = $title;
    }
}
