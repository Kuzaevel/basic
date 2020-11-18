<?php


namespace app\controllers;

use common\models\Post;
use yii\rest\ActiveController;
use app\models\User;

class UserController extends ActiveController
{
    public $modelClass = User::class;

}
