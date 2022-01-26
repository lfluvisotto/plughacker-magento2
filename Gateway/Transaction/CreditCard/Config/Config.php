<?php
namespace PlugHacker\PlugPagamentos\Gateway\Transaction\CreditCard\Config;


use PlugHacker\PlugPagamentos\Gateway\Transaction\Base\Config\AbstractConfig;

class Config extends AbstractConfig implements ConfigInterface
{
    /**
     * {@inheritdoc}
     */
    public function getActive()
    {
        return (bool) $this->getConfig(static::PATH_ACTIVE);
    }

    /**
     * {@inheritdoc}
     */
    public function getEnabledSavedCards()
    {
        return (bool) $this->getConfig(static::PATH_ENABLED_SAVED_CARDS);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        $title = $this->getConfig(static::PATH_TITLE);

        if(empty($title)){
            return __('Plug Credit Card');
        }

        return $title;
    }

    /**
     * {@inheritdoc}
     */
    public function getPaymentAction()
    {
        return $this->getConfig(static::PATH_PAYMENT_ACTION);
    }

    /**
     * @return bool
     */
    public function getAntifraudActive()
    {
        return $this->getConfig(static::PATH_ANTIFRAUD_ACTIVE);
    }

    /**
     * @return string
     */
    public function getAntifraudMinAmount()
    {
        return $this->getConfig(static::PATH_ANTIFRAUD_MIN_AMOUNT);
    }

    /**
     * @return string
     */
    public function getSoftDescription()
    {
        return $this->getConfig(static::PATH_SOFT_DESCRIPTION);
    }

    /**
     * @return string
     */
    public function getCustomerStreetAttribute()
    {
        return $this->getConfig(static::PATH_CUSTOMER_STREET);
    }

    /**
     * @return string
     */
    public function getCustomerAddressNumber()
    {
        return $this->getConfig(static::PATH_CUSTOMER_NUMBER);
    }

    /**
     * @return string
     */
    public function getCustomerAddressComplement()
    {
        return $this->getConfig(static::PATH_CUSTOMER_COMPLEMENT);
    }

    /**
     * @return string
     */
    public function getCustomerAddressDistrict()
    {
        return $this->getConfig(static::PATH_CUSTOMER_DISTRICT);
    }
}
