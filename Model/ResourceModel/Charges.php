<?php
namespace PlugHacker\PlugPagamentos\Model\ResourceModel;

class Charges extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('plug_module_core_charge', 'id');
    }
}
