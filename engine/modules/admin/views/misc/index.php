<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$this->title;?></h3>
    </div>
    <div class="box-body">
        <iframe src="<?php echo app()->urlManager->createUrl(['admin/misc', ['show' => 1]]);?>" width="100%" height="700" frameborder="0"></iframe>
    </div>
</div>