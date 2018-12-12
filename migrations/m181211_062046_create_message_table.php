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
            'message_id' => $this->string(10)->notNull(),
            'to' => $this->string(255)->notNull(),
            'from' => $this->string(255)->notNull(),
            'subject' => $this->string(255)->notNull(),
            'body' => $this->text()->notNull(),
            'raw_headers' => $this->text()->notNull(),
            //'created_at' => $this->timestamp()->notNull(),
            //'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
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
