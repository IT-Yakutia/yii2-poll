<?php

use yii\helpers\Html;

$this->title = 'Редактирование: ' . $model->poll->title . ' | ' . $model->title;

?>
<div class="poll-question-update">
	<div class="row">
		<div class="col s12">
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
	</div>
</div>