<?php

namespace app\modules\front\controllers;

use Yii;
use app\components\MyActiveController;
use app\common\models\IceCreamRecipeHandbook;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;

class IceCreamRecipeHandbookController extends MyActiveController
{
    public $modelClass = IceCreamRecipeHandbook::class;
}
