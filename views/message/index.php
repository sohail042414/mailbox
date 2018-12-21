<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchMessage */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Message', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            //'message_uid',
            [
                'attribute' => 'mailbox_id',
                'filter' => $mailboxes,
                'value' => 'mailbox.user'
            ],
            //'to',
            'from',
            'type',
            'subject',
            'date_sent',
            [
                'header' => 'Apply Tags',
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Apply', ['/message/apply', 'id' => $model->id], ['class' => 'btn btn-primary']);
                }
            ],
            //'body:ntext',
            //'raw_headers:ntext',
            //'updated_at',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
