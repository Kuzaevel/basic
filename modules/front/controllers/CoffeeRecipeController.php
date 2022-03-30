<?php

namespace app\modules\front\controllers;

use app\common\models\CoffeeRecipe;

class CoffeeRecipeController extends \app\components\MyActiveController
{
    public $modelClass = CoffeeRecipe::class;
}
