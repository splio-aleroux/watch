<?php

namespace Splio\WatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Splio\RestBundle\Controller\BaseController as RestController;
use Splio\WatchBundle\Service\LinkService;
use Splio\WatchBundle\Serializer\LinkSerializer;

/**
 * @Route("/links", service="splio_watch.link_controller")
 */
class LinkController extends RestController
{
    protected $linkService;
    protected $linkSerializer;

    /**
     * @Route(
     *     "/{id}",
     *     name="watch_link",
     *     requirements={
     *         "id": "\d+",
     *         "_method": "GET"
     *     }
     * )
     */
    public function linkAction($id)
    {

        $link = $this->linkService->get($id);
        $data = $this->linkSerializer->serialize($link);

        return $this->renderJson($data);
    }

    /**
     * @Route(
     *     "/",
     *     name="watch_links_default",
     *     condition="request.get('version') == null"
     * )
     */
    public function linksAction($offset = 0, $limit = 10)
    {

        $links = $this->linkService->getLinks($offset, $limit);
        $data = [
            'size' => $this->linkService->count(),
            'data' => []
        ];

        foreach ($links as $link) {
            $data['data'][] = $this->linkSerializer->serialize($link);
        }

        // // mock api return
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
            // "_links" => [
            //     "next" => ["href" => "http://perdu.com"],
            //     "previous" => ["href" => "http://perdu.com"],
            //     "last" => ["href" => "http://perdu.com"],
            //     "first" => ["href" => "http://perdu.com"],
            // ]
        // ];

        return $this->renderJson($data);
    }

    public function setLinkService(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function setLinkSerializer(LinkSerializer $linkSerializer)
    {
        $this->linkSerializer = $linkSerializer;
    }
}
