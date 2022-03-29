<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "kiosk_consumable".
 *
 * @property string $id
 * @property string $name Name for the Recipes section of the Consumable naming subsection
 * @property string $kiosk_equipment_id
 * @property int $consumable_id
 * @property int|null $group_id Group ID for the Recipes section of the Consumable grouping subsection
 * @property float|null $residue_quantity The value of Residual quantity of consumables in the Consumables section of the Goods accounting subsection
 * @property float|null $critical_quantity The value of Critical quantity of consumable for the Consumables section of the Goods accounting subsection
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property CoffeeIngredient[] $coffeeIngredients
 * @property ConsumableGroupHandbook $group
 * @property ConsumableHandbook $consumable
 * @property KioskEquipment $kioskEquipment
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 */
class KioskConsumable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kiosk_consumable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'kiosk_equipment_id', 'consumable_id', 'creator'], 'required'],
            [['id', 'kiosk_equipment_id', 'creator', 'editor'], 'string'],
            [['consumable_id', 'group_id'], 'default', 'value' => null],
            [['consumable_id', 'group_id'], 'integer'],
            [['residue_quantity', 'critical_quantity'], 'number'],
            [['created_at', 'edited_at'], 'safe'],
            [['name'], 'string', 'max' => 70],
            [['kiosk_equipment_id', 'consumable_id'], 'unique', 'targetAttribute' => ['kiosk_equipment_id', 'consumable_id']],
            [['name'], 'unique'],
            [['id'], 'unique'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConsumableGroupHandbook::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['consumable_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConsumableHandbook::className(), 'targetAttribute' => ['consumable_id' => 'id']],
            [['kiosk_equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => KioskEquipment::className(), 'targetAttribute' => ['kiosk_equipment_id' => 'id']],
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
            'kiosk_equipment_id' => 'Kiosk Equipment ID',
            'consumable_id' => 'Consumable ID',
            'group_id' => 'Group ID',
            'residue_quantity' => 'Residue Quantity',
            'critical_quantity' => 'Critical Quantity',
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
        return $this->hasMany(CoffeeIngredient::className(), ['kiosk_consumable_id' => 'id']);
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(ConsumableGroupHandbook::className(), ['id' => 'group_id']);
    }

    /**
     * Gets query for [[Consumable]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsumable()
    {
        return $this->hasOne(ConsumableHandbook::className(), ['id' => 'consumable_id']);
    }

    /**
     * Gets query for [[KioskEquipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskEquipment()
    {
        return $this->hasOne(KioskEquipment::className(), ['id' => 'kiosk_equipment_id']);
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
