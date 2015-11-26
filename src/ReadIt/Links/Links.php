<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace CodeUp\ReadIt\Links;

/**
 * Persistence layer for links
 */
interface Links
{
    /**
     * @param LinkInformation $link
     * @return LinkInformation
     */
    public function add(LinkInformation $link);

    /**
     * @param LinkInformation $link
     */
    public function refresh(LinkInformation $link);

    /**
     * @param int $id
     * @return LinkInformation
     */
    public function withId($id);

    /**
     * @return LinkInformation[]
     */
    public function orderedByVotes();
}
