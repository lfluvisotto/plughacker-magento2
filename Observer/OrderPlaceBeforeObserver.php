<?php

namespace PlugHacker\PlugPagamentos\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Event\ObserverInterface;
use PlugHacker\PlugCore\Kernel\Interfaces\PlatformOrderInterface;
use PlugHacker\PlugCore\Payment\Services\ValidationService;
use PlugHacker\PlugPagamentos\Concrete\Magento2CoreSetup;


class OrderPlaceBeforeObserver implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        Magento2CoreSetup::bootstrap();

        $order = $observer->getOrder();
        $payment = $order->getPayment();

        if (strpos($payment->getMethod(), 'plug') === false) {
            return;
        }

        $platformOrderDecoratorClass = Magento2CoreSetup::get(
            Magento2CoreSetup::CONCRETE_PLATFORM_ORDER_DECORATOR_CLASS
        );

        /** @var PlatformOrderInterface $orderDecorator */
        $orderDecorator = new $platformOrderDecoratorClass();
        $orderDecorator->setPlatformOrder($order);

        return $this->validate($orderDecorator);
    }

    protected function validate(PlatformOrderInterface $order)
    {
        $validationService = new ValidationService();
        $validationService->validatePayment($order);

        foreach ($validationService->getErrors() as $error) {
            throw new InputException(__($error));
        }

        return true;
    }
}
