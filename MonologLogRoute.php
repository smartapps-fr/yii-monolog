<?php

class MonologLogRoute extends CLogRoute
{
    public $monologComponentName = 'monolog';
    
    public function init()
    {
        if (Yii::app()->getComponent($this->$monologComponentName) === null) {
            throw new CException('Monolog component is not loaded.');
        }
        if (!class_exists('Monolog\Registry', false)) {
            throw new CException('Monolog classes are not loaded.');
        }
    }

    protected function processLogs($logs)
    {
        foreach ($logs as $log) {
            // Exclude records by the exceptions handler. MonologErrorHandler takes care of them.
            if (strncmp($log[2], 'exception', 9) !== 0) {
                Monolog\Registry::application()->log(
                    self::levelToString($log[1]),
                    $log[0],
                    array('message' => $log[0], 'level' => $log[1], 'category' => $log[2], 'timestamp' => $log[3]*1000/*msec*/, 'environment' => Yii::app()->getComponent($this->$monologComponentName)->environment)
                );
            }
        }
    }

    private static function levelToString($level)
    {
        switch ($level) {
            default:
            case CLogger::LEVEL_PROFILE:
            case CLogger::LEVEL_TRACE:
                return 'DEBUG';
            case CLogger::LEVEL_WARNING:
                return 'WARNING';
            case CLogger::LEVEL_ERROR:
                return 'ERROR';
            case CLogger::LEVEL_INFO:
                return 'INFO';
        }
    }
}