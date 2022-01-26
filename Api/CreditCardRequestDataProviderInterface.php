<?php
namespace PlugHacker\PlugPagamentos\Api;

interface CreditCardRequestDataProviderInterface extends BaseRequestDataProviderInterface
{

    /**
     * @return int
     */
    public function getInstallmentCount();

    /**
     * @return string
     */
    public function getCcTokenCreditCard();

    /**
     * @return string
     */
    public function getTokenCreditCardFirst();

    /**
     * @return string
     */
    public function getTokenCreditCardSecond();

    /**
     * @return int
     */
    public function getSaveCard();

    /**
     * @return string
     */
    public function getCreditCardOperation();

    /**
     * @return string
     */
    public function getCreditCardBrand();

    /**
     * @return string
     */
    public function getCreditCardNumber();

    /**
     * @return string
     */
    public function getExpMonth();

    /**
     * @return string
     */
    public function getExpYear();

    /**
     * @return string
     */
    public function getHolderName();

    /**
     * @return string
     */
    public function getSecurityCode();

    /**
     * @return string
     */
    public function getIsOneDollarAuthEnabled();

    /**
     * @return string
     */
    public function getCustomerAddressStreet($shipping);

    /**
     * @return string
     */
    public function getCustomerAddressNumber($shipping);

    /**
     * @return string
     */
    public function getCustomerAddressComplement($shipping);

    /**
     * @return string
     */
    public function getCustomerAddressDistrict($shipping);
}
