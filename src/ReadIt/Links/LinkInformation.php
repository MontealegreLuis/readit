<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Links;

/**
 * Contains the information of a shared Link
 */
class LinkInformation
{
    /** @var string */
    private $title;

    /** @var string */
    private $url;

    /** @var int */
    private $votes;

    /**
     * @param array $information
     */
    public function __construct(array $information)
    {
        isset($information['title']) && $this->title = $information['title'];
        isset($information['url']) && $this->url = $information['url'];
        isset($information['votes']) && $this->votes = $information['votes'];
    }

    /**
     * @return int The current amount of votes that this links has
     */
    public function votes()
    {
        return $this->votes;
    }

    /**
     * @return string The title to show for the link
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return string The URL for this link
     */
    public function url()
    {
        return $this->url;
    }
}
