<?php
namespace PlugHacker\PlugPagamentos\Model;

use Magento\Framework\Api\SimpleBuilderInterface;
use PlugHacker\PlugCore\Kernel\ValueObjects\CardBrand;
use PlugHacker\PlugPagamentos\Api\InstallmentsByBrandManagementInterface;
use Magento\Checkout\Model\Session;

use PlugHacker\PlugPagamentos\Model\Installments\Config\ConfigByBrand as Config;

class InstallmentsByBrandManagement
    extends AbstractInstallmentManagement
    implements InstallmentsByBrandManagementInterface
{
    protected $builder;
    protected $session;
    protected $cardBrand;

    /**
     * @param SimpleBuilderInterface $builder
     */
    public function __construct(
        SimpleBuilderInterface $builder,
        Session $session,
        Config $config
    )
    {
        $this->setBuilder($builder);
        $this->setSession($session);
        $this->setConfig($config);
        parent::__construct();
    }

    /**
     * @param mixed $brand
     * @return mixed
     */
    public function getInstallmentsByBrand($brand = null)
    {
        $baseBrand = 'nobrand';
        if (
            strlen($brand) > 0 &&
            $brand !== "null" &&
            method_exists(CardBrand::class, $brand)
        ) {
            $baseBrand = strtolower($brand);
        }

        return $this->getCoreInstallments(
            null,
            CardBrand::$baseBrand(),
            $this->builder->getSession()->getQuote()->getGrandTotal()
        );

        //@fixme deprecated code

        $cardBrand = $this->formatCardBrand($brand);
        $this->session->setCardBrand($cardBrand);
        $this->getBuilder()->create();

        $result = [];

        /** @var Installment $item */
        foreach ($this->getBuilder()->getData() as $item) {
            $result[] = [
                'id' => $item->getQty(),
                'interest' => $item->getInterest(),
                'label' => $item->getLabel()
            ];
        }

        return $result;
    }

    /**
     * @param $brand
     * @return string
     */
    protected function formatCardBrand($brand){

        $cardBrand = '_' . strtolower($brand);

        return $cardBrand;

    }

    /**
     * @param SimpleBuilderInterface $builder
     * @return $this
     */
    protected function setBuilder(SimpleBuilderInterface $builder)
    {
        $this->builder = $builder;
        return $this;
    }

    /**
     * @return SimpleBuilderInterface
     */
    protected function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     * @return $this
     */
    protected function setSession(Session $session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @return Config
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     * @return $this
     */
    protected function setConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

}
