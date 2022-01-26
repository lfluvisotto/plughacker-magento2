<?php
namespace PlugHacker\PlugPagamentos\Gateway\Transaction\Base\Command;

use Magento\Framework\App\ObjectManager;
use Magento\Payment\Gateway\CommandInterface;
use Magento\Payment\Gateway\Request\BuilderInterface as RequestBuilder;
use Magento\Payment\Gateway\Response\HandlerInterface as ResponseHandler;
use Magento\Payment\Gateway\Validator\ValidatorInterface;
use Magento\Payment\Gateway\Command\CommandException;
use Magento\Quote\Model\QuoteFactory;
use PlugHacker\PlugCore\Kernel\Abstractions\AbstractModuleCoreSetup as MPSetup;
use PlugHacker\PlugCore\Kernel\Interfaces\PlatformOrderInterface;
use PlugHacker\PlugCore\Kernel\Services\OrderService;
use PlugHacker\PlugPagamentos\Concrete\Magento2CoreSetup;
use PlugHacker\PlugPagamentos\Gateway\Transaction\Base\Config\ConfigInterface;

abstract class AbstractApiCommand implements CommandInterface
{
    protected $requestBuilder;
    protected $responseHandler;
    protected $validator;
    protected $config;

    public function __construct(
        RequestBuilder $requestBuilder,
        ResponseHandler $responseHandler,
        ConfigInterface $config,
        ValidatorInterface $validator = null
    )
    {
        $this->setRequestBuilder($requestBuilder);
        $this->setResponseHandler($responseHandler);
        $this->setConfig($config);
        $this->setValidator($validator);
    }

    abstract protected function sendRequest($request);

    /**
     * {@inheritdoc}
     */
    public function execute(array $commandSubject)
    {
        $request = $this->getRequestBuilder()->build($commandSubject);
        $response = $this->sendRequest($request);

        if ($this->getValidator()) {
            $result = $this->getValidator()->validate(
                array_merge($commandSubject, ['response' => $response])
            );

            if (! $result->isValid()) {
                $errorMessage = $result->getFailsDescription();
                throw new CommandException(
                    __(reset($errorMessage))
                );
            }
        }

        $this->getResponseHandler()->handle($commandSubject, ['response' => $response]);
        return $this;
    }

    /**
     * @return ResponseHandler
     */
    protected function getResponseHandler()
    {
        return $this->responseHandler;
    }

    /**
     * @param ResponseHandler $responseHandler
     * @return $this
     */
    protected function setResponseHandler(ResponseHandler $responseHandler)
    {
        $this->responseHandler = $responseHandler;
        return $this;
    }

    /**
     * @return RequestBuilder
     */
    protected function getRequestBuilder()
    {
        return $this->requestBuilder;
    }

    /**
     * @param RequestBuilder $requestBuilder
     * @return $this
     */
    protected function setRequestBuilder(RequestBuilder $requestBuilder)
    {
        $this->requestBuilder = $requestBuilder;
        return $this;
    }

    /**
     * @return ConfigInterface
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * @param ConfigInterface $config
     * @return AbstractApiCommand
     */
    protected function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
        return $this;
    }



    /**
     * @return ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param ValidatorInterface|null $validator
     * @return $this
     */
    protected function setValidator(ValidatorInterface $validator = null)
    {
        $this->validator = $validator;
        return $this;
    }
}
