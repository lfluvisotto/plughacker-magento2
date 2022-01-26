<?php
namespace PlugHacker\PlugPagamentos\Gateway\Transaction\Billet\ResourceGateway\Create;

use Magento\Checkout\Model\Session;
use Magento\Payment\Gateway\Data\OrderAdapterInterface;
use Magento\Payment\Model\InfoInterface;
use PlugHacker\PlugPagamentos\Api\BilletRequestDataProviderInterface;
use PlugHacker\PlugPagamentos\Gateway\Transaction\Base\ResourceGateway\AbstractRequestDataProvider;
use PlugHacker\PlugPagamentos\Gateway\Transaction\Billet\Config\ConfigInterface;
use PlugHacker\PlugPagamentos\Helper\CustomerAddressInterface;

class RequestDataProvider extends AbstractRequestDataProvider implements BilletRequestDataProviderInterface
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @param OrderAdapterInterface $orderAdapter
     * @param InfoInterface $payment
     * @param Session $session
     * @param CustomerAddressInterface $customerAddressHelper
     * @param ConfigInterface $config
     */
    public function __construct (
        OrderAdapterInterface $orderAdapter,
        InfoInterface $payment,
        Session $session,
        CustomerAddressInterface $customerAddressHelper,
        ConfigInterface $config
    )
    {
        parent::__construct($orderAdapter, $payment, $session, $customerAddressHelper);
        $this->setConfig($config);
    }

    /**
     * {@inheritdoc}
     */
    public function getInstructions()
    {
        return $this->getConfig()->getInstructions();
    }

    /**
     * {@inheritdoc}
     */
    public function getDaysToAddInBoletoExpirationDate()
    {
        return $this->getConfig()->getExpirationDays();
    }

    /**
     * @return ConfigInterface
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * @param ConfigInterface $config
     * @return $this
     */
    protected function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerAddressStreet($shipping)
    {
        if ($shipping) {
            return $this->getShippingAddressAttribute($this->getConfig()->getCustomerStreetAttribute());
        }

        return $this->getBillingAddressAttribute($this->getConfig()->getCustomerStreetAttribute());
    }

    /**
     * @return string
     */
    public function getCustomerAddressNumber($shipping)
    {
        if ($shipping) {
            return $this->getShippingAddressAttribute($this->getConfig()->getCustomerAddressNumber());
        }

        return $this->getBillingAddressAttribute($this->getConfig()->getCustomerAddressNumber());
    }

    /**
     * @return string
     */
    public function getCustomerAddressComplement($shipping)
    {
        if ($shipping) {
            $response = !$this->getShippingAddressAttribute($this->getConfig()->getCustomerAddressDistrict()) ? '' : $this->getShippingAddressAttribute($this->getConfig()->getCustomerAddressComplement());
        }else{
            $response = !$this->getBillingAddressAttribute($this->getConfig()->getCustomerAddressDistrict()) ? '' : $this->getShippingAddressAttribute($this->getConfig()->getCustomerAddressComplement());
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getCustomerAddressDistrict($shipping)
    {
        if ($shipping) {
            $streetLine = !$this->getShippingAddressAttribute($this->getConfig()->getCustomerAddressDistrict()) ? 'street_3' : $this->getConfig()->getCustomerAddressDistrict();
            $response = $this->getShippingAddressAttribute($streetLine);
        }else{
            $streetLine = !$this->getBillingAddressAttribute($this->getConfig()->getCustomerAddressDistrict()) ? 'street_3' : $this->getConfig()->getCustomerAddressDistrict();
            $response = $this->getBillingAddressAttribute($streetLine);
        }

        return $response;
    }

}
