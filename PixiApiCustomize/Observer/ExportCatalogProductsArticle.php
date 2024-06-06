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
 * @copyright Copyright (c) 2018 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link      https://www.techdivision.com/
 * @author    Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 */
class ExportCatalogProductsArticle extends AbstractObserver
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        // get product.
        $product = $observer->getData('product');

        // get xml tree of order as DataObject.
        $xml = $observer->getData('article');

        // manipulate / change xml data for products
        if ($product->getData('pixi_product_name')) {
            $xml->ARTICLE_DETAILS->DESCRIPTION_SHORT = $product->getData('pixi_product_name');
            $observer->setData('product', $xml);
        }
    }
}
