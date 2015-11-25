<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Links;

use League\Uri\Schemes\Http as HttpUri;

/**
 * Contains the information of a shared Link
 */
class LinkInformation
{
    /** @var string */
    private $title;

    /** @var HttpUri */
    private $url;

    /** @var int */
    private $votes;

    /**
     * @param array $information
     */
    public function __construct(array $information)
    {
        isset($information['title']) && $this->title = $information['title'];
        isset($information['url']) && $this->url = HttpUri::createFromString($information['url']);
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
     * @return HttpUri The URL for this link
     */
    public function url()
    {
        return $this->url;
    }
}
