<?php
/**
 * Created by PhpStorm.
 * User: francois
 * Date: 08/03/17
 * Time: 11:14
 */

namespace BeClood\TopRecettesBundle\Controller;

use eZ\Publish\API\Repository\Values\Content\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class EzPlatformController extends Controller
{
    /**
     * @param $id
     * @return Response
     */
    public function ApiAction($id)
    {
        $final = [];
        $contentService = $this->get('ezpublish.api.repository')->getContentService();
        $locationService = $this->get('ezpublish.api.repository')->getLocationService();
        $content = $contentService->loadContent($id);
        $final['attributes'] = $content->attributes();
        $final['fields'] = $content->getFields();
        $final['title'] = $content->getField("title");
        $final['contentInfo'] = $content->contentInfo;
        $locations = $locationService->loadLocations($content->contentInfo);
        foreach ($locations as $location) {
            $final['locations'][$location->id] = $location->attributes();
        }

        return $this->render("BeCloodTopRecettesBundle:EzPlatform:api.html.twig", $final);
    }

    /**
     * @param $locationId
     * @param $viewType
     * @param bool $layout
     * @param array $params
     * @return Response
     */
    public function showLandingPageAction($locationId, $viewType, $layout = false, array $params = [])
    {
        $searchService = $this->get('ezpublish.api.repository')->getSearchService();
        $query = new Query([
            'filter' => new Query\Criterion\ContentTypeIdentifier('recette'),
            'sortClauses' => [new Query\SortClause\DatePublished(Query::SORT_DESC)],
            'limit' => $this->get('ezpublish.config.resolver')->getParameter('content.max_recettes.setting', 'beclood_top_recettes')
        ]);
        $params['recettes'] = $this->get('beclood_top_recettes.search_helper')
            ->buildList($searchService->findContent($query));

        return $this->get('ez_content')->viewLocation($locationId, $viewType, $layout, $params);
    }

}