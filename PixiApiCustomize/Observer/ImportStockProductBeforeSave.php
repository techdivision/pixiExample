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
class ImportStockProductBeforeSave extends AbstractObserver
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
        // Any change in EAN or active state? Is it necessary to save the product?
        $perform_product_save = $observer->getData('perform_product_save');

        // get product.
        $product = $observer->getData('product');

        // Get xml data from import stock call per item
        $xml_item_data = $observer->getData('xml_item_data');

        if (!empty($xml_item_data['EAN'])) {
            $this->pixiLogger->info('Import has EAN');
        }
        $this->pixiLogger->info('Status from Product', ['SKU' => $product->getSku(), 'Status' => $product->getStatus()]);

        // Force to save product if anything changed in this observer
        //   $observer->setData('perform_product_save', true);
    }
}
