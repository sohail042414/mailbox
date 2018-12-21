<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'mail_uid') ?>

    <?= $form->field($model, 'to') ?>

    <?= $form->field($model, 'from') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'subject') ?>

    <?php // echo $form->field($model, 'date_sent') ?>

    <?php // echo $form->field($model, 'body') ?>

    <?php // echo $form->field($model, 'raw_headers') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
