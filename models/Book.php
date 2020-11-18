<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property int|null $id_author
 * @property string|null $name
 * @property int|null $year
 * @property float|null $price
 *
 * @property Author $author
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_author', 'year'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['id_author'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['id_author' => 'id']],
            [['id_author', 'year', 'name', 'price'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_author' => 'Id Author',
            'name' => 'Name',
            'year' => 'Year',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'id_author']);
    }

    public function extraFields()
    {
        return [
            'author' => 'author'
        ];

    }
}
