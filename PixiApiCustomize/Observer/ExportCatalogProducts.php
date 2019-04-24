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
class ExportCatalogProducts extends AbstractObserver
{
    public function execute(Observer $observer)
    {
        // get xml tree of order as DataObject.
        $xml = $observer->getData('product_section');

        $newFeature = $this->addChild($xml, 'TD_LAST_SECTION_IN_CATALOG');
        $this->addChild($newFeature, 'OWN_DATA', 'TD_NEW_DATA');
    }

}
