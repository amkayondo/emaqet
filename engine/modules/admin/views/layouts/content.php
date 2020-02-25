<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <?= notify()->show();?>
    <div class="notify-wrapper"></div>
    <section class="content-header">
        <h1>&nbsp;</h1>
        <?php echo Breadcrumbs::widget([
            'homeLink'  => ['label' => t('app', 'Home'), 'url' => url(['/admin'])],
            'links'     => view_param('pageBreadcrumbs'),
            'options'   => ['class' => 'breadcrumb breadcrumb-top'],
            'tag'       => 'ul',
        ]); ?>
    </section>
    <section class="content <?= app()->controller->id . '-' . app()->controller->action->id;?>">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="">
        <b><a href="/" target="_blank">Emaqet &copy; 2020</a>
    </div>
</footer>