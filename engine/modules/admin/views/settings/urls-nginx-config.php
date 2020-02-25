<?php
/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.5.1
 */
?>

server {
listen      80;
server_name <?php echo html_encode($appHost); ?>;
root        <?php echo html_encode($_SERVER['DOCUMENT_ROOT']); ?>;

location <?php echo $baseUrl; ?> {
<?php foreach (app()->modules as $name => $className) {?>
    <?php if($name == 'debug' || $name == 'gii' || $name == 'datecontrol') continue; ?>
    if (!-e $request_filename){
    rewrite ^(/)?<?php echo html_encode($name); ?>/.*$ /<?php echo html_encode($name); ?>/index.php;
    }
<?php } ?>

if (!-e $request_filename){
rewrite ^(.*)$ /index.php;
}

index  index.html index.htm index.php;
}

#error_page  404              /404.html;

# redirect server error pages to the static page /50x.html
#
error_page   500 502 503 504  /50x.html;

# pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
location ~ \.php$ {
fastcgi_split_path_info  ^(.+\.php)(.*)$;

fastcgi_param  PATH_INFO        $fastcgi_path_info;
fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
include fastcgi_params;

fastcgi_pass   127.0.0.1:9000;
fastcgi_index  index.php;

fastcgi_read_timeout 600s;
fastcgi_send_timeout 600s;
}

# deny access to .htaccess files, if Apache's document root
# concurs with nginx's one
#
location ~ /\.ht {
deny  all;
}
}
