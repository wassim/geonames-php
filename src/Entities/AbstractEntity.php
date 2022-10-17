<?php

namespace Farzai\Geonames\Entities;

use Farzai\Geonames\Entities\Traits\ArrayAccessibleTrait;
use Farzai\Geonames\Entities\Traits\HasAttributesTrait;
use Farzai\Geonames\Entities\Traits\JsonSerializableTrait;

abstract class AbstractEntity implements EntityInterface
{
    use ArrayAccessibleTrait;
    use HasAttributesTrait;
    use JsonSerializableTrait;

    /**
     * Get entity field names
     *
     * @return string[]
     */
    abstract public static function getFields(): array;

    /**
     * Parse raw data to entity
     *
     * @param  array<mixed>  $data
     * @return static
     */
    public static function parse(array $data)
    {
        return new static(array_combine(static::getFields(), $data));
    }

    /**
     * AbstractEntity constructor.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->{$this->getIdentifyKeyName()};
    }

    /**
     * Return array of entity
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge($this->attributes, [
            'id' => $this->getIdentifier(),
        ]);
    }

    /**
     * For printing
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
