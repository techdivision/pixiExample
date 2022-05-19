<?php
/**
 * Copyright (c) 2022 TechDivision GmbH
 * All rights reserved
 *
 * This product includes proprietary software developed at TechDivision GmbH, Germany
 * For more information see https://www.techdivision.com/
 *
 * To obtain a valid license for using this software please contact us at
 * license@techdivision.com
 */
declare(strict_types=1);

namespace pixiExample\PixiApiCustomize\Observer;

use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order;
use TechDivision\Pixi\Helper\Config;

/**
 * @copyright  Copyright (c) 2022 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link       http://www.techdivision.com/
 * @author     MET <met@techdivision.com>
 */
class EnableEmailPollingExportOrderAfter extends AbstractObserver
{
    public function execute(Observer $observer)
    {
        //get generated xml data via observer data
        $xml = $observer->getData('xml');
        $xmlData = $xml->getData('data');
        //replace value of "EXPORT_EMAIL_PHONE_POLLING" with "Y" (yes) - default value is "N" (no)
        $xmlData['ORDER_HEADER']['ORDER_INFO']['ORDER_PARTIES']['SHIPMENT_PARTIES']['DELIVERY_PARTY']
            ['PARTY']['ADDRESS']['EXPORT_EMAIL_PHONE_POLLING'] = "Y";
        //override with manipulated data
        $xml->setData('data', $xmlData);
    }
}
