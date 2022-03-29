<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "ice_cream_goods_size".
 *
 * @property string $id
 * @property string $goods_id Product ID
 * @property int $size_id
 * @property int|null $prise
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property GoodsList $goods
 * @property SizeHandbook $size
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 */
class IceCreamGoodsSize extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ice_cream_goods_size';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'goods_id', 'size_id', 'creator'], 'required'],
            [['id', 'goods_id', 'creator', 'editor'], 'string'],
            [['size_id', 'prise'], 'default', 'value' => null],
            [['size_id', 'prise'], 'integer'],
            [['created_at', 'edited_at'], 'safe'],
            [['goods_id', 'size_id'], 'unique', 'targetAttribute' => ['goods_id', 'size_id']],
            [['id'], 'unique'],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsList::className(), 'targetAttribute' => ['goods_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => SizeHandbook::className(), 'targetAttribute' => ['size_id' => 'id']],
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
            'goods_id' => 'Goods ID',
            'size_id' => 'Size ID',
            'prise' => 'Prise',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'editor' => 'Editor',
            'edited_at' => 'Edited At',
        ];
    }

    /**
     * Gets query for [[Goods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(GoodsList::className(), ['id' => 'goods_id']);
    }

    /**
     * Gets query for [[Size]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(SizeHandbook::className(), ['id' => 'size_id']);
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
}
