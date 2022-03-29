<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "consumable_handbook".
 *
 * @property int $id
 * @property string $name
 * @property int $equipment_id
 * @property bool $can_change_residue
 * @property bool $can_change_critical
 * @property string|null $description
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property EquipmentHandbook $equipment
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 * @property KioskConsumable[] $kioskConsumables
 * @property KioskEquipment[] $kioskEquipments
 */
class ConsumableHandbook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consumable_handbook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'equipment_id', 'creator'], 'required'],
            [['id', 'equipment_id'], 'default', 'value' => null],
            [['id', 'equipment_id'], 'integer'],
            [['can_change_residue', 'can_change_critical'], 'boolean'],
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
            'equipment_id' => 'Equipment ID',
            'can_change_residue' => 'Can Change Residue',
            'can_change_critical' => 'Can Change Critical',
            'description' => 'Description',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'editor' => 'Editor',
            'edited_at' => 'Edited At',
        ];
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
     * Gets query for [[KioskConsumables]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskConsumables()
    {
        return $this->hasMany(KioskConsumable::className(), ['consumable_id' => 'id']);
    }

    /**
     * Gets query for [[KioskEquipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskEquipments()
    {
        return $this->hasMany(KioskEquipment::className(), ['id' => 'kiosk_equipment_id'])->viaTable('kiosk_consumable', ['consumable_id' => 'id']);
    }
}
