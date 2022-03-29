<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "kiosk_equipment".
 *
 * @property string $id
 * @property string $kiosk_id
 * @property int $equipment_id
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property KioskConsumable[] $kioskConsumables
 * @property ConsumableHandbook[] $consumables
 * @property EquipmentHandbook $equipment
 * @property Kiosk $kiosk
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 */
class KioskEquipment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kiosk_equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kiosk_id', 'equipment_id', 'creator'], 'required'],
            [['id', 'kiosk_id', 'creator', 'editor'], 'string'],
            [['equipment_id'], 'default', 'value' => null],
            [['equipment_id'], 'integer'],
            [['created_at', 'edited_at'], 'safe'],
            [['kiosk_id', 'equipment_id'], 'unique', 'targetAttribute' => ['kiosk_id', 'equipment_id']],
            [['id'], 'unique'],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentHandbook::className(), 'targetAttribute' => ['equipment_id' => 'id']],
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
            'kiosk_id' => 'Kiosk ID',
            'equipment_id' => 'Equipment ID',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'editor' => 'Editor',
            'edited_at' => 'Edited At',
        ];
    }

    /**
     * Gets query for [[KioskConsumables]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskConsumables()
    {
        return $this->hasMany(KioskConsumable::className(), ['kiosk_equipment_id' => 'id']);
    }

    /**
     * Gets query for [[Consumables]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsumables()
    {
        return $this->hasMany(ConsumableHandbook::className(), ['id' => 'consumable_id'])->viaTable('kiosk_consumable', ['kiosk_equipment_id' => 'id']);
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
}
