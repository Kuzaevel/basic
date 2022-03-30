<?php

namespace app\modules\front\controllers;

use app\components\MyActiveController;
use app\common\models\Kiosk;

class KioskController extends MyActiveController
{
    public $modelClass = Kiosk::class;
}
