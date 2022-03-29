<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "goods_catalog".
 *
 * @property string $id
 * @property string $name
 * @property string $kiosk_id
 * @property string|null $picture
 * @property bool $is_active
 * @property string|null $description
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property Kiosk $kiosk
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 * @property GoodsList[] $goodsLists
 */
class GoodsCatalog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_catalog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'kiosk_id', 'creator'], 'required'],
            [['id', 'kiosk_id', 'picture', 'description', 'creator', 'editor'], 'string'],
            [['is_active'], 'boolean'],
            [['created_at', 'edited_at'], 'safe'],
            [['name'], 'string', 'max' => 70],
            [['name'], 'unique'],
            [['id'], 'unique'],
            [['kiosk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kiosk::className(), 'targetAttribute' => ['kiosk_id' => 'id']],
            [['creator'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['creator' => 'id']],
            [['editor'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['editor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'kiosk_id' => 'Kiosk ID',
            'picture' => 'Picture',
            'is_active' => 'Is Active',
            'description' => 'Description',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'editor' => 'Editor',
            'edited_at' => 'Edited At',
        ];
    }

    /**
     * Gets query for [[Kiosk]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKiosk()
    {
        return $this->hasOne(Kiosk::className(), ['id' => 'kiosk_id']);
    }

    /**
     * Gets query for [[Creator0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreator0()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'creator']);
    }

    /**
     * Gets query for [[Editor0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEditor0()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'editor']);
    }

    /**
     * Gets query for [[GoodsLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsLists()
    {
        return $this->hasMany(GoodsList::className(), ['catalog_id' => 'id']);
    }
}
