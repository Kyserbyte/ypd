<?php

namespace YPD\Serializer\Json;

use ReflectionClass;

/**
 * This trait implements the json serializer for a class.
 */
trait YPDJsonSerializer
{
    private $__ypdReflector = null;

    public function jsonSerialize()
    {
        $this->__ypdInit();
        return (new YPDJsonPropsSerializer($this->__ypdReflector, $this))->serialize();
    }

    private function __ypdInit()
    {
        if ($this->__ypdReflector === null) {
            $this->__ypdReflector = new ReflectionClass(__CLASS__);
        }
    }
}
