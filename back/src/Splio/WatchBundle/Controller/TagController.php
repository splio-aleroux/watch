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
    protected $linkSerializer;

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
     *     "/"
     * )
     * Resource("splio:watch:tag")
     * Type("\Splio\WatchBundle\Type\TagType")
     */
    public function TagsAction($offset = 0, $limit = 10)
    {
        $tags = $this->tagService->getTags($offset, $limit);
        $data = [
            // Todo get count of links in service
            'size' => $this->tagService->count(),
            'data' => []
        ];

        foreach ($tags as $tag) {
            $data['data'][] = $this->tagSerializer->serialize($tag);
        }

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
        $tag = $this->tagService->getByName($tagName);

        $links = $this->tagService->getLinks($tag, $offset, $limit);
        $data = [
            // Todo get count of links in service
            'size' => $this->tagService->countLinks($tag),
            'data' => []
        ];

        foreach ($links as $link) {
            $data['data'][] = $this->linkSerializer->serialize($link);
        }

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

    public function setLinkSerializer(\Splio\WatchBundle\Serializer\LinkSerializer $serializer)
    {
        $this->linkSerializer = $serializer;
    }
}