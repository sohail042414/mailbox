<?php

use yii\db\Migration;

/**
 * Handles the creation of table `messages`.
 */
class m181211_062046_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'mailbox_id' => $this->integer()->notNull(),
            'message_uid' => $this->integer()->notNull(),
            'to' => $this->string(255)->notNull(),
            'from' => $this->string(255)->notNull(),
            'type' => $this->string(20)->notNull(),
            'subject' => $this->string(255)->notNull(),
            'date_sent' => $this->dateTime()->notNull(),
            'body' => $this->text()->notNull(),
            'raw_headers' => $this->text()->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_at' => $this->timestamp()->notNull()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('message');
    }
}
