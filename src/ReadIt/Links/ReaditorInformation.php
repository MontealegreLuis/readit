<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Links;

class ReaditorInformation
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /**
     * @param array $information
     */
    public function __construct(array $information)
    {
        isset($information['id']) && $this->id = $information['id'];
        isset($information['name']) && $this->name = $information['name'];
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
