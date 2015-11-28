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
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var HttpUri */
    private $url;

    /** @var int */
    private $timestamp;

    /** @var int */
    private $votes;

    /** @var  ReaditorInformation */
    private $readitor;

    /** @var Vote */
    private $existingVote;

    /**
     * @param array $information
     */
    public function __construct(array $information)
    {
        isset($information['id']) && $this->id = $information['id'];
        isset($information['title']) && $this->title = $information['title'];
        isset($information['url']) && $this->url = HttpUri::createFromString($information['url']);
        isset($information['posted_at']) && $this->timestamp = $information['posted_at'];
        isset($information['votes']) && $this->votes = $information['votes'];
        !empty($information['current_readitor']) && $this->existingVote = Vote::from(new VoteInformation([
            'link_id' => $information['link_id'],
            'readitor_id' => $information['current_readitor'],
            'type' => $information['type'],
        ]));
        $this->readitor = new ReaditorInformation($information);
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
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

    /**
     * @return int
     */
    public function timestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int $current
     * @return int
     */
    public function days($current)
    {
        return round(($current - $this->timestamp) / (24 * 60 * 60));
    }


    /**
     * @return ReaditorInformation
     */
    public function readitor()
    {
        return $this->readitor;
    }

    /**
     * @return bool
     */
    public function hasBeenVotedByCurrentReaditor()
    {
        return $this->existingVote instanceof Vote;
    }

    /**
     * @return Vote
     */
    public function existingVote()
    {
        return $this->existingVote;
    }
}
