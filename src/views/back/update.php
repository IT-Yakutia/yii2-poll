<?php

use yii\helpers\Html;

$this->title = 'Редактирование: ' . $model->title;

?>
<div class="poll-update">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</div>
</div>
