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
    public function testHandleEvent()
    {
        $reactor = $this->createMock(ReactorContainerInterface::class);
        $reactor->expects($this->once())
            ->method('apply');

        $store = $this->createMock(EventStoreInterface::class);
        $store->expects($this->once())
            ->method('store');

        $eventHandler = new EventHandler($reactor, $store);

        $event = $this->createMock(EventInterface::class);
        $event->method('getType');

        $returnedEvent = $eventHandler->handle('test_event', $event);

        $this->assertSame($event, $returnedEvent);
    }
}
