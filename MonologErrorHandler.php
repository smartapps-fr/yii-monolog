<?php

class MonologErrorHandler extends CErrorHandler
{
    public $monologComponentName = 'monolog';
    
    protected function handleException($e)
    {
        // skip 404
        if (!($e instanceof CHttpException && $e->statusCode == 404)) {
            Monolog\Registry::main()->addError(
                sprintf('Uncaught Exception %s: "%s" at %s line %s', get_class($e), $e->getMessage(), $e->getFile(), $e->getLine()),
                array('exception' => $e)
            );
        }

        parent::handleException($e);
    }


    protected function handleError($e)
    {
        Monolog\Registry::main()->addError(
            self::codeToString($e->code).': '.$e->message,
            array('code' => $e->code, 'message' => $e->message, 'file' => $e->file, 'line' => $e->line, 'params' => $e->params, 'environment' => Yii::app()->getComponent($this->monologComponentName)->environment)
        );

        parent::handleError($e);
    }
    
    private static function codeToString($code)
    {
        switch ($code) {
            case E_ERROR:
                return 'E_ERROR';
            case E_WARNING:
                return 'E_WARNING';
            case E_PARSE:
                return 'E_PARSE';
            case E_NOTICE:
                return 'E_NOTICE';
            case E_CORE_ERROR:
                return 'E_CORE_ERROR';
            case E_CORE_WARNING:
                return 'E_CORE_WARNING';
            case E_COMPILE_ERROR:
                return 'E_COMPILE_ERROR';
            case E_COMPILE_WARNING:
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR:
                return 'E_USER_ERROR';
            case E_USER_WARNING:
                return 'E_USER_WARNING';
            case E_USER_NOTICE:
                return 'E_USER_NOTICE';
            case E_STRICT:
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR:
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED:
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED:
                return 'E_USER_DEPRECATED';
        }
        return 'Unknown PHP error';
    }
}