<?php

namespace Strnoar\Simples\Event;

use Strnoar\Simples\Aggregator\EventAggregatorsContainerInterface;
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
     * @var MiddlewareInterface[]
     */
    private $middlewares;

    /**
     * @var EventAggregatorsContainerInterface
     */
    private $aggregatorsContainer;

    /**
     * EventHandler constructor.
     * @param EventAggregatorsContainerInterface $aggregatorsContainer
     * @param MiddlewareInterface[] $middlewares
     * @throws NotAMiddlewareInstanceException
     */
    public function __construct(EventAggregatorsContainerInterface $aggregatorsContainer, array $middlewares = [])
    {
        $this->aggregatorsContainer = $aggregatorsContainer;

        foreach ($middlewares as $middleware) {
            if (!$middleware instanceof MiddlewareInterface) {
                $message = sprintf('The middlewares must be an implementation of %s', MiddlewareInterface::class);
                throw new NotAMiddlewareInstanceException($message);
            }

            $this->middlewares[] = $middleware;
        }
    }

    /**
     * @param string $eventName
     * @param EventInterface $event
     * @return EventInterface
     */
    public function handle(string $eventName, EventInterface $event): EventInterface
    {
        if (!empty($this->middlewares)) {
            $this->processMiddlewares($this->middlewares, $eventName, $event);
        }

        $this->aggregatorsContainer->apply($eventName, $event);

        return $event;
    }

    /**
     * @param MiddlewareInterface[] $middlewares
     * @param string $eventName
     * @param EventInterface $event
     * @return EventInterface
     */
    private function processMiddlewares(array $middlewares, string $eventName, EventInterface $event): EventInterface
    {
        if (empty($middlewares)) {
            return $event;
        }

        $middleware = array_shift($middlewares);
        $middleware->process($eventName, $event);

        return $this->processMiddlewares($middlewares, $eventName, $event);
    }
}
