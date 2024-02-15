<?php

/*
 * This file is part of the nuldark/stdlib.
 *
 * Copyright (C) 2023-2024 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE.md file for details.
 */

namespace Nuldark\Stdlib\Set;

use Nuldark\Stdlib\StdArray;

/**
 * @template TValue
 *
 * @extends \Nuldark\Stdlib\StdArray<TValue>
 * @implements \Nuldark\Stdlib\Set\SetInterface<TValue>
 */
class Set extends StdArray implements SetInterface
{
    /**
     * @inheritDoc
     */
    public function all(): array {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function add(mixed $element): void {
        $this->data[] = $element;
    }

    /**
     * @inheritDoc
     */
    public function contains(mixed $element, bool $strict = false): bool {
        return \in_array($element, $this->data, $strict);
    }
}
