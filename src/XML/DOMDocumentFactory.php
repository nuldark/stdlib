<?php

/*
 * This file is part of the nuldark/stdlib.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE.md file for details.
 */

namespace Nuldark\Stdlib\XML;

use Nuldark\Stdlib\XML\Exception\DOMException;
use Nuldark\Stdlib\XML\Exception\UnparseableException;

final class DOMDocumentFactory
{
    /**
     * Creates a new DOMDocument instance from an XML string.
     *
     * @param string $xml
     *  The XML string.
     * @param int|null $options
     *  The options for the XML parser.
     *
     * @return \DOMDocument
     *  Returns the new DOMDocument instance.
     *
     * @throws \Nuldark\Stdlib\XML\Exception\DOMException If an error occurs while creating the DOMDocument.
     * @throws \Nuldark\Stdlib\XML\Exception\UnparseableException If the XML string is not valid.
     */
    public static function fromString(string $xml, ?int $options = null): \DOMDocument {
        $internalErrors = \libxml_use_internal_errors(true);
        \libxml_clear_errors();

        $document = self::create();

        if ($options === null) {
            $options = LIBXML_NONET | LIBXML_PARSEHUGE | LIBXML_NSCLEAN;
            if (\defined('LIBXML_COMPACT')) {
                $options |= LIBXML_COMPACT;
            }
        }

        $result = $document->loadXML($xml, $options);
        \libxml_use_internal_errors($internalErrors);

        $error = \libxml_get_last_error();
        \libxml_clear_errors();

        if (!$result && $error !== false) {
            throw new UnparseableException($error);
        }

        foreach ($document->childNodes as $child) {
            if ($child->nodeType === XML_DOCUMENT_TYPE_NODE) {
                throw new DOMException(
                    'DOCTYPE node is not allowed in XML documents.'
                );
            }
        }

        return $document;
    }

    /**
     * Creates a new DOMDocument instance.
     *
     * @param string $version
     *  The version number of the document.
     * @param string $encoding
     *  The encoding of the document.
     *
     * @return \DOMDocument
     *  The new DOMDocument instance.
     */
    public static function create(string $version = '1.0', string $encoding = 'UTF-8'): \DOMDocument {
        return new \DOMDocument($version, $encoding);
    }
}
