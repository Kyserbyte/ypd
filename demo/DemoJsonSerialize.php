<?php

namespace YPD\Demo;

use YPD\Serializer\Json\YPDJsonSerializer;
use JsonSerializable;

class DemoJsonSerialize implements JsonSerializable
{
    use YPDJsonSerializer, DemoJsonSerializeTrait;

    /**
     * Undocumented variable
     *
     * @var [string]
     * ypd::jsonSerialize
     */
    public $publicProp1;

    /**
     * Undocumented variable
     *
     * @var [int]
     * ypd::jsonSerialize(name=customName1)
     */
    public $publicProp2;

    public $publicProp3NoSerialize;

    /**
     * Undocumented variable
     *
     * @var [type]
     * ypd::jsonSerialize(if=canSerialize)
     */
    public $sub1;

    public function __construct()
    {
        $this->publicProp1 = "valueProp1";
        $this->publicProp2 = 2;
        $this->publicProp3NoSerilize = "valueProp3NoSerialize";
        $this->sub1 = new DemoSubJsonSerializable();
    }
}

class DemoSubJsonSerializable implements JsonSerializable
{
    use YPDJsonSerializer;

    /**
     * Undocumented variable
     *
     * @var [string]
     * ypd::jsonSerialize
     */
    public $subProp1;

    /**
     * Undocumented variable
     *
     * @var [int]
     * ypd::jsonSerialize
     */
    public $subProp2;

    /**
     * Undocumented variable
     *
     * @var [array]
     * ypd::jsonSerialize
     */
    public $subProp3;

    public function __construct()
    {
        $this->subProp1 = "subValueProp1";
        $this->subProp2 = 22;
        $this->subProp3 = ['a', 'b', 'c'];
    }
}

trait DemoJsonSerializeTrait
{

    public function canSerialize()
    {
        return true;
    }
}
