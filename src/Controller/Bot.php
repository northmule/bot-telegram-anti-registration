<?php

declare(strict_types=1);

namespace Northmule\Telegram\Controller;

use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\Model\JsonModel;
use Northmule\Telegram\Options\ModuleOptions;
use Northmule\Telegram\Service\TelegramApi;

class Bot extends AbstractActionController
{


    /**
     * @var ServiceManager
     */
    protected ServiceManager $serviceManager;
    /**
     * @var Logger
     */
    protected Logger $logger;
    /**
     * @var TelegramApi
     */
    protected TelegramApi $telegram;

    /**
     * Categorys constructor.
     *
     * @param ServiceManager $serviceManager
     * @param Logger         $logger
     * @param TelegramApi    $telegram
     */
    public function __construct(
        ServiceManager $serviceManager,
        Logger $logger,
        TelegramApi $telegram
    ) {
        $this->serviceManager = $serviceManager;
        $this->logger = $logger;
        $this->telegram = $telegram;
    }


    public function echoAction(): JsonModel
    {
        /** @var \Northmule\Telegram\Options\ModuleOptions $options */
        $options = $this->serviceManager->get(ModuleOptions::class);
        $this->logger->info(
            'Telegram данные: ' . $this->getRequest()->getContent()
        );
        $viewResult = 'ok';
        try {
            // Запуск Commands/....
            $this->telegram->handle();
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            $this->logger->addWriter(
                new Stream($options->getFileLog())
            );
            $this->logger->err(
                'Возникло исключение: ' . $e->getMessage(),
                [$e->getTrace()]
            );
            $viewResult = 'error';
        } finally {
            $view = new JsonModel();
            $view->setVariables(
                ['response' => ['success' => true, 'result' => $viewResult]]
            );
            $view->setTemplate('telegram/index/json');
            $headers = $this->getResponse()->getHeaders();
            $this->getResponse()->setHeaders(
                $headers->addHeaders(['Content-Type' => 'application/json'])
            );

            return $view;
        }
    }
}
