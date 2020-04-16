<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->title = 'Список опросов';
$this->params['breadcrumbs'][] = $this->title;

?>

<main class="poll">
    <section>
        <div class="container">
            <h3 class="styled d-flex justify-content-between">
                <?= $this->title ?>
            </h3>
            <br>
        </div>
        <div class="container">
            <div class="row">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => function ($model, $key, $index, $widget){
                        return $this->render('_item', [
                            'model' => $model,
                            'models' => $widget->dataProvider->models,
                            'key' => $key,
                            'index' => $index,
                        ]);
                    },
                    'options' => ['tag' => false, 'class' => false, 'id' => false],
                    'itemOptions' => [
                        'tag' => false,
                        'class' => 'news-item',
                    ],
                    'layout' => '{items}',
                    'summaryOptions' => ['class' => 'summary grey-text'],
                    'emptyTextOptions' => ['class' => 'empty grey-text'],
                ]) ?>
            </div>
            <div class="row">
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'registerLinkTags' => true,
                    'options' => ['class' => 'pagination'],
                    'prevPageCssClass' => '',
                    'nextPageCssClass' => '',
                    'pageCssClass' => 'page-item',
                    'nextPageLabel' => '>',
                    'prevPageLabel' => '<',
                    'linkOptions' => ['class' => 'page-link btn'],
                    'disabledPageCssClass' => 'd-none',
                ]); ?>
            </div>
        </div>
    </section>
</main>