<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property int $id
 * @property string $message_id
 * @property string $to
 * @property string $from
 * @property string $subject
 * @property string $body
 * @property string $raw_headers
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message_id', 'to', 'from', 'subject', 'body', 'raw_headers'], 'required'],
            [['body', 'raw_headers'], 'string'],
            [['message_id'], 'string', 'max' => 10],
            [['to', 'from', 'subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_id' => 'Message ID',
            'to' => 'To',
            'from' => 'From',
            'subject' => 'Subject',
            'body' => 'Body',
            'raw_headers' => 'Raw Headers',
        ];
    }
}
