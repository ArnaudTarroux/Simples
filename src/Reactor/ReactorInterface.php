<?php

namespace Strnoar\Simples\Reactor;

use Strnoar\Simples\Event\EventInterface;

/**
 * Interface ReactorInterface.
 *
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
interface ReactorInterface
{
    /**
     * @param EventInterface $event
     *
     * @return mixed
     */
    public function handle(EventInterface $event);
}
