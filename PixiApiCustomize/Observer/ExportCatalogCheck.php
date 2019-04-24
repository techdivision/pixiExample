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
class ExportCatalogCheck extends AbstractObserver
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        // get order.
        $performExportFlag = $observer->getData('perform_export_flag');

        // Condition to stop Export.
        if ($performExportFlag == 0 /* or something else */) {
            $observer->setData('perform_export_flag', false);
        }
    }
}
