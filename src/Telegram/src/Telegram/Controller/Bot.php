<?php

declare(strict_types=1);

namespace Coderun\Telegram\Controller;


use Coderun\Telegram\Service\TelegramApi;
use Laminas\Json\Json;
use Laminas\Log\Logger;
use Laminas\Mvc\Controller\AbstractController;
use Laminas\Mvc\MvcEvent;
use Laminas\ServiceManager\ServiceManager;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Laminas\View\View;
use Coderun\Telegram\Options\ModuleOptions;


class Bot extends AbstractActionController
{
    
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    /**
     * @var ServiceManager
     */
    protected $serviceManager;
    
    /**
     * @var Logger
     */
    protected $logger;
    
    /**
     * @var TelegramApi
     */
    protected $telegram;
    
    
    /**
     * Categorys constructor.
     *
     * @param EntityManager                $entityManager
     * @param ServiceManager               $serviceManager
     */
    public function __construct(
        EntityManager $entityManager,
        ServiceManager $serviceManager,
        Logger $logger,
        TelegramApi $telegram
    )
    {
        $this->entityManager = $entityManager;
        $this->serviceManager = $serviceManager;
        $this->logger = $logger;
        $this->telegram = $telegram;
        
    }


public function echoAction()
{
    
    $options = $this->serviceManager->get(ModuleOptions::class);
    $this->logger->info('Telegram данные: '.$this->getRequest()->getContent());
    $viewResult = 'ok';
    try {
        // Запуск Commands/....
       $this->telegram->handle();
    } catch (Longman\TelegramBot\Exception\TelegramException $e) {
        $this->logger->addWriter(new \Laminas\Log\Writer\Stream($options->getFileLog()));
        $this->logger->err('Возникло исключение: '.$e->getMessage(),[$e->getTrace()]);
        $viewResult =  'error';
    } finally {
        $view = new JsonModel();
        $view->setVariables(['response' =>['success' => true,'result' => $viewResult]]);
        $view->setTemplate('telegram/index/json');
        $headers = $this->getResponse()->getHeaders();
        $this->getResponse()->setHeaders($headers->addHeaders(['Content-Type'=>'application/json']));
        
        return $view;
    }
    
}
    
    
    
}