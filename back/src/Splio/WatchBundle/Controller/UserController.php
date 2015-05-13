<?php

namespace Splio\WatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Splio\RestBundle\Controller\BaseController as RestController;
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
     * @Route(
     *     "/",
     *     name="splio_watch_user_create",
     *     requirements={
     *         "_method": "POST"
     *     }
     * )
     * Type("Splio\WatchBundle\Type\UserCreateType")
     */
    public function createAction(Request $request)
    {
        $creation = new UserCreateType();
        $creation->bind($this->getRequestContent($request));


        $errors = $this->validator->validate($creation);
        if (0 === $errors->count()) {
            // call the service
            return $this->renderJson(1);
        } else {
            $results = ["errors" => []];
            $violations = $errors->getIterator();
            foreach ($violations as $key => $error) {
                $results["errors"][$error->getPropertyPath()][] = $error->getMessage();
            }

            return $this->renderJson($results, Response::HTTP_BAD_REQUEST);
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

}