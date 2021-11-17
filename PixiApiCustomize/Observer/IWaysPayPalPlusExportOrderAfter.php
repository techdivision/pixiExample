<?php
/**
 * Copyright (c) 2021 TechDivision GmbH
 * All rights reserved
 *
 * This product includes proprietary software developed at TechDivision GmbH, Germany
 * For more information see https://www.techdivision.com/
 *
 * To obtain a valid license for using this software please contact us at
 * license@techdivision.com
 */

namespace pixiExample\PixiApiCustomize\Observer;

use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order;
use pixiExample\PixiApiCustomize\Observer\AbstractObserver;

/**
 * @copyright  Copyright (c) 2021 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link       http://www.techdivision.com/
 * @author     MET <met@techdivision.com>
 */
class IWaysPayPalPlusExportOrderAfter extends AbstractObserver
{

    public function execute(Observer $observer)
    {
        /** @var Order $order */
        $order = $observer->getData('order');
        $payment = $order->getPayment();

        $xml = $observer->getData('xml');
        $xmlData = $xml->getData('data');

        if ($payment->getMethod() === 'iways_paypalplus_payment' &&
            $payment->getExtensionAttributes()->getPppInstructionType() === 'PAY_UPON_INVOICE')
        {
            $bankData = [
                'BANK_NAME' => $payment->getExtensionAttributes()->getPppBankName(),
                'HOLDER' => $payment->getExtensionAttributes()->getPppAccountHolderName(),
                'BIC' => $payment->getExtensionAttributes()->getPppBankIdentifierCode(),
                'IBAN' => $payment->getExtensionAttributes()->getPppInternationalBankAccountNumber()
            ];
            $xmlData['ORDER_HEADER']['ORDER_INFO']['PAYMENT'][$payment->getMethod()] = $bankData;
            $xml->setData('data', $xmlData);
        }
    }
}
