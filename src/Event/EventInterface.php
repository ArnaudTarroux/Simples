<?php

namespace Strnoar\Simples\Event;

/**
 * Class Event
 * @package Event
 * @author Arnaud Tarroux <tar.arnaud@gmail.com>
 */
interface EventInterface
{
    /**
     * @return string
     */
    public function getType(): string;
}
