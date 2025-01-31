<?php
use yii\helpers\Html;
?>
<div class="site-error">
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($data['mensaje'])) ?>
    </div>
</div>
