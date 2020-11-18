<?php
namespace app\controllers;

use app\controllers\BaseApiController;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use app\models\Author;

class AuthorController extends ActiveController
{

    public $modelClass = Author::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'index' => ['get'],
        ];
    }
}