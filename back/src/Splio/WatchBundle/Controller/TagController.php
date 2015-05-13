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
     *     "/{id}",
     *     name="watch_tag",
     *     requirements={
     *         "id": "\d+",
     *         "_method": "GET"
     *     }
     * )
     */
    public function tagAction($id)
    {

        $tag = $this->tagService->get($id);
        $data = $this->tagSerializer->serialize($tag);

        return $this->renderJson($data);
    }

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
            'size' => $this->tagService->countLinks($tag),
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

    public function setTagService(\Splio\WatchBundle\Service\TagService $service)
    {
        $this->tagService = $service;
    }

    public function setTagSerializer(\Splio\WatchBundle\Serializer\TagSerializer $serializer)
    {
        $this->tagSerializer = $serializer;
    }
}