<?php

/*
 * This file is part of the nuldark/stdlib.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE.md file for details.
 */

namespace Nuldark\Stdlib\XML\Exception;

class UnparseableException extends \RuntimeException
{
    public function __construct(\LibXMLError $error) {
        $message = \sprintf(
            'Unable to parse XML: "%s" in "%s" at line "%d" on column "%d"',
            $error->message,
            $error->file ?: '(string)',
            $error->line,
            $error->column,
        );

        parent::__construct($message, $error->code);
    }
}
