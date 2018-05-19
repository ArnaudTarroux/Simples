<?php

namespace Strnoar\Simples\Aggregator;

use Strnoar\Simples\Event\EventInterface;

/**
 * Interface AggregatorInterface
 * @package Strnoar\Simples\Aggregator
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
interface AggregatorInterface
{
    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function handle(EventInterface $event);
}
