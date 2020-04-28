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
 * @copyright   Copyright (c) 2018 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link        https://www.techdivision.com/
 * @author      Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 */
class ExportCatalogProductCollection extends AbstractObserver
{
    /**
     * Observe product collection to allow changes and additions
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var \TechDivision\Pixi\Model\ResourceModel\Product\Collection $productCollection */
        $productCollection = $observer->getData('product_collection');

        $productCollection->addAttributeToSelect(['meta_description']);

        // limit number of product
        $productCollection->setPage(1, 50);
    }
}
