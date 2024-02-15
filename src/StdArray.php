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
 * @implements \Nuldark\Stdlib\StdArrayInterface<TValue>
 */
class StdArray implements StdArrayInterface
{
    public function __construct(
        /** @var array<array-key, TValue> $data */
        protected array $data = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): \Traversable {
        return new \ArrayIterator($this->data);
    }

    /**
     * @inheritDoc
     *
     * @param array-key $offset
     */
    public function offsetExists(mixed $offset): bool {
        return isset($this->data[$offset]);
    }

    /**
     * @inheritDoc
     *
     * @param array-key $offset
     * @return TValue
     */
    public function offsetGet(mixed $offset): mixed {
        return $this->data[$offset];
    }

    /**
     * @inheritDoc
     *
     * @param array-key|null $offset
     * @param TValue $value
     */
    public function offsetSet(mixed $offset, mixed $value): void {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     *
     * @param array-key $offset
     */
    public function offsetUnset(mixed $offset): void {
        unset($this->data[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function count(): int {
        return \count($this->data);
    }

    /**
     * @inheritDoc
     */
    public function clear(): void {
        $this->data = [];
    }

    /**
     * @inheritDoc
     */
    public function empty(): bool {
        return $this->count() === 0;
    }

    /**
     * @inheritDoc
     */
    public function each(callable $callback): self {
        foreach ($this->data as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function filter(callable $callback): self {
        $self = clone $this;
        $self->data = \array_merge([], \array_filter($self->data, $callback));

        return $self;
    }

    /**
     * @inheritDoc
     */
    public function first(): mixed {
        $index = \array_key_first($this->data);

        if ($index === null) {
            throw new \RuntimeException("Can't find a first element, array is empty.");
        }

        return $this[$index];
    }

    /**
     * @inheritDoc
     */
    public function last(): mixed {
        $index = \array_key_last($this->data);

        if ($index === null) {
            throw new \RuntimeException("Can't find a last element, array is empty.");
        }

        return $this[$index];
    }
}
