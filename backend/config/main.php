<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
		'alert' => [
            		'class' => 'backend\modules\alert\AlertModule',
        	],
		'task' => [
            		'class' => 'backend\modules\task\TaskModule',
        	],
	],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info'],
                    'categories' => ['api'],
                    'maxFileSize' => 1024 * 20,
                    'logFile' => '@runtime/../logs/user'.date('Ymd'),
                    'logVars' => ['_POST'],
                    'fileMode' => 0755,
                    'maxLogFiles' => 100,
                    'rotateByCopy' => false,
                    'prefix' => function(){
                        if(Yii::$app === null){
                            return '';
                        }
                        $request = Yii::$app->getRequest();
                        $ip = $request instanceof \yii\web\Request ? $request->getUserIP() : '-';
                        $controller = Yii::$app->controller->id;
                        $action = Yii::$app->controller->action->id;
                        return "[$ip][$controller-$action]";
                    },
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
