<h2><?=html_encode($title);?></h2>
<?php if (!empty($pages)) {?>
    <ul class="links two-columns">
        <?php foreach ($pages as $page) {
            $url = 'pages/index';
            if($page['page_id'] == 'contact-form'){ ?>
                <li><a href="<?= $page['slug']; ?>"><?=html_encode($page['title']);?></a></li>
            <?php } else {
                $hrefUrl = (empty($page['external_url'])) ? url([$url, 'slug' => $page['slug']]) : $page['external_url'];
                $target = (empty($page['external_url'])) ? '_self' : '_blank';
                ?>
                <li><a href="<?= $hrefUrl; ?>" target="<?=$target;?>"><?=html_encode($page['title']);?></a></li>
            <?php } ?>
        <?php } ?>
    </ul>
<?php } ?>
