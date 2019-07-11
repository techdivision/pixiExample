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

use \Magento\Framework\Event\Observer;
use SimpleXMLElement;

/**
 * @copyright   Copyright (c) 2018 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link        https://www.techdivision.com/
 * @author      Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 */
class ExportOrderAfter extends AbstractObserver
{
    public function execute(Observer $observer)
    {
        // get order.
        $order = $observer->getData('order');

        // get xml tree of order as DataObject.
        $xml = $observer->getData('xml');

        // extract the data and fiddle with it.
        $xmlData = $xml->getData('data');
        $xmlData = $this->getRemarks($xmlData, $order);

        // save it back to change the xml tree.
        $xml->setData('data', $xmlData);
    }

    /**
     * @param $xmlData
     */
    public function getRemarks($xmlData, $order)
    {
        $orderInfo = $xmlData['ORDER_HEADER']['ORDER_INFO'];
        $foundRemarkType = array();
        foreach ($orderInfo as $key => $value) {
            if ($value instanceof SimpleXMLElement) {
                /** $value SimpleXMLElement */
                if ($value->getName() == 'REMARK') {
                    $foundRemarkType[(string)$value['type']] = true;
                    switch ((string)$value['type']) {
                        case 'SHIPPING':
                            break;
                        case 'VOUCHERCODE':
                            break;
                        case 'DISCOUNT':
                            break;
                        case 'SHIPPINGVENDOR':
                            $value[0] = $value[0] . ' StarUpsDhlCoop';
                            break;
                    }
                }
            }
        }
        if (!isset($foundRemarkType['FooBar'])) {
            $foobar = $this->createXmlElement('REMARK', array('type' => 'FooBar'), 1234.56);
            $orderInfo[] = $foobar;
            $xmlData['ORDER_HEADER']['ORDER_INFO'] = $orderInfo;
        }
        return $xmlData;
    }
}
