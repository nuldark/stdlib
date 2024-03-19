<?php

/*
 * This file is part of the nuldark/stdlib.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE.md file for details.
 */

namespace Nuldark\Stdlib;

class XML
{
    /**
     * Canonicalizes the given element.
     *
     * @param \DOMElement $element
     *  The element to canonicalize.
     * @param string $c14alg
     *  The canonicalization method.
     * @param string[]|null $xpaths
     *  An array of xpaths to filter the nodes.
     * @param string[]|null $prefixes
     *  An array of namespaces to filter the nodes.
     *
     * @return string
     */
    public static function canonicalizeData(
        \DOMElement $element,
        string $c14alg,
        ?array $xpaths = null,
        ?array $prefixes = null
    ): string {
        $exclusive = match ($c14alg) {
            'http://www.w3.org/2001/10/xml-exc-c14n#',
            'http://www.w3.org/2001/10/xml-exc-c14n#WithComments' => true,
            default => false
        };

        $withComments = match ($c14alg) {
            'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments',
            'http://www.w3.org/2001/10/xml-exc-c14n#WithComments' => true,
            default => false
        };
        // phpcs:disable
        if (
            $xpaths === null
            && ($element->ownerDocument->documentElement !== null)
            && ($element->isSameNode($element->ownerDocument->documentElement))
        ) {
        // phpcs:enable
            $current = $element;
            $ref = null;

            while ($ref = $current->previousElementSibling) {
                if (($ref->nodeType === \XML_COMMENT_NODE && $withComments) || $ref->nodeType === \XML_PI_NODE) {
                    break;
                }

                $current = $ref;
            }

            if ($ref === null) {
                $element = $element->ownerDocument;
            }
        }

        return $element->C14N($exclusive, $withComments, $xpaths, $prefixes);
    }
}
