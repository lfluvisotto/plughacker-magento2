<?php
namespace PlugHacker\PlugPagamentos\Gateway\Transaction\CreditCard\ResourceGateway\Capture\Response;


use Magento\Payment\Gateway\Response\HandlerInterface;
use PlugHacker\PlugPagamentos\Gateway\Transaction\Base\ResourceGateway\Response\AbstractHandler;
use PlugHacker\PlugPagamentos\Model\ChargesFactory;

class GeneralHandler extends AbstractHandler implements HandlerInterface
{
	/**
     * \PlugHacker\PlugPagamentos\Model\ChargesFactory
     */
	protected $modelCharges;

	/**
     * @return void
     */
    public function __construct(
    	ChargesFactory $modelCharges
    ) {
        $this->modelCharges = $modelCharges;
    }

    /**
     * {@inheritdoc}
     */
    protected function _handle($payment, $response)
    {
        $model = $this->modelCharges->create();
        $charge = $model->getCollection()->addFieldToFilter('charge_id',array('eq' => $response->id))->getFirstItem();
        try {
            $charge->setStatus($response->status);
            $charge->setPaidAmount($response->amount);
            $charge->setUpdatedAt(date("Y-m-d H:i:s"));
            $charge->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $this;
    }
}
