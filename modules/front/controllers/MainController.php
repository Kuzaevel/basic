<?php

namespace app\modules\front\controllers;

use Yii;
use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->session->addFlash('myToast', 'Test message');
        $message = Yii::$app->controller->id;
        return $this->render('index', ['message' => $message]);
    }
}
