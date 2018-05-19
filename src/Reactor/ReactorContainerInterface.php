<?php

namespace Strnoar\Simples\Reactor;

use Strnoar\Simples\Event\EventInterface;
use Strnoar\Simples\Exceptions\AggregatorNotFoundException;

/**
 * Interface ReactorContainerInterface
 * @package Event
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
interface ReactorContainerInterface
{
    /**
     * @param string $eventName
     * @param EventInterface $event
     * @return EventInterface|void
     */
    public function apply(string $eventName, EventInterface $event);

    /**
     * @param string $eventName
     * @return bool
     */
    public function hasHandlers(string $eventName): bool;

    /**
     * @param ReactorInterface $handler
     * @param string $eventName
     * @return void
     * @internal param EventInterface $event
     */
    public function addHandler(ReactorInterface $handler, string $eventName): void;

    /**
     * @return ReactorInterface[]
     * @throws AggregatorNotFoundException
     */
    public function getHandlers(string $eventName): array;
}
