<?php

namespace Splio\RestBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestVersionListener
{
    /**
     * The HTTP Header Accept pattern supported
     * @var string
     */
    protected $acceptPattern;

    /**
     * @param  GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->headers->has('accept')) {
            // The request does not specify any accept value
            // Content negotiation aborted
            return;
        }

        $acceptHeader = $request->headers->get('accept');
        $match = preg_match($this->acceptPattern, $acceptHeader, $matches);

        if (!$match) {
            // The Accept value does not match expected pattern
            // Content negotiation aborted
            return;
        }

        $version = $matches['version'];
        $request->attributes->set('version', $version);
    }

    /**
     * Sets the Accept pattern
     *
     * @param string $pattern A regexp pattern compliant with PHP preg_match
     */
    public function setAcceptPattern($pattern)
    {
        $this->acceptPattern = $pattern;
    }
}