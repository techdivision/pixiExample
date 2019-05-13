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

use Magento\Catalog\Model\Product\Attribute\Source\Status as ProductStatus;
use \Magento\Framework\Event\Observer;

/**
 * @copyright   Copyright (c) 2019 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link        https://www.techdivision.com/
 * @author      Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 */
class ImportStockItemBeforeSave extends AbstractObserver
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
        // Any change on product? Is it necessary to save the product?
        $perform_product_save = $observer->getData('perform_product_save');

        // get stock item
        $stockItem = $observer->getData('stock_item');
        $product = $observer->getData('product');

        // Get xml data from import stock call per item
        $xml_item_data = $observer->getData('xml_item_data');

        $this->pixiLogger->info('XML data from Pixi', $xml_item_data);
        $this->pixiLogger->info(sprintf('Import stock quantity %s from SKU %s', $stockItem->getQty(), $product->getSku()));

        // For Example  Enable product if stock quantity = -99
        if ($stockItem->getQty() == -99) {
            $product->setStatus(strtolower(ProductStatus::STATUS_DISABLED));
            if (!$perform_product_save) {
                // Force to save product if anything changed in this observer on product model
                $observer->setData('perform_product_save', true);
            }
        }
    }
}
