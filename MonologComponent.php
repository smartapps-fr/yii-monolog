<?php

class MonologComponent extends CApplicationComponent
{
    public $environment;
	public $stream_handler_filepath;
    public $syslog_identity;
	public $use_json_formatter = TRUE;
    public $channel = 'application';

    public function init()
    {
        $logger = new Monolog\Logger($this->channel);

        if (!empty($this->stream_handler_filepath))
        {
            $file_stream = new Monolog\Handler\StreamHandler($this->stream_handler_filepath);
            if ($this->use_json_formatter)
            {
                $stream->setFormatter(new Monolog\Formatter\JsonFormatter());
            }
            $logger->pushHandler($stream);
        }
        
        if (!empty($this->syslog_identity))
        {
            $syslog = new Monolog\Handler\SyslogHandler($this->syslog_identity);
            if ($this->use_json_formatter)
            {
                $syslog->setFormatter(new Monolog\Formatter\JsonFormatter());
            }
            $logger->pushHandler($syslog);
        }
        
        Monolog\Registry::addLogger($logger, 'main');

        parent::init();
    }
}