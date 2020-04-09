<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Vote */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Votes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Questions', ['question/index', 'vote_id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'type',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img($model->photo, ['alt' => $model->name, 'class' => 'img-fluid img-thumbnail', 'width' => '150px']);
                }  
            ],
            'description:ntext',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <div class="row">
        <div class="col-lg-12">
            <?= \uraankhay\cytoscape\AutoloadExample::widget(['model' => $model->questions]); ?>
        </div>
    </div>

</div>
