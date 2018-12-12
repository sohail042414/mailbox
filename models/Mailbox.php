<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%mailbox}}".
 *
 * @property int $id
 * @property string $host
 * @property string $user
 * @property string $password
 * @property string $port
 * @property string $ssl
 */
class Mailbox extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mailbox}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['host', 'user', 'password', 'port', 'ssl'], 'required'],
            [['host', 'password', 'port', 'ssl'], 'string', 'max' => 50],
            [['user'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'host' => 'Host',
            'user' => 'User',
            'password' => 'Password',
            'port' => 'Port',
            'ssl' => 'Ssl',
        ];
    }
}
