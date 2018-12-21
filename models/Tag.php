<?php

namespace app\models;

use Yii;
use app\models\MessageTag;
use yii\data\ArrayDataProvider;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property int $id
 * @property string $tag
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
        ];
    }

    public function saveFoundTags($records)
    {
        foreach ($records as $row) {
            $tag_message = new MessageTag();
            $tag_message->tag_id = $row['tag_id'];
            $tag_message->message_id = $row['message_id'];
            $tag_message->position = $row['position'];
            $tag_message->count = $row['count'];
            $tag_message->save();
        }
    }


    public function getTopTags()
    {

        $message_tag_model = new \app\models\MessageTag();

        $sql = 'SELECT  tag_id,
        COUNT(tag_id) AS frequency 
        FROM     message_tag
        GROUP BY tag_id
        ORDER BY frequency DESC
        LIMIT    10';

        $query = $message_tag_model->findBySql($sql);

        $tags = [];

        foreach ($query->all() as $object) {

            $tag = $this->findOne($object->tag_id);

            $tags[] = [
                'id' => $tag->id,
                'tag_id' => $object->tag_id,
                'frequency' => $object->frequency,
                'tag' => $tag->tag
            ];
        }

        $provider = new ArrayDataProvider([
            'allModels' => $tags,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $provider;

    }
}
