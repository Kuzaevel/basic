<?php

namespace app\modules\front\controllers;

use app\components\MyActiveController;
use app\common\models\KioskEquipment;

class KioskEquipmentController extends MyActiveController
{
    public $modelClass = KioskEquipment::class;
}
