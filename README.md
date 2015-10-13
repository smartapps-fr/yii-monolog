# yii-monolog

Monolog for Yii 1.*

Inspired by [baibaratsky/yii-rollbar](https://github.com/baibaratsky/yii-rollbar).

## Install

* Add the `Component` to the preload list

```php
'preload' => array(
	'monolog'
),
```

* Configure the `Component`

```php
'monolog' => array(
	'class' => 'application.vendor.smartapps-fr.yii-monolog.MonologComponent',
	'environment' => 'production',
	'syslog_identity' => 'SmartPublisher_Errors',
	//'stream_handler_filepath' => '/var/log/application.log',
	'use_json_formatter' => TRUE
),
```

* Add `LogRoute`

```php
'monolog' => array(
	'class' => 'application.vendor.smartapps-fr.yii-monolog.MonologLogRoute',
	'levels' => 'error, warning',
	'except' => array('exception.CHttpException.*')
),
```

* Add `Exception` handler

```php
'errorHandler' => array(
	'class' => 'application.vendor.smartapps-fr.yii-monolog.MonologErrorHandler',
),
```
