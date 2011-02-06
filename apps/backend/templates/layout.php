<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />

    <?php echo stylesheet_tag('themes/ui-lightness/jquery-ui-1.8.4.custom.css', 'blueprint/screen.css', 'common.css', 'admin/main.css'); ?>
    <!--[if lt IE 8]><?php echo stylesheet_tag('blueprint/ie.css'); ?><![endif]-->
    <?php include_stylesheets(); ?>

    <?php echo javascript_include_tag('jquery-1.4.2.min.js', 'jquery-ui-1.8.4.custom.min.js'); ?>
    <?php if ($sf_user->getCulture() == 'fr'): ?>
      <?php echo javascript_include_tag('jquery.ui.datepicker-fr.js'); ?>
    <?php endif; ?>
    <?php echo javascript_include_tag('admin/main.js'); ?>
    <?php include_javascripts(); ?>
  </head>
  <body>
    <div class="container">
      <?php include_partial('global/header', array('module' => sfContext::getInstance()->getRequest()->getParameter('module'))); ?>
      <?php echo $sf_content ?>
    </div>
  </body>
</html>