<?php

namespace pixiExample\PixiApiCustomize\Observer;

use \Magento\Framework\Event\Observer;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use TechDivision\Pixi\Logger\Logger;

class ImportStockProductBeforeSave extends AbstractObserver
{
    /** @var \TechDivision\Pixi\Logger\Logger */
    private $pixiLogger;

    /**
     * @param \TechDivision\Pixi\Logger\Logger $pixiLogger
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
        // Any change in EAN or active state? Is it necessary to save the product?
        $perform_product_save = $observer->getData('perform_product_save');

        // get product.
        $product = $observer->getData('product');

        // Get xml data from import stock call per item
        $xml_item_data = $observer->getData('xml_item_data');

        // Get product attribute data
        $attribute_data = $observer->getData('attribute_data');

        if (!empty($xml_item_data['EAN'])) {
            $this->pixiLogger->info('Import has EAN');
        }
        $this->pixiLogger->info('Status from Product', ['SKU' => $product->getSku(), 'Status' => $product->getStatus()]);

        // disable product if stock quantity <= 0 and MIN_STOCK_QTY = -99
        if ($xml_item_data['QUANTITY'] <= 0 && $xml_item_data['MIN_STOCK_QTY'] == -99) {
            $this->pixiLogger->info('stock quantity <= 0 and MIN_STOCK_QTY = -99');
            $attribute_data['status'] = Status::STATUS_DISABLED;

            $this->pixiLogger->info("Setting attribute_data to this: " . json_encode($attribute_data));
            $observer->setData('attribute_data', $attribute_data);

            if (!$perform_product_save) {
                // Force to save product if anything changed in this observer on product model
                $observer->setData('perform_product_save', true);
            }
        } elseif ($xml_item_data['MIN_STOCK_QTY'] == -99) {
            //do not allow backorders when MIN_STOCK_QTY = -99 -> this is an EOL product
            $this->pixiLogger->info('Only MIN_STOCK_QTY = -99, this is an EOL product');
            $attribute_data['backorders'] = \Magento\CatalogInventory\Model\Stock::BACKORDERS_NO;
            $attribute_data['use_config_backorders'] = 1;

            $this->pixiLogger->info("Setting attribute_data to this: " . json_encode($attribute_data));

            $observer->setData('attribute_data', $attribute_data);
            if (!$perform_product_save) {
                // Force to save product if anything changed in this observer on product model
                $observer->setData('perform_product_save', true);
            }
        }
    }
}
