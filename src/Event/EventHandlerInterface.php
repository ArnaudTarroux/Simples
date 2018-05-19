<?php

namespace Strnoar\Simples\Event;

/**
 * Interface EventHandlerInterface
 * @package Strnoar\Simples\Event
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
interface EventHandlerInterface
{
    /**
     * @param string $eventName
     * @param EventInterface $event
     * @return EventInterface
     */
    public function handle(string $eventName, EventInterface $event): EventInterface;
}
