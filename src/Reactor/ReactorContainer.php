<?php

namespace Strnoar\Simples\Reactor;

use Strnoar\Simples\Event\EventInterface;
use Strnoar\Simples\Exceptions\AggregatorNotFoundException;

/**
 * Class ReactorContainer
 * @package Event
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
class ReactorContainer implements ReactorContainerInterface
{
    /**
     * @var ReactorInterface[][]
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

        /** @var ReactorInterface $handler */
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
     * @return ReactorInterface[]
     * @throws AggregatorNotFoundException
     */
    public function getHandlers(string $eventName): array
    {
        if (!isset($this->handlers[$eventName])) {
            $exceptionMessage = \sprintf('%s was not found in the handlers list', $eventName);
            throw new AggregatorNotFoundException($exceptionMessage);
        }

        return $this->handlers[$eventName];
    }

    /**
     * @param ReactorInterface $handler
     * @param string $eventName
     * @return void
     */
    public function addHandler(ReactorInterface $handler, string $eventName): void
    {
        $this->handlers[$eventName][] = $handler;
    }
}
