<?php
class Zakharo_Shipment_Model_Carrier
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    protected $_code = 'shipment';

    public function getConfigData()
    {
        return unserialize(Mage::getStoreConfig('carriers/shipment/add_store'));
    }
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        /** @var Mage_Shipping_Model_Rate_Result $result */
        $result = Mage::getModel('shipping/rate_result');
        $methods = $this->getAllowedMethods();
        $methods[0] = $methodName = Mage::getStoreConfig('carriers/shipment/name');
        foreach ($methods as $method) {
            $rate = Mage::getModel('shipping/rate_result_method');
            $rate->setCarrier($this->_code);
            $rate->setCarrierTitle('Pickup in store');
            $rate->setMethod($method);
            $rate->setMethodTitle($method);
            $rate->setPrice(0);
            $rate->setCost(0);
            $result->append($rate);
        }
        return $result;
    }
    public function getAllowedMethods()
    {
        return $this->getConfigData()['store'];
    }
}