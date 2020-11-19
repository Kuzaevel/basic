<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property int $id_author
 * @property string $name
 * @property int|null $price
 * @property int $id_genre
 *
 * @property Author $author
 * @property Genre $genre
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
            [['id_author', 'price', 'id_genre'], 'integer'],
            [['id_author', 'price', 'id_genre','name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['id_author'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['id_author' => 'id']],
            [['id_genre'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::className(), 'targetAttribute' => ['id_genre' => 'id']],
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
            'price' => 'Price',
            'id_genre' => 'Id Genre',
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

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::className(), ['id' => 'id_genre']);
    }

    public function extraFields()
    {
        return [
            'author' => 'author',
            'genre' => 'genre'
        ];

    }

}
