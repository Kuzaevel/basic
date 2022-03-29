<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "soda_water_recipe_link".
 *
 * @property string $id
 * @property string $goods_id
 * @property int $soda_water_recipe_id Recipe ID
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property GoodsList $goods
 * @property SodaWaterRecipeHandbook $sodaWaterRecipe
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 */
class SodaWaterRecipeLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'soda_water_recipe_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'goods_id', 'soda_water_recipe_id', 'creator'], 'required'],
            [['id', 'goods_id', 'creator', 'editor'], 'string'],
            [['soda_water_recipe_id'], 'default', 'value' => null],
            [['soda_water_recipe_id'], 'integer'],
            [['created_at', 'edited_at'], 'safe'],
            [['goods_id', 'soda_water_recipe_id'], 'unique', 'targetAttribute' => ['goods_id', 'soda_water_recipe_id']],
            [['id'], 'unique'],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsList::className(), 'targetAttribute' => ['goods_id' => 'id']],
            [['soda_water_recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => SodaWaterRecipeHandbook::className(), 'targetAttribute' => ['soda_water_recipe_id' => 'id']],
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
            'soda_water_recipe_id' => 'Soda Water Recipe ID',
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
     * Gets query for [[SodaWaterRecipe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterRecipe()
    {
        return $this->hasOne(SodaWaterRecipeHandbook::className(), ['id' => 'soda_water_recipe_id']);
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
