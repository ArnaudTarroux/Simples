<?php

namespace Strnoar\Simples\Reactor;

use PHPUnit\Framework\TestCase;
use Strnoar\Simples\Event\EventInterface;
use Strnoar\Simples\Exceptions\AggregatorNotFoundException;

/**
 * Class ReactorContainerTest
 * @package Event
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
class ReactorContainerTest extends TestCase
{
    /**
     * @var ReactorContainer
     */
    private $reactorContainer;

    public function setUp()
    {
        $this->reactorContainer = new ReactorContainer();
    }

    public function testAddHandler()
    {
        $eventName = 'test_event';
        $reactor = $this->createMock(ReactorInterface::class);
        $reactor->method('handle');
        $this->reactorContainer->addHandler($reactor, $eventName);
        $reactors = $this->reactorContainer->getHandlers($eventName);

        $this->assertTrue($this->reactorContainer->hasHandlers($eventName));
        $this->assertSame($reactor, $reactors[0]);
        $this->assertCount(1, $reactors);
    }

    public function testGetNonExistantEvent()
    {
        $this->expectException(AggregatorNotFoundException::class);
        $this->reactorContainer->getHandlers('fake_event');
    }

    public function testApply()
    {
        $eventNames = [];
        $rand = rand(1, 5);
        for ($i = 0; $i < $rand; $i++) {
            $eventName = 'event_' . $i;
            $eventNames[] = $eventName;
            $reactor = $this->createMock(ReactorInterface::class);
            $reactor->expects($this->once())
                ->method('handle');
            $this->reactorContainer->addHandler($reactor, $eventName);
        }

        $event = $this->createMock(EventInterface::class);
        $event->expects($this->any())
            ->method('getType');

        foreach ($eventNames as $eventName) {
            $this->reactorContainer->apply($eventName, $event);
        }
    }
}
