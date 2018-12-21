<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%message_tag}}".
 *
 * @property int $id
 * @property int $message_id
 * @property int $tag_id
 * @property int $count
 * @property string $position
 */
class MessageTag extends \yii\db\ActiveRecord
{
    public $frequency = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%message_tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message_id', 'tag_id', 'count'], 'integer'],
            [['position'], 'string'],
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
            'tag_id' => 'Tag ID',
            'count' => 'Count',
            'position' => 'Position',
        ];
    }





}
