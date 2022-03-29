<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "equipment_handbook".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property ConsumableHandbook[] $consumableHandbooks
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 * @property KioskEquipment[] $kioskEquipments
 * @property Kiosk[] $kiosks
 * @property SizeHandbook[] $sizeHandbooks
 */
class EquipmentHandbook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_handbook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'creator'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['description', 'creator', 'editor'], 'string'],
            [['created_at', 'edited_at'], 'safe'],
            [['name'], 'string', 'max' => 70],
            [['id'], 'unique'],
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
            'description' => 'Description',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'editor' => 'Editor',
            'edited_at' => 'Edited At',
        ];
    }

    /**
     * Gets query for [[ConsumableHandbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsumableHandbooks()
    {
        return $this->hasMany(ConsumableHandbook::className(), ['equipment_id' => 'id']);
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
     * Gets query for [[KioskEquipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskEquipments()
    {
        return $this->hasMany(KioskEquipment::className(), ['equipment_id' => 'id']);
    }

    /**
     * Gets query for [[Kiosks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKiosks()
    {
        return $this->hasMany(Kiosk::className(), ['id' => 'kiosk_id'])->viaTable('kiosk_equipment', ['equipment_id' => 'id']);
    }

    /**
     * Gets query for [[SizeHandbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSizeHandbooks()
    {
        return $this->hasMany(SizeHandbook::className(), ['equipment_id' => 'id']);
    }
}
