<?php

namespace Splio\WatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SimpleBus\Message\Bus\MessageBus;

use Splio\RestBundle\Controller\BaseController as RestController;

use Splio\WatchBundle\Command;
use Splio\WatchBundle\Service\UserService;
use Splio\WatchBundle\Service\LinkService;
use Splio\WatchBundle\Serializer\UserSerializer;
use Splio\WatchBundle\Serializer\LinkBaseSerializer;
use Splio\WatchBundle\Type\UserCreateType;

/**
 * @Route("/user", service="splio_watch.user_controller")
 */
class UserController extends RestController
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @Route(
     *     "/",
     *     name="splio_watch_user_create",
     *     requirements={
     *         "_method": "POST"
     *     }
     * )
     */
    public function createAction(Request $request)
    {
        $content = $this->getRequestContent($request);

        // Create the user creation command
        $command = new Command\UserCreateCommand($content->email);

        try {
            // Send the command on the bus
            $this->commandBus->handle($command);

            // Acknowledge the command execution
            if ($command->getUser()) {
                $data = $this->userSerializer->serialize($command->getUser());
                return $this->renderJson($data, 201);
            }
        } catch (\InvalidArgumentException $e) {
            return $this->renderJson($e->getViolations(), 400);
        }

    }

    /**
     * @Route(
     *     "/{id}",
     *     name="splio_watch_user",
     *     requirements={
     *         "id": "\d+",
     *         "_method": "GET"
     *     }
     * )
     */
    public function userAction($id)
    {
        $user = $this->userService->get($id);
        $data = $this->userSerializer->serialize($user);

        return $this->renderJson($data);
    }

    /**
     * @Route(
     *     "/{id}/links",
     *     name="splio_watch_user_links",
     *     requirements={
     *         "id": "\d+",
     *         "_method": "GET"
     *     }
     * )
     */
    public function linksAction($id, $offset = 0, $limit = 10)
    {
        $user = $this->userService->get($id);
        $links = $this->userService->getLinks($user, $offset, $limit);

        $data = [
            // Todo get count of links in service
            'size' => $this->userService->countLinks($user),
            'data' => []
        ];

        foreach ($links as $link) {
            $data['data'][] = $this->linkSerializer->serialize($link);
        }

        return $this->renderJson($data);
    }

    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function setUserSerializer(UserSerializer $userSerializer)
    {
        $this->userSerializer = $userSerializer;
    }

    public function setLinkSerializer(LinkBaseSerializer $linkSerializer)
    {
        $this->linkSerializer = $linkSerializer;
    }

    public function setCommandBus(MessageBus $bus)
    {
        $this->commandBus = $bus;
    }
}