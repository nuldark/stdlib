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

use Nuldark\Stdlib\StdArray;
use Nuldark\Stdlib\Tests\Fixture\Foo;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(StdArray::class)]
class StdArrayTest extends \PHPUnit\Framework\TestCase
{
    public function testFilter(): void {
        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $stdArray = new StdArray([$foo1, $foo2]);
        $stdArray = $stdArray->filter(fn(Foo $foo) => $foo->id === 2);

        self::assertCount(1, $stdArray);
        self::assertEquals($foo2, $stdArray->first());
    }

    public function testFirst(): void {
        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $stdArray = new StdArray([$foo1, $foo2]);

        self::assertSame($foo1, $stdArray->first());
        self::assertEquals($foo1, $stdArray[0]);
        self::assertInstanceOf(Foo::class, $stdArray->first());
    }

    public function testFirstThrowsExceptionIfArrayIsEmpty(): void {
        self::expectException(\RuntimeException::class);
        self::expectExceptionMessage("Can't find a first element, array is empty.");

        $stdArray = new StdArray([]);
        $stdArray->first();
    }

    public function testLast(): void {
        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $stdArray = new StdArray([$foo1, $foo2]);

        self::assertSame($foo2, $stdArray->last());
        self::assertInstanceOf(Foo::class, $stdArray->last());
    }

    public function testLastThrowsExceptionWhenArrayIsEmpty(): void {
        self::expectException(\RuntimeException::class);
        self::expectExceptionMessage("Can't find a last element, array is empty.");

        $stdArray = new StdArray([]);
        $stdArray->last();
    }

    public function testClear(): void {
        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $stdArray = new StdArray([$foo1, $foo2]);
        $stdArray->clear();

        self::assertCount(0, $stdArray);
    }

    public function testEmpty(): void {
        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $stdArray = new StdArray([$foo1, $foo2]);

        self::assertFalse($stdArray->empty());
        $stdArray->clear();
        self::assertTrue($stdArray->empty());
    }

    public function testEach(): void {
        $it = 0;

        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $stdArray = new StdArray([$foo1, $foo2]);
        $stdArray->each(function (Foo $foo) use (&$it) {
            $it++;
        });

        self::assertEquals(2, $it);
    }

    public function testReturnsFalseBreakEachLoop(): void {
        $it = 0;

        $foo1 = new Foo(1, 'foo1');
        $foo2 = new Foo(2, 'foo2');

        $stdArray = new StdArray([$foo1, $foo2]);
        $stdArray->each(function () use (&$it): bool {
            $it++;
            return false;
        });

        self::assertEquals(1, $it);
    }
}
