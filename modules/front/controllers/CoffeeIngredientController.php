<?php

namespace app\modules\front\controllers;

use app\components\MyActiveController;
use app\common\models\CoffeeIngredient;

class CoffeeIngredientController extends MyActiveController
{
    public $modelClass = CoffeeIngredient::class;
}
