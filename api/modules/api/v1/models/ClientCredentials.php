<?php

namespace api\modules\api\v1\models;

use yii\db\ActiveRecord;
use api\modules\api\v1\models\repository\ClientCredentialsRepository;

/**
 * Class ClientCredentials
 *
 * @package api\modules\api\v1\models
 */
class ClientCredentials extends ActiveRecord
{
    const CRED_CLIENT = 'client_credentials';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client_credentials}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * Returns client repository
     *
     * @return ClientCredentialsRepository
     */
    public static function find()
    {
        return new ClientCredentialsRepository(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'client_secret'], 'required'],
            [['client_id', 'client_secret'], 'string']
        ];
    }
}
