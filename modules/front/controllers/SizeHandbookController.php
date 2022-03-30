<?php

namespace app\modules\front\controllers;

use app\components\MyActiveController;
use app\common\models\SizeHandbook;
use yii\web\Response;

class SizeHandbookController extends MyActiveController
{
    public $modelClass = SizeHandbook::class;

    public function actionDo()
    {
        //$this->verbs();

        $result = ['results' => ['do' => 'this']];
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

}