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
        $params = array();
        //Yii::$app->runAction('alert/default/index',$params);
//        $this->redirect(array('alert/default/index','id'=>1));
        Yii::info("test",'api');
        return;
    }


    public function call(){

    }
}
