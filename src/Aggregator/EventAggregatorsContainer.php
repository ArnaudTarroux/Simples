<?php

namespace Strnoar\Simples\Aggregator;

use Strnoar\Simples\Event\EventInterface;
use Strnoar\Simples\Exceptions\AggregatorNotFoundException;

/**
 * Class EventAggregatorContainer
 * @package Event
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
class EventAggregatorsContainer implements EventAggregatorsContainerInterface
{
    /**
     * @var AggregatorInterface[][]
     */
    private $handlers = [];

    /**
     * @param string $eventName
     * @param EventInterface $event
     * @return EventInterface|void
     */
    public function apply(string $eventName, EventInterface $event)
    {
        try {
            $handlers = $this->getHandlers($eventName);
        } catch (AggregatorNotFoundException $exception) {
            return;
        }

        /** @var AggregatorInterface $handler */
        foreach ($handlers as $handler) {
            $handler->handle($event);
        }

        return $event;
    }

    /**
     * @param string $eventName
     * @return bool
     * @internal param string $event
     */
    public function hasHandlers(string $eventName): bool
    {
        return \array_key_exists($eventName, $this->handlers);
    }

    /**
     * @param string $eventName
     * @return AggregatorInterface[]
     * @throws AggregatorNotFoundException
     */
    public function getHandlers(string $eventName): array
    {
        if (!isset($this->handlers[$eventName])) {
            $exceptionMessage = sprintf('%s was not found in the handlers list', $eventName);
            throw new AggregatorNotFoundException($exceptionMessage);
        }

        return $this->handlers[$eventName];
    }

    /**
     * @param AggregatorInterface $handler
     * @param string $eventName
     * @return void
     */
    public function addHandler(AggregatorInterface $handler, string $eventName): void
    {
        $this->handlers[$eventName][] = $handler;
    }
}
