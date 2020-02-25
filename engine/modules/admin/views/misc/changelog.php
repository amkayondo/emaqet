<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
    </div>
    <div class="box-body">
        <div class="block">
            <div class="form-group">
                <textarea class="form-control" rows="30"><?php echo html_encode($changelog);?></textarea>
            </div>
        </div>
    </div>
</div>

