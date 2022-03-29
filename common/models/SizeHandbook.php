<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "size_handbook".
 *
 * @property int $id
 * @property string $name
 * @property int|null $weight
 * @property int $equipment_id
 * @property string|null $description
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property CoffeeRecipe[] $coffeeRecipes
 * @property IceCreamGoodsSize[] $iceCreamGoodsSizes
 * @property GoodsList[] $goods
 * @property EquipmentHandbook $equipment
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 * @property SodaWaterGoodsSize[] $sodaWaterGoodsSizes
 * @property GoodsList[] $goods0
 */
class SizeHandbook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'size_handbook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'equipment_id', 'creator'], 'required'],
            [['id', 'weight', 'equipment_id'], 'default', 'value' => null],
            [['id', 'weight', 'equipment_id'], 'integer'],
            [['description', 'creator', 'editor'], 'string'],
            [['created_at', 'edited_at'], 'safe'],
            [['name'], 'string', 'max' => 70],
            [['id'], 'unique'],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentHandbook::className(), 'targetAttribute' => ['equipment_id' => 'id']],
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
            'weight' => 'Weight',
            'equipment_id' => 'Equipment ID',
            'description' => 'Description',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'editor' => 'Editor',
            'edited_at' => 'Edited At',
        ];
    }

    /**
     * Gets query for [[CoffeeRecipes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoffeeRecipes()
    {
        return $this->hasMany(CoffeeRecipe::className(), ['size_id' => 'id']);
    }

    /**
     * Gets query for [[IceCreamGoodsSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamGoodsSizes()
    {
        return $this->hasMany(IceCreamGoodsSize::className(), ['size_id' => 'id']);
    }

    /**
     * Gets query for [[Goods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(GoodsList::className(), ['id' => 'goods_id'])->viaTable('ice_cream_goods_size', ['size_id' => 'id']);
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment()
    {
        return $this->hasOne(EquipmentHandbook::className(), ['id' => 'equipment_id']);
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
     * Gets query for [[SodaWaterGoodsSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterGoodsSizes()
    {
        return $this->hasMany(SodaWaterGoodsSize::className(), ['size_id' => 'id']);
    }

    /**
     * Gets query for [[Goods0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoods0()
    {
        return $this->hasMany(GoodsList::className(), ['id' => 'goods_id'])->viaTable('soda_water_goods_size', ['size_id' => 'id']);
    }
}
