<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "coffee_recipe".
 *
 * @property string $id
 * @property string $coffee_machine_recipe_id Recipe ID from coffee machine configuration
 * @property string $name
 * @property string|null $goods_id
 * @property int $size_id
 * @property int|null $prise
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property CoffeeIngredient[] $coffeeIngredients
 * @property GoodsList $goods
 * @property SizeHandbook $size
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 */
class CoffeeRecipe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coffee_recipe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'coffee_machine_recipe_id', 'name', 'size_id', 'creator'], 'required'],
            [['id', 'coffee_machine_recipe_id', 'goods_id', 'creator', 'editor'], 'string'],
            [['size_id', 'prise'], 'default', 'value' => null],
            [['size_id', 'prise'], 'integer'],
            [['created_at', 'edited_at'], 'safe'],
            [['name'], 'string', 'max' => 70],
            [['coffee_machine_recipe_id'], 'unique'],
            [['name'], 'unique'],
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
            'coffee_machine_recipe_id' => 'Coffee Machine Recipe ID',
            'name' => 'Name',
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
     * Gets query for [[CoffeeIngredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoffeeIngredients()
    {
        return $this->hasMany(CoffeeIngredient::className(), ['recipe_id' => 'id']);
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
