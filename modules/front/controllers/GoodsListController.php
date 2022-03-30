<?php

namespace app\modules\front\controllers;

use app\common\models\GoodsList;

class GoodsListController extends \app\components\MyActiveController
{
    public $modelClass = GoodsList::class;
}
