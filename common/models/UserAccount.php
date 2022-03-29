<?php

namespace app\common\models;

use app\storage\PublicKeyStorage;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/**
 * This is the model class for table "user_account".
 *
 * @property string $id
 * @property string $name User name
 * @property string $email
 * @property string|null $phone
 * @property int $role For the future
 * @property string $type Client type: front or kiosk
 * @property string|null $passwd
 * @property bool $is_user_active
 * @property string $token To force a token to be revoked
 * @property string $token_expired_at
 * @property bool $is_token_active
 * @property string|null $description
 * @property string|null $creator
 * @property string $created_at
 * @property string|null $editor
 * @property string|null $edited_at
 *
 * @property CoffeeIngredient[] $coffeeIngredients
 * @property CoffeeIngredient[] $coffeeIngredients0
 * @property CoffeeRecipe[] $coffeeRecipes
 * @property CoffeeRecipe[] $coffeeRecipes0
 * @property ConsumableGroupHandbook[] $consumableGroupHandbooks
 * @property ConsumableGroupHandbook[] $consumableGroupHandbooks0
 * @property ConsumableHandbook[] $consumableHandbooks
 * @property ConsumableHandbook[] $consumableHandbooks0
 * @property EquipmentHandbook[] $equipmentHandbooks
 * @property EquipmentHandbook[] $equipmentHandbooks0
 * @property GoodsCatalog[] $goodsCatalogs
 * @property GoodsCatalog[] $goodsCatalogs0
 * @property GoodsList[] $goodsLists
 * @property GoodsList[] $goodsLists0
 * @property IceCreamGoodsSize[] $iceCreamGoodsSizes
 * @property IceCreamGoodsSize[] $iceCreamGoodsSizes0
 * @property IceCreamRecipeHandbook[] $iceCreamRecipeHandbooks
 * @property IceCreamRecipeHandbook[] $iceCreamRecipeHandbooks0
 * @property IceCreamRecipeLink[] $iceCreamRecipeLinks
 * @property IceCreamRecipeLink[] $iceCreamRecipeLinks0
 * @property Kiosk[] $kiosks
 * @property Kiosk[] $kiosks0
 * @property KioskConsumable[] $kioskConsumables
 * @property KioskConsumable[] $kioskConsumables0
 * @property KioskEquipment[] $kioskEquipments
 * @property KioskEquipment[] $kioskEquipments0
 * @property KioskOwner[] $kioskOwners
 * @property KioskOwner[] $kioskOwners0
 * @property KioskOwner[] $kioskOwners1
 * @property SizeHandbook[] $sizeHandbooks
 * @property SizeHandbook[] $sizeHandbooks0
 * @property SodaWaterGoodsSize[] $sodaWaterGoodsSizes
 * @property SodaWaterGoodsSize[] $sodaWaterGoodsSizes0
 * @property SodaWaterRecipeHandbook[] $sodaWaterRecipeHandbooks
 * @property SodaWaterRecipeHandbook[] $sodaWaterRecipeHandbooks0
 * @property SodaWaterRecipeLink[] $sodaWaterRecipeLinks
 * @property SodaWaterRecipeLink[] $sodaWaterRecipeLinks0
 * @property UserAccount $creator0
 * @property UserAccount[] $userAccounts
 * @property UserAccount $editor0
 * @property UserAccount[] $userAccounts0
 */
class UserAccount extends ActiveRecord implements IdentityInterface
{
    const QUERY_AUTH_TYPE = 'yii\filters\auth\QueryParamAuth';
    const BEARER_AUTH_TYPE = 'yii\filters\auth\HttpBearerAuth';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'email', 'token'], 'required'],
            [['id', 'description', 'creator', 'editor'], 'string'],
            [['role'], 'default', 'value' => null],
            [['role'], 'integer'],
            [['is_user_active', 'is_token_active'], 'boolean'],
            [['token_expired_at', 'created_at', 'edited_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['type', 'token'], 'string', 'max' => 50],
            [['passwd'], 'string', 'max' => 200],
            [['email'], 'unique'],
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
            'email' => 'Email',
            'phone' => 'Phone',
            'role' => 'Role',
            'type' => 'Type',
            'passwd' => 'Passwd',
            'is_user_active' => 'Is User Active',
            'token' => 'Token',
            'token_expired_at' => 'Token Expired At',
            'is_token_active' => 'Is Token Active',
            'description' => 'Description',
            'creator' => 'Creator',
            'created_at' => 'Created At',
            'editor' => 'Editor',
            'edited_at' => 'Edited At',
        ];
    }

    /**
     * @param $id
     * @return IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);//, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param $token
     * @param $type
     * @return IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        echo $type; die();

        if ($type === self::QUERY_AUTH_TYPE) {
            $user = static::find()
                          ->joinWith('tokens t')
                          ->andWhere(['t.token' => $token])->one();
            //->andWhere(['>', 't.expired_at', time()]);
            if ($user['tokens'][0]['expired_at'] < time()) {
                throw new UnauthorizedHttpException('Token is expired');
            } else {
                return $user;
            }
        } else {
            if ($type === self::BEARER_AUTH_TYPE) {
                $jwt = \JOSE_JWT::decode($token);

                // TODO set data to config

                $url                = 'http://192.168.88.243:8088/.well-known/openid-configuration/jwks';
                $timeTokenDelta     = 86400; //12h //86400; // 24h
                $timePublicKeyDelta = 43200; //12h //86400; // 24h
                $jwtEmailField      = "http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress";


                if ($jwt->claims['exp'] + $timeTokenDelta < time()) {
                    throw new \JOSE_Exception_VerificationFailed('Token is expired');
                }


                try {
                    $jwt->verify(PublicKeyStorage::getPublicKey(), $jwt->header['alg']);
                } catch (\Exception $e) {
                    if (PublicKeyStorage::getChangeTime() + $timePublicKeyDelta < time() || PublicKeyStorage::isEmpty()) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        $result = curl_exec($ch);
                        curl_close($ch);

                        $components = reset(json_decode($result, true)['keys']);
                        $public_key = \JOSE_JWK::decode($components);

                        PublicKeyStorage::setPublicKey($public_key);
                    }
                }

                $jwt->verify(PublicKeyStorage::getPublicKey(), $jwt->header['alg']);

                //        var_dump($jwt->claims['sub']);
                //        var_dump($jwt->claims['sub']);
                //        var_dump($jwt->claims[$jwtEmailField]);
                return !empty($jwt)
                    ? static::findByEmail($jwt->claims[$jwtEmailField]) // static::findIdentity($jwt->claims['sub'])
                    : null;
            }
        }
        return null;
    }

    /**
     * {@inheritdoc}
     * @return static|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->token;
    }

    /**
     * @param $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Gets query for [[CoffeeIngredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoffeeIngredients()
    {
        return $this->hasMany(CoffeeIngredient::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[CoffeeIngredients0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoffeeIngredients0()
    {
        return $this->hasMany(CoffeeIngredient::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[CoffeeRecipes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoffeeRecipes()
    {
        return $this->hasMany(CoffeeRecipe::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[CoffeeRecipes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoffeeRecipes0()
    {
        return $this->hasMany(CoffeeRecipe::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[ConsumableGroupHandbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsumableGroupHandbooks()
    {
        return $this->hasMany(ConsumableGroupHandbook::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[ConsumableGroupHandbooks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsumableGroupHandbooks0()
    {
        return $this->hasMany(ConsumableGroupHandbook::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[ConsumableHandbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsumableHandbooks()
    {
        return $this->hasMany(ConsumableHandbook::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[ConsumableHandbooks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsumableHandbooks0()
    {
        return $this->hasMany(ConsumableHandbook::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[EquipmentHandbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentHandbooks()
    {
        return $this->hasMany(EquipmentHandbook::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[EquipmentHandbooks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentHandbooks0()
    {
        return $this->hasMany(EquipmentHandbook::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[GoodsCatalogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsCatalogs()
    {
        return $this->hasMany(GoodsCatalog::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[GoodsCatalogs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsCatalogs0()
    {
        return $this->hasMany(GoodsCatalog::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[GoodsLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsLists()
    {
        return $this->hasMany(GoodsList::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[GoodsLists0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsLists0()
    {
        return $this->hasMany(GoodsList::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[IceCreamGoodsSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamGoodsSizes()
    {
        return $this->hasMany(IceCreamGoodsSize::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[IceCreamGoodsSizes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamGoodsSizes0()
    {
        return $this->hasMany(IceCreamGoodsSize::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[IceCreamRecipeHandbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamRecipeHandbooks()
    {
        return $this->hasMany(IceCreamRecipeHandbook::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[IceCreamRecipeHandbooks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamRecipeHandbooks0()
    {
        return $this->hasMany(IceCreamRecipeHandbook::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[IceCreamRecipeLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamRecipeLinks()
    {
        return $this->hasMany(IceCreamRecipeLink::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[IceCreamRecipeLinks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIceCreamRecipeLinks0()
    {
        return $this->hasMany(IceCreamRecipeLink::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[Kiosks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKiosks()
    {
        return $this->hasMany(Kiosk::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[Kiosks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKiosks0()
    {
        return $this->hasMany(Kiosk::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[KioskConsumables]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskConsumables()
    {
        return $this->hasMany(KioskConsumable::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[KioskConsumables0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskConsumables0()
    {
        return $this->hasMany(KioskConsumable::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[KioskEquipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskEquipments()
    {
        return $this->hasMany(KioskEquipment::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[KioskEquipments0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskEquipments0()
    {
        return $this->hasMany(KioskEquipment::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[KioskOwners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskOwners()
    {
        return $this->hasMany(KioskOwner::className(), ['owner_id' => 'id']);
    }

    /**
     * Gets query for [[KioskOwners0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskOwners0()
    {
        return $this->hasMany(KioskOwner::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[KioskOwners1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKioskOwners1()
    {
        return $this->hasMany(KioskOwner::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[SizeHandbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSizeHandbooks()
    {
        return $this->hasMany(SizeHandbook::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[SizeHandbooks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSizeHandbooks0()
    {
        return $this->hasMany(SizeHandbook::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[SodaWaterGoodsSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterGoodsSizes()
    {
        return $this->hasMany(SodaWaterGoodsSize::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[SodaWaterGoodsSizes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterGoodsSizes0()
    {
        return $this->hasMany(SodaWaterGoodsSize::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[SodaWaterRecipeHandbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterRecipeHandbooks()
    {
        return $this->hasMany(SodaWaterRecipeHandbook::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[SodaWaterRecipeHandbooks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterRecipeHandbooks0()
    {
        return $this->hasMany(SodaWaterRecipeHandbook::className(), ['editor' => 'id']);
    }

    /**
     * Gets query for [[SodaWaterRecipeLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterRecipeLinks()
    {
        return $this->hasMany(SodaWaterRecipeLink::className(), ['creator' => 'id']);
    }

    /**
     * Gets query for [[SodaWaterRecipeLinks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSodaWaterRecipeLinks0()
    {
        return $this->hasMany(SodaWaterRecipeLink::className(), ['editor' => 'id']);
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
     * Gets query for [[UserAccounts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccounts()
    {
        return $this->hasMany(UserAccount::className(), ['creator' => 'id']);
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
     * Gets query for [[UserAccounts0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccounts0()
    {
        return $this->hasMany(UserAccount::className(), ['editor' => 'id']);
    }

}
