<?php

use yii\helpers\Html;

$this->title = 'Новый опрос';

?>
<div class="poll-update">
	<div class="row">
		<div class="col s12">
			<p></p>
			<?= Html::a('Главная', ['/']) ?> /
			<?= Html::a('Опросы', ['index']) ?>
			<p></p>

			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
	</div>
</div>