<?php

namespace YPD\Serializer\Json;

use ReflectionProperty;

class YPDJsonPropsSerializer
{
    private $__ypdReflector;
    private $__ypdObj;
    private $__ypdJsonProps;

    public function __construct($reflector, $obj)
    {
        $this->__ypdReflector = $reflector;
        $this->__ypdObj = $obj;
        $this->__ypdJsonProps = [];
    }
    public function serialize()
    {
        $properties = $this->__ypdReflector->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $key => $prop) {
            YPDJsonPropDecorator::apply($this->__ypdObj, $prop, $this->__ypdJsonProps);
        }
        return $this->__ypdJsonProps;
    }
}
