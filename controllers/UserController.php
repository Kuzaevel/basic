<?php


namespace app\controllers;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use app\models\User;

use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;


class UserController extends ActiveController
{
    public $modelClass = User::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['only'] = ['index', 'view', 'update', 'delete'];
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new User;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->setPassword($model->password);
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

    public function actionUpdate($id) {
        $model = User::findIdentity($id);
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->setPassword($model->password);
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
        return $model;
    }

}
