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

use Magento\Framework\Event\Observer;
use SimpleXMLElement;

/**
 * @copyright Copyright (c) 2018 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link      https://www.techdivision.com/
 * @author    Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 */
class ExportOrderAfter extends AbstractObserver
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        // get order.
//        $order = $observer->getData('order');

        // get xml tree of order as DataObject.
        $xml = $observer->getData('xml');

        // extract the data and fiddle with it.
        $xmlData = $xml->getData('data');

        // example for own order item
        // $xmlData = $this->getNewOrderItem($xmlData);

        // example for manipulate remarks
        // $xmlData = $this->getRemarks($xmlData, $order);

        // save it back to change the xml tree.
        $xml->setData('data', $xmlData);
    }

    /**
     * @param  array                      $xmlData
     * @return array
     */
    public function getRemarks($xmlData)
    {
        $orderInfo = $xmlData['ORDER_HEADER']['ORDER_INFO'];
        $foundRemarkType = [];
        foreach ($orderInfo as $value) {
            if ($value instanceof SimpleXMLElement) {
                if ($value->getName() === 'REMARK') {
                    $foundRemarkType[(string)$value['type']] = true;
                    switch ((string)$value['type']) {
                        case 'VOUCHERCODE':
                        case 'DISCOUNT':
                        case 'SHIPPING':
                            break;
                        case 'SHIPPINGVENDOR':
                            $value[0] .= ' StarUpsDhlCoop';
                            break;
                    }
                }
            }
        }
        if (!isset($foundRemarkType['FooBar'])) {
            $foobar = $this->createXmlElement('REMARK', ['type' => 'FooBar'], 1234.56);
            $orderInfo[] = $foobar;
            $xmlData['ORDER_HEADER']['ORDER_INFO'] = $orderInfo;
        }
        return $xmlData;
    }

    /**
     * Wanna add own Order Item? Here an example how it works
     *
     * @param  array $xmlData
     * @return array
     */
    public function getNewOrderItem($xmlData)
    {
        // define xml data
        $xmlArray = [
            // item id
            'LINE_ITEM_ID' => 99,
            'ARTICLE_ID' => [
                'SUPPLIER_AID' => 'MyProductId',
            ],
            // quantity
            'QUANTITY' => (float)1,
            // names and descriptions
            'DESCRIPTION_SHORT' => 'Dynamik item Product',
            'ITEM_NOTE' => '',
            'ITEM_NAME' => 'DI Product',
            // prices
            $this->addArrayToXml(
                $this->createXmlElement(
                    'ARTICLE_PRICE',
                    [
                        'type' => 'udp_gross_customer' // Or 'udp_net_customer'
                    ]
                ),
                [
                    'FULL_PRICE' => 8.5,
                    'PRICE_AMOUNT' => 8.5,
                    'PRICE_LINE_AMOUNT' => 8.5,
                    'DISCOUNT_VALUE' => 0.00,
                ]
            ),
        ];
        $xmlData['ORDER_ITEM_LIST'][] = $this->addArrayToXml($this->createXmlElement('ORDER_ITEM'), $xmlArray);
        $xmlData['ORDER_SUMMARY']['TOTAL_ITEM_NUM'] += 1;
        return $xmlData;
    }
}
