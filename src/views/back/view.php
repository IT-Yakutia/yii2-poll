<?php


use uraankhayayaal\sortable\grid\Column;
use uraankhayayaal\materializecomponents\grid\MaterialActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = $model->title;

?>

<div class="poll-view">
    <div class="row">
        <div class="col s12 m4">
            <h5>Вопросы</h5>
            <div>
                <?= Html::a('Добавить вопрос', ['/poll/back-question/create', 'poll_id' => $model->id], ['class' => 'btn']) ?>
            </div>
            <ul class="collection">
                <?php
                foreach ($model->pollQuestions as $key => $question) {
                    $question_active = '';
                    $question_text_active = 'black-text';
                    if ($activeQuestion !== null && $question->id == $activeQuestion->id) {
                        $question_active = 'active';
                        $question_text_active = 'white-text';
                    }

                ?>
                    <li class="collection-item <?= $question_active ?>">
                        <div>
                            <?= Html::a('<i class="material-icons ' . ($question->is_publish ? '' : 'red-text') . '">' . ($question->is_publish ? 'done' : 'clear') . '</i>', ['view', 'id' => $model->id, 'question_id' => $question->id], ['class' => 'secondary-content']) ?>
                            <?= Html::a($question->title, ['view', 'id' => $model->id, 'question_id' => $question->id], ['class' => 'truncate ' . $question_text_active, 'style' => 'width: calc(100% - 30px);']) ?>
                        </div>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <div class="col s12 m8">
            <h5>Варианты ответов</h5>
            <?php if ($activeQuestion == null) { ?>
                <p class="grey-text">Выберите вопрос</p>
            <?php } else { ?>
                <?= Html::a('Редактировать вопрос', ['/poll/back-question/update', 'id' => $activeQuestion->id, 'poll_id' => $model->id], ['class' => 'btn']) ?>
                <?= Html::a('Удалить вопрос', ['/poll/back-question/delete', 'id' => $activeQuestion->id, 'poll_id' => $model->id], ['class' => 'btn', 'data-confirm' => "Вы уверены, что хотите удалить этот элемент?", 'data-method' => "post"]) ?>
                <hr>

                <?= Html::a('Добавить вариант ответа', ['/poll/back-option/create', 'poll_question_id' => $activeQuestion->id], ['class' => 'btn']) ?>
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
                            'sortable-url' => Url::toRoute(['/poll/back-option/sorting']),
                        ]
                    ],
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['class' => MaterialActionColumn::class, 'controller' => '/poll/back-option', 'template' => '{view} {update}'],

                        [
                            'header' => 'Фото',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->src ? '<img class="materialboxed" src="' . $model->src . '" width="70">' : '';
                            }
                        ],
                        [
                            'attribute' => 'title',
                            'header' => 'Вариант ответа',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a($model->title, ['/poll/back-option/update', 'id' => $model->id]);
                            }
                        ],
                        $results,
                        [
                            'attribute' => 'is_publish',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->is_publish ? '<i class="material-icons green-text">done</i>' : '<i class="material-icons red-text">clear</i>';
                            },
                            'filter' => [0 => 'Нет', 1 => 'Да'],
                        ],
                        ['class' => MaterialActionColumn::class, 'controller' => '/poll/poll-option', 'template' => '{delete}'],
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
            <?php } ?>
        </div>
    </div>
</div>