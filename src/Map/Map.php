<?php

/*
 * This file is part of the nuldark/stdlib.
 *
 * Copyright (C) 2023-2024 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE.md file for details.
 */

namespace Nuldark\Stdlib\Map;

use Nuldark\Stdlib\StdArray;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @extends \Nuldark\Stdlib\StdArray<TValue>
 * @implements \Nuldark\Stdlib\Map\MapInterface<TKey, TValue>
 */
class Map extends StdArray implements MapInterface
{
    /**
     * @inheritDoc
     *
     * @param TKey|null $offset
     * @param TValue $value
     */
    public function offsetSet(mixed $offset, mixed $value): void {
        if ($offset === null) {
            throw new \InvalidArgumentException(
                'Key must be provided for value ' .
                \var_export($value, true)
            );
        }

        $this->data[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function keys(): array {
        return \array_keys($this->data);
    }

    /**
     * @inheritDoc
     */
    public function put(int|string $key, mixed $value): mixed {
        $previous = $this->get($key);
        $this[$key] = $value;

        return $previous;
    }

    /**
     * @inheritDoc
     */
    public function get(int|string $key, mixed $default = null): mixed {
        return $this[$key] ?? $default;
    }

    /**
     * @inheritDoc
     */
    public function remove(int|string $key): mixed {
        $previousValue = $this->get($key);
        unset($this[$key]);

        return $previousValue;
    }
}
