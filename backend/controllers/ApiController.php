<?php
namespace backend\controllers;


use backend\modules\alert\controllers\DefaultController;
use Yii;
use yii\web\Controller;


/**
 * 所有客户端请求的入口文件
 * Class ApiController
 * @package backend\controllers
 */
class ApiController extends Controller{

    public function actionIndex(){
//        return $this->runController();
        //$request = file_get_contents("input://");
        //$requestArr = json_encode($request,true);
//        return (new DefaultController('alert',Yii::$app->modules))->runAction('index');
        $params = array();
        Yii::$app->runAction('alert/default/index',$params);
    }


    public function call(){

    }
}
