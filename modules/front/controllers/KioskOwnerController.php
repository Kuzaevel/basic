<?php

namespace app\modules\front\controllers;

use app\components\MyActiveController;
use app\common\models\KioskOwner;

class KioskOwnerController extends MyActiveController
{
    public $modelClass = KioskOwner::class;
}
