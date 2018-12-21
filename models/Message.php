<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property int $id
 * @property int $mailbox_id
 * @property int $message_uid
 * @property string $to
 * @property string $from
 * @property string $type
 * @property string $subject
 * @property string $date_sent
 * @property string $body
 * @property string $raw_headers
 * @property string $updated_at
 * @property string $created_at
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
            [['message_uid', 'to', 'from', 'type', 'subject', 'date_sent', 'body', 'raw_headers'], 'required'],
            [['message_uid', 'mailbox_id'], 'integer'],
            [['date_sent', 'updated_at', 'created_at'], 'safe'],
            [['body', 'raw_headers'], 'string'],
            [['to', 'from', 'subject'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_uid' => 'Message uid',
            'mailbox_id' => 'Mailbox id',
            'to' => 'To',
            'from' => 'From',
            'type' => 'Type',
            'subject' => 'Subject',
            'date_sent' => 'Date Sent',
            'body' => 'Body',
            'raw_headers' => 'Raw Headers',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public function getMailbox()
    {
        return $this->hasOne(Mailbox::className(), ['id' => 'mailbox_id']);
    }


    public function processTags()
    {

        $records = $this->find()->where('id > 0')->all();

        foreach ($records as $model) {
            $model->applyTags();
        }

        return true;
    }


    public function applyTags()
    {
        $tag_model = new \app\models\Tag();

        $model = $this;
        
        //delete all taging for current message. 
        \app\models\MessageTag::deleteAll('message_id = ' . $this->id);
        
        //get all tags and process. 
        $tags = $tag_model->find()->where('id > 0')->all();

        $findings = [];

        foreach ($tags as $obj) {

            $tag = $obj->tag;

            //search in subject
            preg_match_all('/\b' . $tag . '\b/', $model->subject, $matches);

            if (isset($matches[0]) && count($matches[0]) > 0) {
                $findings[] = [
                    'tag_id' => $obj->id,
                    'message_id' => $model->id,
                    'count' => count($matches[0]),
                    'position' => 'subject',
                ];
            }

            //search in body.
            preg_match_all('/\b' . $tag . '\b/', $model->body, $matches);

            if (isset($matches[0]) && count($matches[0]) > 0) {
                $findings[] = [
                    'tag_id' => $obj->id,
                    'message_id' => $model->id,
                    'count' => count($matches[0]),
                    'position' => 'body',
                ];
            }
            //search in headers
            preg_match_all('/\b' . $tag . '\b/', $model->raw_headers, $matches);

            if (isset($matches[0]) && count($matches[0]) > 0) {
                $findings[] = [
                    'tag_id' => $obj->id,
                    'message_id' => $model->id,
                    'count' => count($matches[0]),
                    'position' => 'headers',
                ];
            }
        }

        $tag_model->saveFoundTags($findings);
    }






}
