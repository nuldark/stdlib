<?php

/*
 * This file is part of the nuldark/stdlib.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE.md file for details.
 */

namespace Nuldark\Stdlib\Tests\XML;

use DOMDocument;
use Nuldark\Stdlib\XML\DOMDocumentFactory;
use Nuldark\Stdlib\XML\Exception\UnparseableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DOMDocumentFactory::class)]
class DOMDocumentFactoryTest extends TestCase
{
    public function testCreateMethodCreatesNewDOMDocumentInstance(): void {
        $document = DOMDocumentFactory::create();

        $this->assertInstanceOf(DOMDocument::class, $document);
    }

    public function testFromStringMethodCreatesNewDOMDocumentInstanceFromXMLString(): void {
        $document = DOMDocumentFactory::fromString('<root></root>');

        $this->assertInstanceOf(DOMDocument::class, $document);
    }

    public function testFromStringMethodThrowsUnparseableExceptionIfXMLStringIsInvalid(): void {
        $this->expectException(UnparseableException::class);
        DOMDocumentFactory::fromString('<root></foo>');
    }

    public function testFromStringMethodSetsInternalErrorsOfXMLParserToTrueAndRestoresThemToPreviousState(): void {
        \libxml_clear_errors();

        $internalErrors = libxml_use_internal_errors(true);
        DOMDocumentFactory::fromString('<root></root>');

        $lastError = libxml_get_last_error();
        \libxml_clear_errors();
        \libxml_use_internal_errors($internalErrors);

        self::assertFalse($lastError);
    }
}
