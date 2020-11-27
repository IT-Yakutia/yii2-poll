<?php

use yii\helpers\Html;

$this->title = 'Редактирование: ' . $model->title;

?>
<div class="poll-update">
	<div class="row">
		<div class="col s12">
			<p></p>
			<?= Html::a('Главная', ['/']) ?> /
			<?= Html::a('Опросы', ['index']) ?> /
			<?= Html::a('Просмотр опроса', ['view', 'id' => $model->id]) ?> /
			<?= Html::a('Редактирование опроса', ['update', 'id' => $model->id]) ?> /
			<?= Html::a('Вопросы', ['back-question/index', 'id' => $model->id]) ?>
			<p></p>

			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
	</div>
</div>