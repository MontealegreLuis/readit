<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Links;

class VoteInformation
{
    /** @var int */
    private $id;

    /** @var int */
    private $linkId;

    /** @var int */
    private $readitorId;

    /** @var int */
    private $type;

    /**
     * @param array $information
     */
    public function __construct(array $information)
    {
        isset($information['id']) && $this->id = $information['id'];
        isset($information['link_id']) && $this->linkId = $information['link_id'];
        isset($information['readitor_id']) && $this->readitorId = $information['readitor_id'];
        isset($information['type']) && $this->type = $information['type'];
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function linkId()
    {
        return $this->linkId;
    }

    /**
     * @return int
     */
    public function readitorId()
    {
        return $this->readitorId;
    }

    /**
     * @return int
     */
    public function type()
    {
        return $this->type;
    }
}
