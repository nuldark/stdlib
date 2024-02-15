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

use Nuldark\Stdlib\Glob;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Glob::class)]
class GlobTest extends \PHPUnit\Framework\TestCase
{
    public function testNonMatchingGlobReturnsEmptyArray(): void {
        $results = Glob::glob(
            '/root/{,*.}.php',
            Glob::GLOB_BRACE,
        );

        self::assertEquals([], $results);
    }

    public function testGlobWithFlags(): void {
        $pattern = '*.php';
        $expected = \glob($pattern, \GLOB_NOSORT);

        $result = Glob::glob($pattern, Glob::GLOB_NOSORT);

        self::assertEquals($expected, $result);
    }

    public function testGlobWithInvalidPattern(): void {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Pattern exceeds the maximum allowed length of 4096 characters');

        Glob::glob('/' . \str_repeat('spark', 10000));
    }
}
