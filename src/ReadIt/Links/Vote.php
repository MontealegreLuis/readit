<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Links;

/**
 * Each Readitor will have a reference to all the votes, positive and negative,
 * given to other readitors links.
 */
class Vote
{
    /** @var int */
    private $id;

    /** @var int */
    private $linkId;

    /** @var int */
    private $readitorId;

    /** @var int */
    private $type;

    const POSITIVE = 1;
    const NEGATIVE = -1;

    /**
     * @param int $linkId
     * @param int $readitorId
     * @param int $type
     */
    private function __construct($linkId, $readitorId, $type)
    {
        $this->linkId = $linkId;
        $this->readitorId = $readitorId;
        $this->type = $type;
    }

    /**
     * @param Link $link
     * @param Readitor $readitor
     * @return Vote
     */
    public static function upvote(Link $link, Readitor $readitor)
    {
        return new Vote($link->id(), $readitor->id(), Vote::POSITIVE);
    }

    /**
     * @param Link $link
     * @param Readitor $readitor
     * @return Vote
     */
    public static function downvote(Link $link, Readitor $readitor)
    {
        return new Vote($link->id(), $readitor->id(), Vote::NEGATIVE);
    }

    /**
     * @param VoteInformation $information
     * @return Vote
     */
    public static function from(VoteInformation $information)
    {
        $vote = new Vote(
            $information->linkId(),
            $information->readitorId(),
            $information->type()
        );
        $vote->id = $information->id();

        return $vote;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return VoteInformation
     */
    public function information()
    {
        return new VoteInformation([
            'id' => $this->id,
            'link_id' => $this->linkId,
            'readitor_id' => $this->readitorId,
            'type' => $this->type,
        ]);
    }

    /**
     * @return bool
     */
    public function isPositive()
    {
        return $this->type === Vote::POSITIVE;
    }

    /**
     * @return bool
     */
    public function isNegative()
    {
        return $this->type === Vote::NEGATIVE;
    }

    /**
     * Toggle this vote type
     */
    public function toggle()
    {
        $this->type *= -1;
    }
}
