<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "goods_list".
 *
 * @property string $id
 * @property string $name
 * @property string $catalog_id
 * @property string|null $composition
 * @property float|null $calories
 * @property float|null $protein
 * @property float|null $fat
 * @property float|null $carb
 * @property string|null $picture
 * @property bool $is_active
 * @property string|null $description
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property CoffeeRecipe[] $coffeeRecipes
 * @property GoodsCatalog $catalog
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 * @property IceCreamGoodsSize[] $iceCreamGoodsSizes
 * @property SizeHandbook[] $sizes
 * @property IceCreamRecipeLink[] $iceCreamRecipeLinks
 * @property IceCreamRecipeHandbook[] $iceCreamRecipes
 * @property SodaWaterGoodsSize[] $sodaWaterGoodsSizes
 * @property SizeHandbook[] $sizes0
 * @property SodaWaterRecipeLink[] $sodaWaterRecipeLinks
 * @property SodaWaterRecipeHandbook[] $sodaWaterRecipes
 */
class GoodsList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'catalog_id', 'creator'], 'required'],
            [['id', 'catalog_id', 'composition', 'picture', 'description', 'creator', 'editor'], 'string'],
            [['calories', 'protein', 'fat', 'carb'], 'number'],
            [['is_active'], 'boolean'],
            [['created_at', 'edited_at'], 'safe'],
            [['name'], 'string', 'max' => 70],
            [['name'], 'unique'],
            [['id'], 'unique'],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsCatalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
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
            'catalog_id' => 'Catalog ID',
            'composition' => 'Composition',
            'calories' => 'Calories',
            'protein' => 'Protein',
            'fat' => 'Fat',
            'carb' => 'Carb',
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
     * Gets query for [[CoffeeRecipes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoffeeRecipes()
    {
        return $this->hasMany(CoffeeRecipe::className(), ['goods_id' => 'id']);
    }

    /**
     * Gets query for [[Catalog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(GoodsCatalog::className(), ['id' => 'catalog_id']);
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
     * Gets query for [[IceCreamGoodsSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamGoodsSizes()
    {
        return $this->hasMany(IceCreamGoodsSize::className(), ['goods_id' => 'id']);
    }

    /**
     * Gets query for [[Sizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSizes()
    {
        return $this->hasMany(SizeHandbook::className(), ['id' => 'size_id'])->viaTable('ice_cream_goods_size', ['goods_id' => 'id']);
    }

    /**
     * Gets query for [[IceCreamRecipeLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamRecipeLinks()
    {
        return $this->hasMany(IceCreamRecipeLink::className(), ['goods_id' => 'id']);
    }

    /**
     * Gets query for [[IceCreamRecipes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamRecipes()
    {
        return $this->hasMany(IceCreamRecipeHandbook::className(), ['id' => 'ice_cream_recipe_id'])->viaTable('ice_cream_recipe_link', ['goods_id' => 'id']);
    }

    /**
     * Gets query for [[SodaWaterGoodsSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterGoodsSizes()
    {
        return $this->hasMany(SodaWaterGoodsSize::className(), ['goods_id' => 'id']);
    }

    /**
     * Gets query for [[Sizes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSizes0()
    {
        return $this->hasMany(SizeHandbook::className(), ['id' => 'size_id'])->viaTable('soda_water_goods_size', ['goods_id' => 'id']);
    }

    /**
     * Gets query for [[SodaWaterRecipeLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterRecipeLinks()
    {
        return $this->hasMany(SodaWaterRecipeLink::className(), ['goods_id' => 'id']);
    }

    /**
     * Gets query for [[SodaWaterRecipes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterRecipes()
    {
        return $this->hasMany(SodaWaterRecipeHandbook::className(), ['id' => 'soda_water_recipe_id'])->viaTable('soda_water_recipe_link', ['goods_id' => 'id']);
    }
}
