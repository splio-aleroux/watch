<?php

namespace Splio\WatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Splio\RestBundle\Controller\BaseController as RestController;
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
        $data = [
            "id" => rand(0,time()),
            "nickname" => "jdoe",
            "email" => "jdoe@gmail.com",
            "avatar" => "http://lorempixel.com/g/200/200/",
            "links" => [
                "size" => 9822,
                "data" => [],
                "_links" => [
                    "next" => ["href" => "http://perdu.com"],
                    "previous" => ["href" => "http://perdu.com"],
                    "last" => ["href" => "http://perdu.com"],
                    "first" => ["href" => "http://perdu.com"],
                ]
            ],
            "tags" => [
                "size" => 338,
                "data" => [],
                "_links" => [
                    "next" => ["href" => "http://perdu.com"],
                    "previous" => ["href" => "http://perdu.com"],
                    "last" => ["href" => "http://perdu.com"],
                    "first" => ["href" => "http://perdu.com"],
                ]
            ]
        ];

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
    public function linksAction($id)
    {
        $data = [
            "size" => 123,
            "data" => [
                [
                    "id" => rand(0,time()),
                    "url" => "http://perdu.com",
                    "tags" => [
                        "size" => 3,
                        "data" => [
                            ["name" => "js"],
                            ["name" => "react"],
                            ["name" => "flux"],
                        ],
                        "_links" => [
                            "timeline" => ["href" => "http://perdu.com"],
                            "statistics" => ["href" => "http://perdu.com"],
                        ]
                    ]
                ],
                [
                    "id" => rand(0,time()),
                    "url" => "http://google.com",
                    "tags" => [
                        "size" => 2,
                        "data" => [
                            ["name" => "php"],
                            ["name" => "rabbitmqueue"]
                        ],
                        "_links" => [
                            "timeline" => ["href" => "http://perdu.com"],
                            "statistics" => ["href" => "http://perdu.com"],
                        ]
                    ]
                ]
            ],
            "_links" => [
                "next" => ["href" => "http://perdu.com"],
                "previous" => ["href" => "http://perdu.com"],
                "last" => ["href" => "http://perdu.com"],
                "first" => ["href" => "http://perdu.com"],
            ]
        ];

        return $this->renderJson($data);
    }
}