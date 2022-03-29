<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "ice_cream_recipe_handbook".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property UserAccount $creator0
 * @property UserAccount $editor0
 * @property IceCreamRecipeLink[] $iceCreamRecipeLinks
 * @property GoodsList[] $goods
 */
class IceCreamRecipeHandbook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ice_cream_recipe_handbook';
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
     * Gets query for [[IceCreamRecipeLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamRecipeLinks()
    {
        return $this->hasMany(IceCreamRecipeLink::className(), ['ice_cream_recipe_id' => 'id']);
    }

    /**
     * Gets query for [[Goods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(GoodsList::className(), ['id' => 'goods_id'])->viaTable('ice_cream_recipe_link', ['ice_cream_recipe_id' => 'id']);
    }
}
