<?php

namespace backend\modules\alert\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for the `alert` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        Yii::info("dddddd",'api');
        return $this->render('index');
    }
}
