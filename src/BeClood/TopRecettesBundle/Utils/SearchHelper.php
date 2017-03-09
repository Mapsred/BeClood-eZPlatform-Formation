<?php
/**
 * Created by PhpStorm.
 * User: francois
 * Date: 09/03/17
 * Time: 11:46
 */

namespace BeClood\TopRecettesBundle\Utils;

use eZ\Publish\API\Repository\Values\Content\Search\SearchResult;

class SearchHelper
{
    /**
     * @param SearchResult $searchResult
     * @return array
     */
    public function buildList(SearchResult $searchResult)
    {
        $list = array();
        foreach ($searchResult->searchHits as $searchHit) {
            $list[$searchHit->valueObject->id] = $searchHit->valueObject;
        }

        return $list;
    }
}