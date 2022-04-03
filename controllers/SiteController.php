<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\LoginForm;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return 'api';
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        //test
        //Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new LoginForm();
        $model->load(Yii::$app->request->bodyParams, '');
        if($token = $model->auth()) {
            return [
                'token' => $token->token,
                'expired' => date(DATE_RFC3339, $token->expired_at),
            ];
        } else {
            return $model;
        }

    }

    public function actionModels()
    {
        if(YII_DEBUG) {
            $path = '../models';
            $files = \yii\helpers\FileHelper::findFiles($path, ['only' => ['*.php'], 'recursive' => false]);

            if (isset($files[0])) {
                foreach ($files as $index => $file) {
                    $file = str_replace('.php', '', str_replace($path . DIRECTORY_SEPARATOR, '', $file));
                    $files[$index] = \yii\helpers\Html::a($file, \yii\helpers\Url::base() . 'back/default/' . $file);
                }
            }
            return $files;
        } else {
            return 'api';
        }
    }

    protected function verbs()
    {
        return [
            'login' => ['post'],
        ];
    }

}
