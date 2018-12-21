<?php

namespace app\models;

use Yii;
use app\models\Imap;
use app\models\Message;

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
            [['host', 'password', 'port', 'folder'], 'string', 'max' => 50],
            [['ssl'], 'boolean'],
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
            'folder' => 'Default Folder',
            'ssl' => 'Ssl',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d h:i:s');
        }

        return true;
    }

    public function fetchEmails()
    {

        $imap_object = new Imap($this->host, $this->user, $this->password, $this->port, true, 'INBOX');

        $ids = $imap_object->getIdsSinceDays(30);

        //$ids = $imap_object->getMessageIds();

        // echo "<pre>";
        // print_r($ids);
        // exit;

        //$ids = array_slice($ids,0,10);
        //$counter = 1;

        foreach ($ids as $id => $uid) {

            $already = Message::find()->where(['message_uid' => $uid, 'mailbox_id' => $this->id])->one();

            if (is_object($already)) {
                continue;
            }

            $data = $imap_object->getMessage($id);

            $message = new Message();
            $message->mailbox_id = $this->id;
            $message->message_uid = $uid;
            $message->to = isset($data['to']) ? $data['to'] : "";
            $message->from = isset($data['from']) ? $this->cleanSender($data['from']) : "";
            $message->subject = isset($data['subject']) ? $data['subject'] : "";
            $message->body = isset($data['body']) ? $data['body'] : "-------------";
            $message->raw_headers = isset($data['raw_header']) ? $data['raw_header'] : "";
            $message->date_sent = isset($data['date_sent']) ? date('Y-m-d h:i:s', strtotime($data['date_sent'])) : "";
            $message->created_at = date('Y-m-d h:i:s', time());
            $message->type = isset($data['body_type']) ? $data['body_type'] : '-';
            if (!$message->save()) {
                // echo "<pre>";
                // print_r($message->errors);
                // exit;
            }

            // $counter++;

            // if ($counter > 10) {
            //     break;
            // }
        }

        Yii::$app->session->setFlash('success', 'Mails loaded for mail box!');

    }

    private function cleanSender($sender)
    {
        // extract parts between the two parentheses
        $mailAddress = preg_match('/(?:<)(.+)(?:>)$/', $sender, $matches);
        return $matches[1];
    }
}
