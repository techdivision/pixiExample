<?php

namespace pixiExample\PixiApiCustomize\Observer;

use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface as Logger;

/**
 * @copyright  Copyright (c) 2020 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link       http://www.techdivision.com/
 * @author     MET <met@techdivision.com>
 */
class ImportStockItemBeforeSave extends AbstractObserver
{
    /**
     *
     *
     * @var Logger
     */
    private $pixiLogger;

    /**
     * @param Logger $pixiLogger
     */
    public function __construct(Logger $pixiLogger)
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
        $this->pixiLogger->info(
            sprintf(
                'Import stock quantity %s from SKU %s',
                $stockItem->getQty(),
                $product->getSku()
            )
        );

        if ($xml_item_data['QUANTITY'] <= 0 && $xml_item_data['MIN_STOCK_QTY'] == -99) {
            $stockItem->setIsInStock(false);

            if (!$perform_product_save) {
                // Force to save product if anything changed in this observer on product model
                $observer->setData('perform_product_save', true);
            }
        }
    }
}
