<?php

/*
 * This file is part of the nuldark/stdlib.
 *
 * Copyright (C) 2023-2024 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE.md file for details.
 */

namespace Nuldark\Stdlib;

/**
 * @template TValue
 *
 * @extends \ArrayAccess<array-key, TValue>
 * @extends \IteratorAggregate<array-key, TValue>
 */
interface StdArrayInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * Remove all items from array.
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Checks whether the array is empty.
     *
     * @return bool
     */
    public function empty(): bool;

    /**
     * Execute callback over an array.
     *
     * @param callable(TValue, array-key): TValue $callback
     * @return $this
     */
    public function each(callable $callback): self;

    /**
     * Run a filter over a collection.
     *
     * @param callable(TValue): bool $callback
     * @return $this
     */
    public function filter(callable $callback): self;

    /**
     * Returns a first item of this array.
     *
     * @return TValue
     * @throws \RuntimeException
     */
    public function first(): mixed;

    /**
     * Returns a last item of this array.
     *
     * @return TValue
     * @throws \RuntimeException
     */
    public function last(): mixed;
}
