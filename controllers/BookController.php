<?php


namespace app\controllers;

use app\controllers\BaseApiController;

use yii\rest\ActiveController;
use app\models\Book;

use Yii;

class BookController extends ActiveController
{
    public $modelClass = Book::class;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];


    public function prepareDataProvider()
    {
        $searchModel = new BookSearch();
        return $searchModel->search(Yii::$app->request->queryParams);
    }
}