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

/**
 * @copyright   Copyright (c) 2019 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link        https://www.techdivision.com/
 * @author      Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 */
class ImportOrderStatusAfter extends AbstractObserver
{
    /** @var \TechDivision\Pixi\Logger\Logger */
    private $pixiLogger;

    /**
     * @param \TechDivision\Pixi\Logger\Logger $pixiLogger
     */
    public function __construct(\TechDivision\Pixi\Logger\Logger $pixiLogger)
    {
        $this->pixiLogger = $pixiLogger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        // get observer parameter
        // true = Not in "Developer mode without change"
        $changedAllowed = $observer->getData('changedAllowed');
        $originStatus = $observer->getData('oldStatus');

        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getData('order');
        $xml = $observer->getData('xml');

        // get XML from request
        $xmlData = $xml->getData('data');

        $itemId = $xmlData['LINE_ITEM_ID'];
        $orderItem = $order->getItemById($itemId);
        if (!$orderItem) {
            $this->pixiLogger->error(sprintf('Ups, why can not find order item ID "%s" from order "%s"', $itemId, $order->getIncrementId()));
            return;
        }

        if ($order->getStatus() != $originStatus) {
            if ($changedAllowed) {
                $this->pixiLogger->info('Just do some fancy stuff that missing in magento.');
            } else {
                $this->pixiLogger->info('Order status changed, but not on dev mode :-)');
            }
        } else {
            $this->pixiLogger->info(sprintf('Order status "%s" not changed!', $originStatus));
        }
    }
}
