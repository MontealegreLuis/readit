<?php

namespace CodeUp\ReadIt\Links;

use Countable;

/**
 * Collection that stores all the links voted by a Readitor
 */
class VotedLinks implements Countable
{
    /** @var int[] */
    private $linksIds;

    /**
     * @param array $linksIds
     */
    private function __construct(array $linksIds)
    {
        $this->linksIds = $linksIds;
    }

    /**
     * Add the IDs given to this collection
     *
     * @param int[] $linksIds
     * @return VotedLinks
     */
    public static function withLinks(array $linksIds)
    {
        return new VotedLinks($linksIds);
    }

    /**
     * Create a collection without elements
     *
     * @return VotedLinks
     */
    public static function withoutLinks()
    {
        return new VotedLinks([]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->linksIds);
    }

    /**
     * @param integer $linkId
     * @return bool
     */
    public function contains($linkId)
    {
        return false !== array_search($linkId, $this->linksIds);
    }

    /**
     * @param int $linkId
     */
    public function add($linkId)
    {
        $this->linksIds[] = $linkId;
    }
}
