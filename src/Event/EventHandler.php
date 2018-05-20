<?php

namespace Strnoar\Simples\Event;

use Strnoar\Simples\Reactor\ReactorContainerInterface;
use Strnoar\Simples\Exceptions\NotAMiddlewareInstanceException;
use Strnoar\Simples\Middleware\MiddlewareInterface;

/**
 * Class EventHandler
 * @package Strnoar\Simples\Event
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
class EventHandler implements EventHandlerInterface
{
    /**
     * @var ReactorContainerInterface
     */
    private $reactorContainer;

    /**
     * @var EventStoreInterface
     */
    private $eventStore;

    /**
     * EventHandler constructor.
     * @param ReactorContainerInterface $reactorContainer
     * @param EventStoreInterface $eventStore
     */
    public function __construct(ReactorContainerInterface $reactorContainer, EventStoreInterface $eventStore)
    {
        $this->reactorContainer = $reactorContainer;
        $this->eventStore = $eventStore;
    }

    /**
     * @param string $eventName
     * @param EventInterface $event
     * @return EventInterface
     */
    public function handle(string $eventName, EventInterface $event): EventInterface
    {
        $this->eventStore->store($event);
        $this->reactorContainer->apply($eventName, $event);

        return $event;
    }
}
