<?php

namespace Splio\WatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Splio\RestBundle\Controller\BaseController as RestController;
use Splio\WatchBundle\Service\LinkService;
use SimpleBus\Message\Bus\MessageBus;

/**
 * @Route("/tag", service="splio_watch.tag_controller")
 */
class TagController extends RestController
{
    protected $tagSerializer;
    protected $tagService;
    protected $linkSerializer;
    protected $commandBus;

    /**
     * @Route(
     *     "/",
     *     name="splio_watch_tag_create",
     *     requirements={
     *         "_method": "POST"
     *     }
     * )
     */
    public function createAction(Request $request)
    {
        $content = $this->getRequestContent($request);

        // Create the user creation command
        $command = new Command\TagCreateCommand($content->name);

        try {
            // Send the command on the bus
            $this->commandBus->handle($command);

            // Acknowledge the command execution
            if ($command->getTag()) {
                $data = $this->tagSerializer->serialize($command->getTag());
                return $this->renderJson($data, 201);
            }
        } catch (\InvalidArgumentException $e) {
            return $this->renderJson($e->getViolations(), 400);
        }
    }

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

    public function setCommandBus(MessageBus $bus)
    {
        $this->commandBus = $bus;
    }
}