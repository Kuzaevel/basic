<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "kiosk_owner".
 *
 * @property string $id
 * @property string $kiosk_id
 * @property string $owner_id
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property Kiosk $kiosk
 * @property UserAccount $owner
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 * @property KioskPermission[] $kioskPermissions
 * @property PermissionHandbook[] $permissions
 */
class KioskOwner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kiosk_owner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kiosk_id', 'owner_id', 'creator'], 'required'],
            [['id', 'kiosk_id', 'owner_id', 'creator', 'editor'], 'string'],
            [['created_at', 'edited_at'], 'safe'],
            [['id'], 'unique'],
            [['kiosk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kiosk::className(), 'targetAttribute' => ['kiosk_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['owner_id' => 'id']],
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
            'owner_id' => 'Owner ID',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'editor' => 'Editor',
            'edited_at' => 'Edited At',
        ];
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
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'owner_id']);
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
     * Gets query for [[KioskPermissions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskPermissions()
    {
        return $this->hasMany(KioskPermission::className(), ['kiosk_owner_id' => 'id']);
    }

    /**
     * Gets query for [[Permissions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPermissions()
    {
        return $this->hasMany(PermissionHandbook::className(), ['id' => 'permission_id'])->viaTable('kiosk_permission', ['kiosk_owner_id' => 'id']);
    }
}
