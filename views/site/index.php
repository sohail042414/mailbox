<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Mailbox Manager!</h1>

        <p class="lead"></p>
        <p><a class="btn btn-lg btn-success" href="/message/process">Process Tags!</a></p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-md-offset-2 col-lg-offset-2">
                <h1>Most frequently used tags!</h1>
            <?= GridView::widget([
                'dataProvider' => $top_tags,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'tag_id',
                    'tag',
                    'frequency'
                ],
            ]);
            ?>               
            </div>
        </div>

    </div>
</div>
