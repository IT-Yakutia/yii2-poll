<?php

$this->title = 'Спасибо что приняли участие в нашем опросе!';

?>

<div class="poll" data-id="<?= $model->id ?>">
    <h3><?= $this->title ?></h3>
    <p><?= $model->title ?></p>
</div>