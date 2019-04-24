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
use \Magento\Framework\Event\ObserverInterface;

/**
 * @copyright   Copyright (c) 2018 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link        https://www.techdivision.com/
 * @author      Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 */
class ExportOrderAfter implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        // get order.
        $order     = $observer->getData('order');

        // get xml tree of order as DataObject.
        $xml       = $observer->getData('xml');

        // extract the data and fiddle with it.
        $xmlData   = $xml->getData('data');
        $xmlData['NEWELEMENT'] = 'OrderVALUE';

        // save it back to change the xml tree.
        $xmlData->setData('data', $xmlData);
    }
}
