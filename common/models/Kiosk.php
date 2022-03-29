<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "kiosk".
 *
 * @property string $id
 * @property string $name
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property GoodsCatalog[] $goodsCatalogs
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 * @property KioskEquipment[] $kioskEquipments
 * @property EquipmentHandbook[] $equipment
 * @property KioskOwner[] $kioskOwners
 */
class Kiosk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kiosk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'creator'], 'required'],
            [['id', 'creator', 'editor'], 'string'],
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
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'editor' => 'Editor',
            'edited_at' => 'Edited At',
        ];
    }

    /**
     * Gets query for [[GoodsCatalogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsCatalogs()
    {
        return $this->hasMany(GoodsCatalog::className(), ['kiosk_id' => 'id']);
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
        return $this->hasMany(KioskEquipment::className(), ['kiosk_id' => 'id']);
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment()
    {
        return $this->hasMany(EquipmentHandbook::className(), ['id' => 'equipment_id'])->viaTable('kiosk_equipment', ['kiosk_id' => 'id']);
    }

    /**
     * Gets query for [[KioskOwners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskOwners()
    {
        return $this->hasMany(KioskOwner::className(), ['kiosk_id' => 'id']);
    }
}
