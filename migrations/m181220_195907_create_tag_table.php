<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags`.
 */
class m181220_195907_create_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'tag' => $this->string(30),
        ]);

        $this->batchInsert('tag', ['tag'], [
            [
                'tag' => 'credit',
            ],
            [
                'tag' => 'bank',
            ],
            [
                'tag' => 'sale',
            ],
            [
                'tag' => 'insurance',
            ],
            [
                'tag' => 'policy',
            ],
            [
                'tag' => 'purchase',
            ],
            [
                'tag' => 'demand',
            ]

        ]);

        $this->createTable('message_tag', [
            'id' => $this->primaryKey(),
            'message_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'count' => $this->smallInteger()->defaultValue(1),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tag');
    }
}
