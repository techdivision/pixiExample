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

use Magento\Framework\DataObject;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order as OrderModel;
use SimpleXMLElement;
use TechDivision\Pixi\Helper\Config;
use TechDivision\Pixi\Logger\Logger;

/**
 * @copyright Copyright (c) 2024 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link      https://www.techdivision.com/
 * @author    Patrick Mehringer <o.mehringer@techdivision.com>
 */
class ChangeShippingExportOrderAfter extends AbstractObserver
{
    /** @var Logger */
    private Logger $logger;

    /** @var Config */
    private Config $config;

    /**
     * @param Config $config
     * @param Logger $logger
     */
    public function __construct(
        Config $config,
        Logger $logger
    ) {
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getData('order');

        $xml = $observer->getData('xml');
        $xmlData = $xml->getData('data');

        // add shipping vendor remark
        $shippingMethod = $this->getShippingMethod($order, true);
        if ($shippingMethod && $vendor = $this->getShippingCarrier($shippingMethod)) {
            $remark = $this->createXmlElement('REMARK', ['type' => 'SHIPPINGVENDOR'], $vendor);
        } elseif (!$shippingMethod && $order->getIsVirtual()) {
            $vendor = $this->config->getShippingCarrierMappingValue(
                'virtual_quote',
                'virtual_quote'
            );
            $remark = $this->createXmlElement('REMARK', ['type' => 'SHIPPINGVENDOR'], $vendor);
        }

        foreach ($xmlData['ORDER_HEADER']['ORDER_INFO'] as $idx => $data) {
            if ($data instanceof SimpleXMLElement && (string)$data->attributes()['type'] === 'SHIPPINGVENDOR'){
                unset($xmlData['ORDER_HEADER']['ORDER_INFO'][$idx]);
                $vendor = $this->createXmlElement('REMARK', ['type' => 'SHIPPINGVENDOR'], $remark);
                $xmlData['ORDER_HEADER']['ORDER_INFO'][] = $vendor;
            }
        }

        $transport = $this->getTransportRemark($order);
        $xmlData['ORDER_HEADER']['ORDER_INFO']['TRANSPORT_REMARKS'] = $transport;

        $xml->setData('data', $xmlData);
    }

    /**
     * Retrieve shipping method
     *
     * @param OrderModel $order
     * @param bool $asObject return carrier code and shipping method data as object
     * @return null|DataObject
     */
    private function getShippingMethod(OrderModel $order, bool $asObject = false): ?DataObject
    {
        if ($asObject) {
            $shippingMethod = (string)$order->getShippingMethod(false);
            if (strpos($shippingMethod, '_') === false) {
                return null;
            }
        }

        // get shipping method
        $method = $order->getShippingMethod(true);

        if ((substr_count($shippingMethod, '_') > 3) || (substr_count($shippingMethod, '_') % 2 == 0)) {
            // phpcs:disable Magento2.Files.LineLength, Generic.Files.LineLength
            $this->logger->warning('The shipping carrier code does not comply with the Magento standard. This can lead to errors in the shipping vendor mapping.');
            return null;
        }
        if ((strpos($method->getMethod(), '_') !== false)) {
            $this->logger->info('The shipping carrier code does not comply with the Magento standard.');
            $method->setCarrierCode(
                $method->getCarrierCode() . '_' . explode('_', $method->getMethod(), 2)[0]
            );
            $method->setMethod(explode('_', $method->getMethod(), 2)[1]);
            $this->logger->info(
                'Try to make the shipping vendor compatible => ' . $method->getCarrierCode()
            );
        }
        return $method;
    }

    /**
     * Get shipping carrier code
     *
     * @param DataObject|null $carrier
     * @return string|null
     */
    private function getShippingCarrier(?DataObject $carrier): ?string
    {
        if (!($carrier instanceof DataObject)) {
            return null;
        }
        return $this->config->getShippingCarrierMappingValue(
            $carrier->getData('carrier_code'),
            $carrier->getData('carrier_code')
        );
    }

    /**
     * @param OrderModel $order
     * @return string|null
     */
    private function getTransportRemark(OrderModel $order): ?string
    {
        // get shipping method
        $shippingMethod = $this->getShippingMethod($order, true);
        if ($shippingMethod) {
            return $this->getShippingCarrier($shippingMethod) . ';;;' . $shippingMethod->getData('method') . '|||';
        }
        return null;
    }
}
