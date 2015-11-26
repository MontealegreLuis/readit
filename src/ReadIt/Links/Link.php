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

    /**
     * @param string $url
     * @param string $title
     * @param Readitor $readitor
     */
    private function __construct($url, $title, Readitor $readitor)
    {
        $this->setUrl($url);
        $this->setTitle($title);
        $this->votes = 0;
        $this->readitor = $readitor;
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
            Readitor::from($information->readitor())
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
     * @return Link
     */
    public static function post($url, $title, Readitor $readitor)
    {
        return new Link($url, $title, $readitor);
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
            'readitor_id' => $this->readitor->information()->id(),
            'name' => $this->readitor->information()->name(),
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
