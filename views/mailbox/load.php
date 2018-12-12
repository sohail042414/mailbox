<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Mailbox */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mailboxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mailbox-view">

    <h1>Messages loaded for mail box <?php echo $model->user; ?></h1>

    <?php echo  Html::a("View messages",['/message/index', 'id' => $model->id]); ?>

</div>
