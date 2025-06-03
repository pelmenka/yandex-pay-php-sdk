<?php

namespace Triya\YandexPaySdk;

use JsonSerializable;

class BaseEntity implements JsonSerializable
{
    public function __construct(array $attributes = [])
    {
        $this->transformer = new EntityTransformer();
        $this->attributes = $attributes;
    }

    public function &__get(string $name)
    {
        if (!isset($this->attributes[$name])) {
            $this->attributes[$name] = null;
        }

        return $this->attributes[$name];
    }

    public function __set(string $name, mixed $value)
    {
        $this->attributes[$name] = $value;
    }

    public function jsonSerialize(): mixed
    {
        $attributes = [];

        $this->beforeSerialization();

        foreach ($this->attributes as $key => $value) {
            if (isset($this->casts[$key])) {
                $attributes[$key] = $this->transformer->transformValue($this->casts[$key], $value);
            } else {
                $attributes[$key] = $value;
            }
        }

        return $attributes;
    }

    protected function setAtributes(array $values): void
    {
        $this->attributes = array_merge($this->attributes, $values);
    }

    protected function beforeSerialization()
    {

    }

    protected array $attributes = [];

    /**
     * Преобразователи для сущностей
     * 
     * @var array<string, string> $casts
     */
    protected array $casts = [];

    protected EntityTransformer $transformer;
};

