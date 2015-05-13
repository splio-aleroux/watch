<?php

namespace Splio\WatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Splio\RestBundle\Controller\BaseController as RestController;
use Splio\WatchBundle\Service\LinkService;

/**
 * @Route("/tag", service="splio_watch.tag_controller")
 */
class TagController extends RestController
{
    protected $tagSerializer;
    /**
     * @Route(
     *     "/{tagName}/links/"
     * )
     * Resource("splio:watch:link")
     * Type("\Splio\WatchBundle\Type\LinkType")
     */
    public function linksAction($tagName, $offset = 0, $limit = 10)
    {

        $tag = null;

        $links = $this->tagService->getLinks($tag, $offset, $limit);
        $data = [
            // Todo get count of links in service
            'size' => count($links),
            'data' => []
        ];

        foreach ($links as $link) {
            $data['data'][] = $this->linkSerializer->serialize($link);
        }

        // // Tag
        // $data = [
        //     "size" => 123,
        //     "data" => [
        //         [
        //             "id" => rand(0,time()),
        //             "url" => "http://perdu.com",
        //             "tags" => [
        //                 "size" => 3,
        //                 "data" => [
        //                     ["name" => "js"],
        //                     ["name" => "react"],
        //                     ["name" => "flux"],
        //                 ],
        //                 "_links" => [
        //                     "timeline" => ["href" => "http://perdu.com"],
        //                     "statistics" => ["href" => "http://perdu.com"],
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "_links" => [
        //         "next" => ["href" => "http://perdu.com"],
        //         "previous" => ["href" => "http://perdu.com"],
        //         "last" => ["href" => "http://perdu.com"],
        //         "first" => ["href" => "http://perdu.com"],
        //     ]
        // ];

        return $this->renderJson($data);
    }

    public function setTagSerializer(\Splio\WatchBundle\Serializer\TagSerializer $serializer)
    {
        $this->tagSerializer = $serializer;
    }
}