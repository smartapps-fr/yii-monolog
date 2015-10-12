<?php

class MonologComponent extends CApplicationComponent
{
    public $environment;
	public $handlers;

    public function init()
    {
        $logger = new Monolog\Logger('application');
        
        foreach ($this->handlers as $handler_config) {
            $handler = YiiBase::createComponent($handler_config);
            $logger->pushHandler($handler);            
        }
 
        Monolog\Registry::addLogger($logger);

        parent::init();
    }
}