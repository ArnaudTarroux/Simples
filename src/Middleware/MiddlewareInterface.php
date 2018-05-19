<?php

namespace Strnoar\Simples\Middleware;

use Strnoar\Simples\Event\EventInterface;

/**
 * Interface MiddlewareInterface
 * @package Strnoar\Simples\Middleware
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
interface MiddlewareInterface
{
    /**
     * @param string $eventName
     * @param EventInterface $event
     * @return mixed
     */
    public function process(string $eventName, EventInterface $event);
}
