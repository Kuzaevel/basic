<?php
namespace app\controllers;

use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use app\models\Author;

use Yii;

class AuthorController extends ActiveController
{

    public $modelClass = Author::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $filter = new ActiveDataFilter( [
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

        $query = Author::find();
        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    protected function verbs()
    {
        return [
            'index' => ['get'],
        ];
    }
}