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
        $this->createTable('{{%mailbox}}', [
            'id' => $this->primaryKey(),
            'host' => $this->string(50)->notNull(),
            'user' => $this->string(150)->notNull()->unique(),
            'password' => $this->string(100)->notNull(),
            'port' => $this->string(50)->notNull(),
            'folder' => $this->string(50)->notNull()->defaultValue('INBOX'),
            'ssl' => $this->boolean()->notNull()->defaultValue(true),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_at' => $this->integer()->notNUll()->defaultValue(0)
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
