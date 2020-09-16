<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use uraankhayayaal\materializecomponents\grid\MaterialActionColumn;
use uraankhayayaal\sortable\grid\Column;

$this->title = 'Опросы';

?>
<div class="poll-index">
    <div class="row">
        <div class="col s12">
            <p>
                <?= Html::a('Добавить новый опрос', ['create'], ['class' => 'btn']) ?>
            </p>
            <div class="fixed-action-btn">
                <?= Html::a('<i class="material-icons">add</i>', ['create'], [
                    'class' => 'btn-floating btn-large waves-effect waves-light tooltipped',
                    'title' => 'Сохранить',
                    'data-position' => "left",
                    'data-tooltip' => "Добавить",
                ]) ?>
            </div>

            <?= GridView::widget([
                'tableOptions' => [
                    'class' => 'striped bordered my-responsive-table',
                    'id' => 'sortable'
                ],
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-sortable-id' => $model->id];
                },
                'options' => [
                    'data' => [
                        'sortable-widget' => 1,
                        'sortable-url' => Url::toRoute(['sorting']),
                    ]
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'class' => MaterialActionColumn::class,
                        'template' => '{view} {update} {back-question/index}',
                        'buttons' => [
                            'back-question/index' => function($url, $model, $key) {
                                $icon = Html::tag('i', 'add_circle', ['class' => "material-icons"]);
                                $options = [
                                    'title' => Yii::t('yii', 'Добавить вопросы'),
                                    'aria-label' => Yii::t('yii', 'Добавить вопросы'),
                                    'data-pjax' => '0',
                                ];
                                return Html::a($icon, $url, $options);
                            }
                        ]
                    ],

                    [
                        'header' => 'Фото',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->photo ? '<img class="materialboxed" src="' . $model->photo . '" width="70">' : '';
                        }
                    ],
                    [
                        'attribute' => 'title',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->title, ['view', 'id' => $model->id]);
                        }
                    ],
                    [
                        'attribute' => 'description',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->description, ['view', 'id' => $model->id]);
                        }
                    ],
                    [
                        'attribute' => 'slug',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a('<span class="grey-text">' . Yii::$app->params['domain'] . '</span>poll/' . $model->slug, '/poll/' . $model->slug, ['target' => "_blank"]);
                        },
                    ],
                    [
                        'attribute' => 'is_publish',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->is_publish ? '<i class="material-icons green-text">done</i>' : '<i class="material-icons red-text">clear</i>';
                        },
                        'filter' => [0 => 'Нет', 1 => 'Да'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                    ],
                    ['class' => MaterialActionColumn::class, 'template' => '{delete}'],
                    [
                        'class' => Column::class,
                    ],
                ],
                'pager' => [
                    'class' => 'yii\widgets\LinkPager',
                    'options' => ['class' => 'pagination center'],
                    'prevPageCssClass' => '',
                    'nextPageCssClass' => '',
                    'pageCssClass' => 'waves-effect',
                    'nextPageLabel' => '<i class="material-icons">chevron_right</i>',
                    'prevPageLabel' => '<i class="material-icons">chevron_left</i>',
                ],
            ]); ?>
        </div>
    </div>
</div>