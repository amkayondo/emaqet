<?php
use app\components\CategoriesListWidget;
use app\components\PageSectionWidget;
use app\components\SocialMediaListWidget;
use app\models\Page;
?>
<footer id="footer">

    <div class="post-add-bar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span class="pull-right"><?= t('app', 'The easy way to make extra money')?></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <a href="<?= url(['/listing/post']); ?>" class="btn-as secondary"><i class="fa fa-plus" aria-hidden="true"></i><?=t('app','Post new ad');?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= CategoriesListWidget::widget(['title' => t('app', 'Categories')]) ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <?= PageSectionWidget::widget(['sectionType' => Page::SECTION_ONE]) ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <?= PageSectionWidget::widget(['sectionType' => Page::SECTION_TWO]) ?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <?= SocialMediaListWidget::widget(['title' => t('app', 'Connect')]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="copyright">
                    <?=options()->get('app.settings.common.siteCopyright', '&copy; EasyAds Application'); ?>
                </div>
            </div>
        </div>
    </div>

</footer>