<?php

namespace app\modules\front\controllers;

use app\components\MyActiveController;
use yii\rest\ActiveController;
use app\common\models\SizeHandbook;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;

use Yii;

class SizeHandbookController extends MyActiveController
{
    public $modelClass = SizeHandbook::class;

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

        $query = SizeHandbook::find();
        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}