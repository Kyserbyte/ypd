<?php

namespace YPD\Serializer\Json;

use ReflectionProperty;
use ReflectionClass;
use ReflectionMethod;
use JsonSerializable;

class YPDJsonPropsSerializer
{
    /**
     * Undocumented variable
     *
     * @var [ReflectionClass]
     */
    private $__ypdReflector;

    /**
     * Undocumented variable
     *
     * @var [JsonSerializable]
     */
    private $__ypdObj;

    /**
     * Undocumented variable
     *
     * @var [array]
     */
    private $__ypdJsonProps;

    public function __construct(ReflectionClass $reflector, JsonSerializable $obj)
    {
        $this->__ypdReflector = $reflector;
        $this->__ypdObj = $obj;
        $this->__ypdJsonProps = [];
    }

    public function serialize()
    {
        $properties = $this->__ypdReflector->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $key => $prop) {
            $this->__apply($prop);
        }
        return $this->__ypdJsonProps;
    }

    private function __apply(ReflectionProperty $prop)
    {
        $comment = $prop->getDocComment();
        if ($comment) {
            $decorator = $this->__extractDecorator($comment);
            if ($decorator) {
                if ($this->__validateIf($this->__ypdObj, $decorator)) {
                    $name = $this->__getName($decorator) ?? $prop->getName();
                    $this->__ypdJsonProps[$name] = $this->__ypdObj->{$prop->getName()};
                }
            }
        }
    }

    private function __extractDecorator($comment)
    {
        $decPos = strpos($comment, "ypd::jsonSerialize");
        $decorator = null;
        if ($decPos !== false) {
            $lineEnd = strpos($comment, "\n", $decPos);
            $decorator = substr($comment, $decPos, $lineEnd - $decPos);
        }
        return $decorator;
    }

    private function __getName($decorator)
    {
        $name = null;
        $startParams = strpos($decorator, "name=");
        if ($startParams !== false) {
            $endParams = strpos($decorator, ",", $startParams);
            if ($endParams === false) {
                $endParams = strpos($decorator, ")", $startParams);
            }
            $name = substr($decorator, $startParams + 5, $endParams - $startParams - 5);
        }
        return $name;
    }

    private function __validateIf($obj, $decorator)
    {
        $if = true;
        $startParams = strpos($decorator, "if=");
        if ($startParams !== false) {
            $endParams = strpos($decorator, ",", $startParams);
            if ($endParams === false) {
                $endParams = strpos($decorator, ")", $startParams);
            }
            $ifFunc = substr($decorator, $startParams + 3, $endParams - $startParams - 3);
            $if = (new ReflectionMethod(get_class($obj), $ifFunc))->invoke($obj);
        }
        return $if;
    }
}
