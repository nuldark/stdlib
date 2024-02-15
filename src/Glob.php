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

class Glob
{
    public const GLOB_ERR = 0x01;
    public const GLOB_MARK = 0x02;
    public const GLOB_NOSORT = 0x04;
    public const GLOB_NOCHECK = 0x08;
    public const GLOB_NOESCAPE = 0x10;
    public const GLOB_BRACE = 0x20;
    public const GLOB_ONLYDIR = 0x40;

    /** @var array<int,int> $flagsMap */
    public static array $flagsMap = [
        self::GLOB_MARK => \GLOB_MARK,
        self::GLOB_NOSORT => \GLOB_NOSORT,
        self::GLOB_NOCHECK => \GLOB_NOCHECK,
        self::GLOB_NOESCAPE => \GLOB_NOESCAPE,
        self::GLOB_BRACE => \GLOB_BRACE,
        self::GLOB_ONLYDIR => \GLOB_ONLYDIR,
        self::GLOB_ERR => \GLOB_ERR,
    ];

    /**
     * Searches for files and directories that match a given pattern.
     *
     * @param string $pattern
     *  The pattern to search for. The pattern should follow glob pattern rules.
     * @param int $flags
     *  Additional flags to modify the behavior of the glob. Default is 0.
     *  If provided, the flags will be combined with bitwise OR operation.
     *  Possible flag values can be found in the static::$flagsMap property.
     *
     * @return array
     *  An array containing the matched files and directories.
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public static function glob(string $pattern, int $flags = 0): array {
        if (\strlen($pattern) > 4096) {
            throw new \InvalidArgumentException(
                'Pattern exceeds the maximum allowed length of 4096 characters'
            );
        }

        $globFlags = 0;

        if ($flags > 0) {
            foreach (static::$flagsMap as $internal => $flag) {
                if (($flags & $internal) > 0) {
                    $globFlags |= $flag;
                }
            }
        }

        $res = \glob($pattern, $globFlags);

        if ($res === false) {
            throw new \RuntimeException("glob('{$pattern}', {$globFlags}) failed.");
        }

        return $res;
    }
}
