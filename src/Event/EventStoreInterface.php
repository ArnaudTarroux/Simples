<?php

namespace Strnoar\Simples\Event;

interface EventStoreInterface
{
    /**
     * @param EventInterface $event
     * @return EventInterface
     */
    public function store(EventInterface $event): EventInterface;
}
