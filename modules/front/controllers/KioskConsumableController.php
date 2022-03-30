<?php

namespace app\modules\front\controllers;

use app\components\MyActiveController;
use app\common\models\KioskConsumable;

class KioskConsumableController extends MyActiveController
{
    public $modelClass = KioskConsumable::class;
}
