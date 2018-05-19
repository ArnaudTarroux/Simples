<?php

namespace Strnoar\Simples\Event;

use PHPUnit\Framework\TestCase;
use Strnoar\Simples\Middleware\MiddlewareInterface;
use Strnoar\Simples\Reactor\ReactorContainerInterface;

/**
 * Class EventHandlerTest
 * @package Strnoar\Simples\Event
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
class EventHandlerTest extends TestCase
{
    /**
     * @var EventHandlerInterface
     */
    private $eventHandler;

    private function createEventHandler(bool $withMiddlewares = false)
    {
        $reactor = $this->createMock(ReactorContainerInterface::class);
        $reactor->expects($this->once())
            ->method('apply');

        if (true === $withMiddlewares) {
            $middleware = $this->createMock(MiddlewareInterface::class);
            $middleware->expects($this->once())
                ->method('process');

            $this->eventHandler = new EventHandler($reactor, [$middleware]);
            return;
        }

        $this->eventHandler = new EventHandler($reactor);
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
