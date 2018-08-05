<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace OAuth2Framework\Component\Core\DataBag;

class DataBag implements \JsonSerializable, \IteratorAggregate, \Countable
{
    /**
     * @var array
     */
    private $parameters = [];

    /**
     * DataBag constructor.
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function has(string $key): bool
    {
        return \array_key_exists($key, $this->parameters);
    }

    /**
     * @param mixed|null $default
     */
    public function get(string $key, $default = null)
    {
        if ($this->has($key)) {
            return $this->parameters[$key];
        }

        return $default;
    }

    /**
     * @param null|mixed $value
     *
     * @return DataBag
     */
    public function with(string $key, $value): self
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @return DataBag
     */
    public function without(string $key): self
    {
        if (!$this->has($key)) {
            return $this;
        }
        unset($this->parameters[$key]);

        return $this;
    }

    public function all(): array
    {
        return $this->parameters;
    }

    public function jsonSerialize()
    {
        return $this->all();
    }

    public function count()
    {
        return \count($this->parameters);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->parameters);
    }
}
