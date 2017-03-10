<?php
/**
 * Created by PhpStorm.
 * User: francois
 * Date: 10/03/17
 * Time: 12:00
 */

namespace BeClood\TopRecettesBundle\Utils;


use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ChainConfigResolver;
use eZ\Publish\API\Repository\Repository;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\ValueObject;

class RecettesHelper
{
    /** @var Repository $repository */
    private $repository;
    /** @var SearchHelper $searchHelper */
    private $searchHelper;
    /** @var ChainConfigResolver $configResolver */
    private $configResolver;

    /**
     * RecettesHelper constructor.
     * @param Repository $repository
     * @param SearchHelper $searchHelper
     * @param ChainConfigResolver $configResolver
     */
    public function __construct(Repository $repository, SearchHelper $searchHelper, ChainConfigResolver $configResolver)
    {
        $this->repository = $repository;
        $this->searchHelper = $searchHelper;
        $this->configResolver = $configResolver;
    }

    /**
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return SearchHelper
     */
    public function getSearchHelper()
    {
        return $this->searchHelper;
    }

    /**
     * @return ChainConfigResolver
     */
    public function getConfigResolver()
    {
        return $this->configResolver;
    }

    /**
     * @return array|ValueObject[]
     */
    public function getLastRecettes()
    {
        $searchService = $this->getRepository()->getSearchService();
        $query = new Query([
            'filter' => new Query\Criterion\ContentTypeIdentifier('recette'),
            'sortClauses' => [new Query\SortClause\DatePublished(Query::SORT_DESC)],
            'limit' => $this->getConfigResolver()->getParameter('content.max_recettes.setting', 'beclood_top_recettes')
        ]);

        return $this->getSearchHelper()->buildList($searchService->findContent($query));
    }



}