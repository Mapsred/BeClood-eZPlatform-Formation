<?php
/**
 * Created by PhpStorm.
 * User: francois
 * Date: 08/03/17
 * Time: 11:14
 */

namespace BeClood\TopRecettesBundle\Controller;


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

}