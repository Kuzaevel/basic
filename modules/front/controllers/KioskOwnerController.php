<?php

namespace app\modules\front\controllers;

use Yii;
use app\components\MyActiveController;
use app\common\models\KioskOwner;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;

class KioskOwnerController extends MyActiveController
{
    public $modelClass = KioskOwner::class;

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

        $query = KioskOwner::find();
        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }

        return new ActiveDataProvider([
                                          'query' => $query,
                                      ]);
    }
}
