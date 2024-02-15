<?php

namespace Nuldark\Stdlib\Set;

use Nuldark\Stdlib\Collection;

/**
 * @template TValue
 *
 * @extends \Nuldark\Stdlib\Collection<TValue>
 */
interface SetInterface extends Collection
{
    /**
     * Get all items from collection.
     *
     * @return array<array-key, TValue>
     */
    public function all(): array;

    /**
     * Adds specify element to the collection.
     *
     * @param TValue $element
     * @return void
     *
     */
    public function add(mixed $element): void;

    /**
     * Returns `true` if collection contains specify element.
     *
     * @param TValue $element
     * @param bool $strict
     *
     * @return bool
     */
    public function contains(mixed $element, bool $strict = false): bool;
}
