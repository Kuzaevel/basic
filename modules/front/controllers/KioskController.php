<?php

namespace app\modules\front\controllers;

use Yii;
use app\components\MyActiveController;
use app\common\models\Kiosk;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;

class KioskController extends MyActiveController
{
    public $modelClass = Kiosk::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $filter = new ActiveDataFilter([
                                           'searchModel' => $this->modelClass
                                       ]);

        $filterCondition = null;

        // if ($filter->load(\Yii::$app->request->get())) {
        if ($filter->load(Yii::$app->request->getBodyParams())) {

            $filterCondition = $filter->build();
            if ($filterCondition === false) {
                // Serializer would get errors out of it
                return $filter;
            }
        }

        $query = Kiosk::find();
        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }

        return new ActiveDataProvider([
                                          'query' => $query,
                                      ]);
    }
}
