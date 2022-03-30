<?php

namespace app\modules\front\controllers;

use Yii;
use app\components\MyActiveController;
use app\common\models\SizeHandbook;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;

class SizeHandbookController extends MyActiveController
{
    public $modelClass = SizeHandbook::class;
}