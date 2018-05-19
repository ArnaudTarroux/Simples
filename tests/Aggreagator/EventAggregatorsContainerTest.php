<?php

namespace Strnoar\Simples\Aggregator;

use PHPUnit\Framework\TestCase;
use Strnoar\Simples\Event\EventInterface;
use Strnoar\Simples\Exceptions\AggregatorNotFoundException;

/**
 * Class eventAggregatorsContainerTest
 * @package Event
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
class eventAggregatorsContainerTest extends TestCase
{
    /**
     * @var EventAggregatorsContainer
     */
    private $eventAggregatorsContainer;

    public function setUp()
    {
        $this->eventAggregatorsContainer = new EventAggregatorsContainer();
    }

    public function testAddHandler()
    {
        $eventName = 'test_event';
        $aggregator = $this->createMock(AggregatorInterface::class);
        $aggregator->method('handle');
        $this->eventAggregatorsContainer->addHandler($aggregator, $eventName);
        $aggregators = $this->eventAggregatorsContainer->getHandlers($eventName);

        $this->assertTrue($this->eventAggregatorsContainer->hasHandlers($eventName));
        $this->assertSame($aggregator, $aggregators[0]);
        $this->assertCount(1, $aggregators);
    }

    public function testGetNonExistantEvent()
    {
        $this->expectException(AggregatorNotFoundException::class);
        $this->eventAggregatorsContainer->getHandlers('fake_event');
    }

    public function testApply()
    {
        $eventNames = [];
        $rand = rand(1, 5);
        for ($i = 0; $i < $rand; $i++) {
            $eventName = 'event_' . $i;
            $eventNames[] = $eventName;
            $aggregator = $this->createMock(AggregatorInterface::class);
            $aggregator->expects($this->once())
                ->method('handle');
            $this->eventAggregatorsContainer->addHandler($aggregator, $eventName);
        }

        $event = $this->createMock(EventInterface::class);
        $event->expects($this->any())
            ->method('getType');

        foreach ($eventNames as $eventName) {
            $this->eventAggregatorsContainer->apply($eventName, $event);
        }
    }
}
