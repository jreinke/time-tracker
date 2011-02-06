<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php echo stylesheet_tag('themes/redmond/jquery-ui-1.8.4.custom.css'); ?>
    <?php echo stylesheet_tag('blueprint/screen.css', 'common.css', 'main.css'); ?>
    <!--[if lt IE 8]><?php echo stylesheet_tag('blueprint/ie.css'); ?><![endif]-->
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body class="login">
    <div class="container">
        <div class="prepend-6 span-12 last">
          <?php echo $sf_content ?>
        </div>
    </div>
  </body>
</html>
