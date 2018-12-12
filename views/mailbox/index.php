<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchMailbox */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mailboxes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailbox-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Mailbox', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'host',
            'user',
            'password',
            'port',
            //'ssl',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}{load}',  // the default buttons + your custom button
                'buttons' => [
                    'load' => function($url, $model, $key) {     // render your custom button
                        return Html::a("Load",['load', 'id' => $model->id]);
                    }
                ]
            ]
        ],
    ]); ?>
</div>
