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

abstract class AbstractElement
{
    /**
     * Converts the current element to an XML element.
     *
     * @param \DOMElement|null $parent
     *  The parent element.
     *
     * @return \DOMElement
     *  Returns a new XML element.
     *
     * @throws \DOMException If an error occurs while creating the element.
     */
    abstract public function toXML(\DOMElement $parent = null): \DOMElement;

    /**
     * Gets a prefix for this element.
     *
     * @return null|string
     */
    abstract protected function getNamespacePrefix(): ?string;

    /**
     * Gets a namespace URI for the element.
     *
     * @return string
     */
    abstract protected function getNamespaceURI(): string;

    /**
     * Creates a new XML structure for the current element.
     *
     * @param \DOMElement|null $parent
     *  The parent element.
     *
     * @return \DOMElement
     *  Returns a new XML element.
     *
     * @throws \DOMException If an error occurs while creating the element.
     */
    protected function createElement(\DOMElement $parent = null): \DOMElement {
        $namespace = $this->getNamespaceURI();
        $qualifiedName = $this->getQualifiedName();

        if ($parent === null) {
            $parent = new \DOMDocument('1.0', 'UTF-8');
            $e = $parent->createElementNS($namespace, $qualifiedName);
        } else {
            $doc = $parent->ownerDocument;
            $e = $doc->createElementNS($namespace, $qualifiedName);
        }

        $parent->appendChild($e);
        return $e;
    }

    /**
     * Returns the qualified name (prefix:tagname) for the current element.
     *
     * @return string
     *  Returns qualified name.
     */
    private function getQualifiedName(): string {
        $prefix = $this->getNamespacePrefix();
        $qualifiedName = $this->getTagName();

        return $prefix !== null ? ($prefix . ':' . $qualifiedName) : $qualifiedName;
    }

    /**
     * Returns the tag name for the current element.
     *
     * @return string
     *  Returns tag name.
     */
    private function getTagName(): string {
        return \array_slice(\explode('\\', static::class), -1)[0];
    }
}
