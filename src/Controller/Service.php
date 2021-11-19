<?php

declare(strict_types=1);

namespace Northmule\Telegram\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\Model\JsonModel;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use Northmule\Telegram\Options\ModuleOptions;

use function rtrim;

class Service extends AbstractActionController
{


    /**
     * @var ServiceManager
     */
    protected ServiceManager $serviceManager;

    /**
     * Categorys constructor.
     *
     * @param ServiceManager $serviceManager
     */
    public function __construct(
        ServiceManager $serviceManager
    ) {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Запрос на установку хука для запросов от Телеграм
     *
     * @return JsonModel
     */
    public function setHookAction(): JsonModel
    {
        // todo убрать
        $route = '/telegram-bot/bot-echo';

        if ($this->isDisabledSet()) {
            $view = new JsonModel();
            $view->setVariables(
                ['response' => ['success' => true, 'result' => 'disable']]
            );
            $view->setTemplate('telegram/index/json');
            $headers = $this->getResponse()->getHeaders();
            $this->getResponse()->setHeaders(
                $headers->addHeaders(['Content-Type' => 'application/json'])
            );

            return $view;
        }

        /** @var ModuleOptions $options */
        $options = $this->serviceManager->get(ModuleOptions::class);
        $viewResult = '';
        try {
            $telegram = new Telegram(
                $options->getApiKey(),
                $options->getBotUsername()
            );
            $url = rtrim($options->getBootHookUrl(), '/') . $route;
            $result = $telegram->setWebhook($url);
            if ($result->isOk()) {
                $viewResult = $result->getDescription();
            }
        } catch (TelegramException $e) {
            $viewResult = $e->getMessage();
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

    /**
     * Отключен ли метод установки Хука
     *
     * @return bool
     */
    protected function isDisabledSet()
    {
        $config = $this->serviceManager->get('config');

        if (!array_key_exists('disableRouteSet', $config['telegramBot'])) {
            return true;
        }

        $isDisable = (bool) $config['telegramBot']['disableRouteSet'];
        return $isDisable;
    }
}
