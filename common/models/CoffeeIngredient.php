<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "coffee_ingredient".
 *
 * @property string $id
 * @property string $recipe_id Recipe ID
 * @property string $kiosk_consumable_id
 * @property int|null $quantity The amount of the ingredient in the coffee recipe
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property CoffeeRecipe $recipe
 * @property KioskConsumable $kioskConsumable
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 */
class CoffeeIngredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coffee_ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'recipe_id', 'kiosk_consumable_id', 'creator'], 'required'],
            [['id', 'recipe_id', 'kiosk_consumable_id', 'creator', 'editor'], 'string'],
            [['quantity'], 'default', 'value' => null],
            [['quantity'], 'integer'],
            [['created_at', 'edited_at'], 'safe'],
            [['id', 'kiosk_consumable_id'], 'unique', 'targetAttribute' => ['id', 'kiosk_consumable_id']],
            [['id'], 'unique'],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoffeeRecipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
            [['kiosk_consumable_id'], 'exist', 'skipOnError' => true, 'targetClass' => KioskConsumable::className(), 'targetAttribute' => ['kiosk_consumable_id' => 'id']],
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
            'recipe_id' => 'Recipe ID',
            'kiosk_consumable_id' => 'Kiosk Consumable ID',
            'quantity' => 'Quantity',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'editor' => 'Editor',
            'edited_at' => 'Edited At',
        ];
    }

    /**
     * Gets query for [[Recipe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(CoffeeRecipe::className(), ['id' => 'recipe_id']);
    }

    /**
     * Gets query for [[KioskConsumable]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskConsumable()
    {
        return $this->hasOne(KioskConsumable::className(), ['id' => 'kiosk_consumable_id']);
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
