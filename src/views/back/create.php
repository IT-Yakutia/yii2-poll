<?php

use yii\helpers\Html;

$this->title = 'Новый опрос';

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
