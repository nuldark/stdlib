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

use Nuldark\Stdlib\Set\Set;
use Nuldark\Stdlib\Tests\Fixture\Foo;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Set::class)]
class SetTest extends \PHPUnit\Framework\TestCase
{
    public function testAllReturnsAllElements(): void {
        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $set = new Set([$foo1, $foo2]);

        self::assertEquals([$foo1, $foo2], $set->all());
        self::assertCount(2, $set->all());
    }

    public function testAdd(): void {
        $foo1 = new Foo(1, 'foo1');

        $set = new Set();
        $set->add($foo1);

        self::assertEquals([$foo1], $set->all());
        self::assertSame($foo1, $set->first());
    }

    public function testContains(): void {
        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $set = new Set([$foo1, $foo2]);

        self::assertTrue($set->contains($foo1));
        self::assertTrue($set->contains($foo2));
        self::assertFalse($set->contains(new Foo(3, 'foo3')));
    }
}
