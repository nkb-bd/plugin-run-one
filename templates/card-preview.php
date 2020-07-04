<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Imagetoolbar" content="No"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e('Preview Form', 'fluentform') ?></title>
    <?php
    wp_head();
    ?>
    <style type="text/css">

    </style>
</head>
<body>
<div class="wrap">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="preview-plugin-run-one-card-container center-p">

                <h4 class=" ">Preview of Cards from Post ID : <?php echo $id ?> </h4>
                <div class=" plugin-one-card-mt-20  plugin-one-card-mb-20">
                    <code > <span>[ </span>PluginRunTwo_card id="<?php echo $id;?>"<span>]</span> </code>
                </div>

                <?php echo do_shortcode('[PluginRunTwo_card id="'.$id.'" ]')?>

            </div>
        </main>
    </div>
</div>
<?php
wp_footer();
?>

</body>
</html>
