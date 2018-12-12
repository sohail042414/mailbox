<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mailbox`.
 */
class m181211_061223_create_mailbox_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        // $host = 'imap.mail.yahoo.com';
        // $user = 'sohail042414@yahoo.com';
        // $pass = 'Iamnumber24';
        // $port = 993;
        // $ssl = true;
        // $folder = 'INBOX';

        $this->createTable('{{%mailbox}}', [
            'id' => $this->primaryKey(),
            'host' => $this->string(50)->notNull(),
            'user' => $this->string(150)->notNull(),
            'password' => $this->string(50)->notNull(),
            'port' => $this->string(50)->notNull(),
            'ssl' => $this->string(50)->notNull(),
            //'created_at' => $this->timestamp()->notNull(),
            //'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('mailbox');
    }
}
