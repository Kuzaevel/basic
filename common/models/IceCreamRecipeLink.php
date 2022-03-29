<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "ice_cream_recipe_link".
 *
 * @property string $id
 * @property string $goods_id
 * @property int $ice_cream_recipe_id Recipe ID
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property GoodsList $goods
 * @property IceCreamRecipeHandbook $iceCreamRecipe
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 */
class IceCreamRecipeLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ice_cream_recipe_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'goods_id', 'ice_cream_recipe_id', 'creator'], 'required'],
            [['id', 'goods_id', 'creator', 'editor'], 'string'],
            [['ice_cream_recipe_id'], 'default', 'value' => null],
            [['ice_cream_recipe_id'], 'integer'],
            [['created_at', 'edited_at'], 'safe'],
            [['goods_id', 'ice_cream_recipe_id'], 'unique', 'targetAttribute' => ['goods_id', 'ice_cream_recipe_id']],
            [['id'], 'unique'],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsList::className(), 'targetAttribute' => ['goods_id' => 'id']],
            [['ice_cream_recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => IceCreamRecipeHandbook::className(), 'targetAttribute' => ['ice_cream_recipe_id' => 'id']],
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
            'ice_cream_recipe_id' => 'Ice Cream Recipe ID',
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
     * Gets query for [[IceCreamRecipe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamRecipe()
    {
        return $this->hasOne(IceCreamRecipeHandbook::className(), ['id' => 'ice_cream_recipe_id']);
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
