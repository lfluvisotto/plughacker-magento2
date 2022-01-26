<?php

namespace PlugHacker\PlugPagamentos\Api;

interface CustomerCreateManagementInterface
{
    /**
     * @param mixed $customer
     * @param mixed $website_id
     * @return mixed
     */
    public function createCustomer($customer, $website_id);

}
