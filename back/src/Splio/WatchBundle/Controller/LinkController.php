<?php

namespace Splio\WatchBundle\Controller;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Splio\RestBundle\Controller\BaseController as RestController;
use Splio\WatchBundle\Service\LinkService;
use Splio\WatchBundle\Serializer\LinkSerializer;
use SimpleBus\Message\Bus\MessageBus;

/**
 * @Route("/links", service="splio_watch.link_controller")
 */
class LinkController extends RestController
{
    protected $linkService;
    protected $linkSerializer;
    protected $securityContext;
    protected $commandBus;

    /**
     * @Route(
     *     "/",
     *     name="splio_watch_link_create",
     *     requirements={
     *         "_method": "POST"
     *     }
     * )
     */
    public function createAction(Request $request)
    {
        $content = $this->getRequestContent($request);

        $userToken = $this->securityContext->getToken()->getUser();
        $user = $userToken->getUsername();

        // Create the user creation command
        $command = new Command\LinkCreateCommand($content->url, $user);

        try {
            // Send the command on the bus
            $this->commandBus->handle($command);

            // Acknowledge the command execution
            if ($command->getTag()) {
                $data = $this->linkSerializer->serialize($command->getLink());
                return $this->renderJson($data, 201);
            }
        } catch (\InvalidArgumentException $e) {
            return $this->renderJson($e->getViolations(), 400);
        }
    }

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

    public function setCommandBus(MessageBus $bus)
    {
        $this->commandBus = $bus;
    }

    public function setSecurityContext(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }
}
