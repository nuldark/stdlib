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

use Nuldark\Stdlib\Collection;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @extends \Nuldark\Stdlib\Collection<TValue>
 */
interface MapInterface extends Collection
{
    /**
     * Returns all keys for this map.
     *
     * @return array TKey[]
     */
    public function keys(): array;

    /**
     * Inserts the value in the map associates the specified key.
     *
     * @param TKey $key
     * @param TValue $value
     *
     * @return TValue
     */
    public function put(int|string $key, mixed $value): mixed;

    /**
     * Returns the value to which the specified key is mapped, if value is `null` returns `$default`.
     *
     * @param TKey $key
     * @param TValue $default
     *
     * @return TValue|null Returns the value assigned to the key, otherwise default value.
     */
    public function get(int|string $key, mixed $default = null): mixed;

    /**
     * Remove mapping from the map for a key.
     *
     * @param TKey $key
     *
     * @return TValue|null
     *  Returns removed value, otherwise null.
     */
    public function remove(int|string $key): mixed;
}
