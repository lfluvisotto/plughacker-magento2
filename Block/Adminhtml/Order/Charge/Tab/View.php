<?php

namespace PlugHacker\PlugPagamentos\Block\Adminhtml\Order\Charge\Tab;

use PlugHacker\PlugPagamentos\Concrete\Magento2CoreSetup;

use PlugHacker\PlugCore\Kernel\Repositories\ChargeRepository;
use PlugHacker\PlugCore\Kernel\Repositories\OrderRepository;
use PlugHacker\PlugCore\Kernel\ValueObjects\Id\OrderId;

class View  extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $_template = 'tab/view/order_charge.phtml';

    /**
     * View constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        Magento2CoreSetup::bootstrap();

        $this->_coreRegistry = $registry;

        parent::__construct($context, $data);
    }

    /**
     * Retrieve order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }

    public function getCharges()
    {
        //@todo Create service to return the charges
        $platformOrderID = $this->getOrderIncrementId();
        $plugOrder = (new OrderRepository)->findByPlatformId($platformOrderID);

        if ($plugOrder === null) {
            return [];
        }

        $charges = (new ChargeRepository)->findByOrderId(
            new OrderId($plugOrder->getPlugId()->getValue())
        );

        return $charges;
    }

    /**
     * Retrieve order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrderId()
    {
        return $this->getOrder()->getEntityId();
    }

    /**
     * Retrieve order increment id
     *
     * @return string
     */
    public function getOrderIncrementId()
    {
        return $this->getOrder()->getIncrementId();
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Charges');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Charges');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    public function getChargeCancelUrl()
    {
        return $this->_urlBuilder->getUrl('plug/charges/cancel');
    }

    public function getChargeCaptureUrl()
    {
        return $this->_urlBuilder->getUrl('plug/charges/capture');
    }
}
