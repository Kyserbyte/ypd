<?

namespace YPD\Serializer\Json;

use ReflectionProperty;
use ReflectionMethod;

class YPDJsonPropDecorator
{

    public static function apply($obj, ReflectionProperty $prop, array &$result)
    {
        $comment = $prop->getDocComment();
        if ($comment) {
            $decorator = self::__extractDecorator($comment);
            if ($decorator) {
                if (self::__validateIf($obj, $decorator)) {
                    $name = self::__getName($decorator) ?? $prop->getName();
                    $result[$name] = $obj->{$prop->getName()};
                }
            }
        }
    }

    private static function __extractDecorator($comment)
    {
        $decPos = strpos($comment, "ypd::jsonSerialize");
        $decorator = null;
        if ($decPos !== false) {
            $lineEnd = strpos($comment, "\n", $decPos);
            $decorator = substr($comment, $decPos, $lineEnd - $decPos);
        }
        return $decorator;
    }

    private static function __getName($decorator)
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

    private static function __validateIf($obj, $decorator)
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
