<?php

namespace app\models;


/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string|null $fio
 *
 * @property Book[] $books
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio'], 'required'],
            [['fio'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id_author' => 'id']);
    }

    public function fields()
    {
        return [
            'id' => 'id',
            'fio' => 'fio'
        ];
    }

    public function extraFields()
    {
        return [
            'books' => 'books' // get from  getAuthor
        ];
    }

}
