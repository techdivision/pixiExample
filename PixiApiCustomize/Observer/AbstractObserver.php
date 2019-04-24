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

}
