<?php

namespace Strnoar\Simples\Aggregator;

use Strnoar\Simples\Event\EventInterface;
use Strnoar\Simples\Exceptions\AggregatorNotFoundException;

/**
 * Interface EventAggregatorsContainerInterface
 * @package Event
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
interface EventAggregatorsContainerInterface
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
     * @param AggregatorInterface $handler
     * @param string $eventName
     * @return void
     * @internal param EventInterface $event
     */
    public function addHandler(AggregatorInterface $handler, string $eventName): void;

    /**
     * @return AggregatorInterface[]
     * @throws AggregatorNotFoundException
     */
    public function getHandlers(string $eventName): array;
}
