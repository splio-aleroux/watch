<?php

namespace Splio\WatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Splio\RestBundle\Controller\BaseController as RestController;

/**
 * @Route("/", service="splio_watch.link_controller")
 */
class LinkController extends RestController
{
    /**
     * @Route(
     *     "/links"
     * )
     * Resource("splio:watch:link")
     * Type("\Splio\WatchBundle\Type\LinkType")
     */
    public function linksAction()
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
                ],
                [
                    "id" => rand(0,time()),
                    "url" => "http://bonjourmadame.com",
                    "tags" => [
                        "size" => 2,
                        "data" => [
                            ["name" => "auth"],
                            ["name" => "security"]
                        ],
                        "_links" => [
                            "timeline" => ["href" => "http://perdu.com"],
                            "statistics" => ["href" => "http://perdu.com"],
                        ]
                    ]
                ],
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