<?php

use yii\helpers\Html;

$this->title = $poll->title. ': Создание нового вопроса';

?>
<div class="poll-question-update">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
				'model' => $model,
				'poll' => $poll,
				// 'searchModel' => $searchModel,
				// 'dataProvider' => $dataProvider
		    ]) ?>
		</div>
	</div>
</div>
