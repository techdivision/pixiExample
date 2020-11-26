<?php
/**
 * Copyright (c) 2019 TechDivision GmbH
 * All rights reserved
 *
 * This product includes proprietary software developed at TechDivision GmbH, Germany
 * For more information see http://www.techdivision.com/
 *
 * To obtain a valid license for using this software please contact us at
 * license@techdivision.com
 */

namespace pixiExample\PixiApiCustomize\Observer;

use \Magento\Framework\Event\ObserverInterface;
use SimpleXMLElement;

/**
 * @copyright   Copyright (c) 2018 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link        https://www.techdivision.com/
 * @author      Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 */
abstract class AbstractObserver implements ObserverInterface
{

    /**
     * Encode a value
     *
     * @param string $value
     * @return string
     */
    protected function encodeValue($value)
    {
        return $value === '' || $value === null ? null : htmlentities($value, ENT_XML1);
    }

    /**
     * Add child to XML element
     *
     * @param SimpleXMLElement $xml
     * @param string $name
     * @param string [$value]
     * @return SimpleXMLElement
     */
    protected function addChild(SimpleXMLElement $xml, $name, $value = null)
    {
        return $xml->addChild($name, $this->encodeValue($value));
    }

    /**
     * Add an attribute
     *
     * @param SimpleXMLElement $xml
     * @param string $name
     * @param string $value
     * @return SimpleXMLElement
     */
    protected function addAttribute(SimpleXMLElement $xml, $name, $value)
    {
        // add attribute
        $xml->addAttribute($name, $this->encodeValue($value));
        // return element
        return $xml;
    }

    /**+
     * Create a SimpleXMLElement
     * @param $tag
     * @param array $attributes
     * @param null $content
     * @return SimpleXMLElement
     */
    protected function createXmlElement($tag, array $attributes = [], $content = null)
    {
        // create new XML element
        $xml = new SimpleXMLElement(sprintf('<%s/>', $tag));
        // add attributes
        foreach ($attributes as $name => $value) {
            $this->addAttribute($xml, $name, $value);
        }
        // set content
        if (!is_null($content)) {
            $xml[0] = $content;
        }
        // return element
        return $xml;
    }


    /**
     * Add an XML child to an XML element
     *
     * @param SimpleXMLElement $to
     * @param SimpleXMLElement $from
     */
    protected function addXmlChild(SimpleXMLElement $to, SimpleXMLElement $from)
    {
        // convert to dom
        $toDom = dom_import_simplexml($to);
        $fromDom = dom_import_simplexml($from);
        // append
        $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
    }

    /**
     * Add children to XML object
     *
     * @param SimpleXMLElement $xml
     * @param array $data
     * @return SimpleXMLElement
     */
    protected function addArrayToXml(SimpleXMLElement $xml, array $data)
    {
        // iterate over data and set children
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $child = $this->addChild($xml, $key);
                $this->addArrayToXml($child, $value);
            } elseif ($value instanceof SimpleXMLElement) {
                $this->addXmlChild($xml, $value);
            } elseif ($key !== '' && $value !== '' && !is_null($value)) {
                $this->addChild($xml, $key, $value);
            }
        }

        // return xml
        return $xml;
    }
}
