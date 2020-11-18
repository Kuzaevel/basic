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

    protected function verbs()
    {
        return [
            'login' => ['post'],
        ];
    }

}
