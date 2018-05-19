<?php

namespace Strnoar\Simples\Reactor;

use Strnoar\Simples\Event\EventInterface;

/**
 * Interface ReactorInterface
 * @package Strnoar\Simples\Aggregator
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
interface ReactorInterface
{
    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function handle(EventInterface $event);
}
