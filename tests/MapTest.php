<?php

/*
 * This file is part of the nuldark/stdlib.
 *
 * Copyright (C) 2023-2024 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE.md file for details.
 */

namespace Nuldark\Stdlib\Tests;

use Nuldark\Stdlib\Map\Map;
use Nuldark\Stdlib\StdArray;
use Nuldark\Stdlib\Tests\Fixture\Foo;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(StdArray::class)]
class MapTest extends \PHPUnit\Framework\TestCase
{
    public function testKeys(): void {
        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $map = new Map([$foo1, $foo2]);

        self::assertCount(2, $map->keys());
        self::assertEquals($foo1, $map->first());
        self::assertEquals($foo2, $map->last());
    }

    public function testPut(): void {
        $map = new Map();

        self::assertNull($map->put(1, new Foo(1, 'foo1')));
    }

    public function testPutReturnsPreviousValue(): void {
        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $map = new Map();
        $map->put(1, $foo1);

        self::assertEquals($foo1, $map->put(1, $foo2));
        self::assertEquals($foo2, $map->get(1));
    }

    public function testRemoveReturnsRemovedValue(): void {
        $foo = new Foo(1, 'foo1');

        $map = new Map();
        $map->put(1, $foo);

        self::assertEquals($foo, $map->remove(1));
        self::assertNull($map->get(1));
    }

    public function testGet(): void {
        $foo = new Foo(1, 'foo1');
        $map = new Map([$foo]);

        self::assertEquals($foo, $map->get(0));
    }

    public function testGetReturnsDefaultValueIfNotFound(): void {
        $foo = new Foo(1, 'foo1');
        $map = new Map([$foo]);

        self::assertEquals($foo, $map->get(2, $foo));
    }
}
