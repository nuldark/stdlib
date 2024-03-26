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

use Nuldark\Stdlib\XML\Exception\MissingAttributeException;
use Nuldark\Stdlib\XML\Exception\RuntimeException;

abstract class AbstractElement
{
    /**
     * Gets a prefix for this element.
     *
     * @return null|string
     */
    abstract protected static function getNamespacePrefix(): ?string;

    /**
     * Gets a namespace URI for the element.
     *
     * @return string
     */
    abstract protected static function getNamespaceURI(): string;

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
     * Coverts the given XML into an element instance.
     *
     * @param \DOMElement $xml
     *  The sourced element.
     *
     * //phpcs:ignore @return static
     *  Returns a new instance of the element.
     *
     * @throws \Exception If an error occurs while creating the element.
     */
    public static function fromXML(/* phpcs:ignore  */ \DOMElement $xml): static {
        throw new RuntimeException('Not implemented yet.');
    }

    /**
     * Gets an attribute from element.
     *
     * @param \DOMElement $xml
     *  The sourced element.
     * @param string $attribute
     *  The attribute name.
     *
     * @return string
     *  Returns the attribute from element.
     *
     * @throws \Nuldark\Stdlib\XML\Exception\MissingAttributeException
     */
    public static function getAttribute(\DOMElement $xml, string $attribute): string {
        if (!$xml->hasAttribute($attribute)) {
            throw new MissingAttributeException(
                "Attribute '$attribute' was missing."
            );
        }
        return $xml->getAttribute($attribute);
    }

    /**
     * Gets an optional attribute from element.
     *
     * @param \DOMElement $xml
     *  The sourced element.
     * @param string $attribute
     *  The attribute name.
     * @param string|null $default
     *  The default value to return if the attribute does not exist.
     *
     * @return string|null
     *   Returns the attribute from element.
     */
    public static function getOptionalAttribute(\DOMElement $xml, string $attribute, ?string $default = null): ?string {
        if ($xml->hasAttribute($attribute)) {
            return $default;
        }

        return $xml->getAttribute($attribute);
    }

    /**
     * Transforms given XML into class instances.
     *
     * @param \DOMElement $element
     *  The sourced element.
     * @return array
     *  Returns an array of elements.
     * @throws \Exception
     */
    public static function getElementOfClass(\DOMElement $element): array {
        $classes = [];

        foreach ($element->childNodes as $child) {
            if (!($child instanceof \DOMElement)) {
                continue;
            }

            if ($child->localName === static::getTagName() && $child->namespaceURI === static::getNamespaceURI()) {
                $classes[] = static::fromXML($child);
            }
        }

        return $classes;
    }

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
        $namespace = static::getNamespaceURI();
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
        $prefix = static::getNamespacePrefix();
        $qualifiedName = static::getTagName();

        return $prefix !== null ? ($prefix . ':' . $qualifiedName) : $qualifiedName;
    }

    /**
     * Returns the tag name for the current element.
     *
     * @return string
     *  Returns tag name.
     */
    private static function getTagName(): string {
        return \array_slice(\explode('\\', static::class), -1)[0];
    }
}
