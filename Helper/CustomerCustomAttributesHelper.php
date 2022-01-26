<?php
/**
 * Created by PhpStorm.
 * User: fabio
 * Date: 01/05/18
 * Time: 15:49
 */

namespace PlugHacker\PlugPagamentos\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Customer;

class CustomerCustomAttributesHelper
{

    protected $customerRepository;

    protected $customerFactory;

    protected $storeManager;

    protected $customerModel;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerFactory $customerFactory,
        StoreManagerInterface $storeManager,
        Customer $customerModel
    )
    {
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
        $this->storeManager = $storeManager;
        $this->customerModel = $customerModel;
    }

    public function setCustomerCustomAttribute($magentoCustomer, $plugResponse, $customerIsGuest)
    {

        if(isset($plugResponse->customer) && !empty($plugResponse->customer && !$customerIsGuest)){

            $this->customerModel->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
            $customer = $this->customerModel->loadByEmail($magentoCustomer->getEmail());
            $customerDataModel = $customer->getDataModel();
            $customerDataModel->setCustomAttribute('customer_id_plug', $plugResponse->customer->id);

            try{
                $this->customerRepository->save($customerDataModel);
            }catch (\Exception $e) {
                throw new \InvalidArgumentException($e->getMessage());
            }

        }

        return $this;

    }

}
