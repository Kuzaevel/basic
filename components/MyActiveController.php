<?php
namespace app\components;

use Yii;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\ActiveController;

class MyActiveController extends ActiveController
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
                QueryParamAuth::class,
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['delete']);
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

        $query = $this->modelClass::find();
        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}