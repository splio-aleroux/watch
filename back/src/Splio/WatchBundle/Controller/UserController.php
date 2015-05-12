<?php

namespace Splio\WatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Splio\RestBundle\Controller\BaseController as RestController;

/**
 * @Route("/user", service="splio_watch.user_controller")
 */
class UserController extends RestController
{
    /**
     * @Route(
     *     "/{id}",
     *     requirements={"id" = "\d+"}
     * )
     * Resource("splio:watch:user")
     * Type("\Splio\WatchBundle\Type\UserType")
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
     *     "/{userId}/links"
     * )
     * Resource("splio:watch:link")
     * Type("\Splio\WatchBundle\Type\LinkType")
     */
    public function linksAction($userId)
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