<?php

namespace PlugHacker\PlugPagamentos\Model\Ui\Pix;

use Magento\Checkout\Model\ConfigProviderInterface;
use PlugHacker\PlugCore\Kernel\ValueObjects\Configuration\PixConfig;
use PlugHacker\PlugPagamentos\Concrete\Magento2CoreSetup as MPSetup;

final class ConfigProvider implements ConfigProviderInterface
{
    const CODE = 'plug_pix';

    /**
     * @var PixConfig
     */
    private $pixConfig;

    public function __construct()
    {
        MPSetup::bootstrap();
        $moduleConfig = MPSetup::getModuleConfiguration();
        if (!empty($moduleConfig->getPixConfig())) {
            $this->pixConfig = $moduleConfig->getPixConfig();
        }
    }

    public function getConfig()
    {
        return [
            'payment' => [
                self::CODE => [
                    'active' => $this->pixConfig->isEnabled(),
                    'title' => $this->pixConfig->getTitle(),
                ]
            ]
        ];
    }
}
