<?php

namespace Xyo\Shortcodes\Hydrator;

/**
 * Tiny array→object "serializer" for shortcode attributes.
 *
 * A DTO's public typed properties declare the schema: their names are the
 * accepted attributes and their default values feed shortcode_atts(). Raw atts
 * are normalised, then each value is cast to its property's declared type.
 */
class AttributeHydrator
{
    /**
     * @template T of object
     * @param class-string<T> $dtoClass
     * @param array|string    $atts     Raw shortcode atts ('' when none).
     * @return T
     */
    public static function hydrate(string $dtoClass, $atts): object
    {
        $dto = new $dtoClass();
        $props = (new \ReflectionObject($dto))->getProperties(\ReflectionProperty::IS_PUBLIC);

        // Schema + defaults from the DTO.
        $defaults = [];
        foreach ($props as $prop) {
            $defaults[$prop->getName()] = $prop->getValue($dto);
        }

        $values = shortcode_atts($defaults, is_array($atts) ? $atts : []);

        // Assign back, cast to each property's type.
        foreach ($props as $prop) {
            $name = $prop->getName();
            $dto->{$name} = self::cast($values[$name], $prop->getType());
        }

        return $dto;
    }

    private static function cast($value, ?\ReflectionType $type)
    {
        if (!$type instanceof \ReflectionNamedType || !$type->isBuiltin()) {
            return $value;
        }

        return match ($type->getName()) {
            'int'    => (int) $value,
            'float'  => (float) $value,
            'bool'   => (bool) $value,
            'string' => (string) $value,
            default  => $value,
        };
    }
}
