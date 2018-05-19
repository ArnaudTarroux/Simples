<?php

namespace Strnoar\Simples\Event;

use PHPUnit\Framework\TestCase;
use Strnoar\Simples\Aggregator\AggregatorInterface;
use Strnoar\Simples\Aggregator\EventAggregatorsContainerInterface;
use Strnoar\Simples\Middleware\MiddlewareInterface;

class EventHandlerTest extends TestCase
{
    /**
     * @var EventHandlerInterface
     */
    private $eventHandler;

    private function createEventHandler(bool $withMiddlewares = false)
    {
        $aggregator = $this->createMock(EventAggregatorsContainerInterface::class);
        $aggregator->expects($this->once())
            ->method('apply');

        if (true === $withMiddlewares) {
            $middleware = $this->createMock(MiddlewareInterface::class);
            $middleware->expects($this->once())
                ->method('process');

            $this->eventHandler = new EventHandler($aggregator, [$middleware]);
            return;
        }

        $this->eventHandler = new EventHandler($aggregator);
    }

    public function testHandleEventWithoutMiddleware()
    {
        $this->createEventHandler();
        $event = $this->createMock(EventInterface::class);
        $event->method('getType');

        $returnedEvent = $this->eventHandler->handle('test_event', $event);

        $this->assertSame($event, $returnedEvent);
    }

    public function testHandleEventWithMiddleware()
    {
        $this->createEventHandler(true);
        $event = $this->createMock(EventInterface::class);
        $event->method('getType');

        $returnedEvent = $this->eventHandler->handle('test_event', $event);

        $this->assertSame($event, $returnedEvent);
    }
}
