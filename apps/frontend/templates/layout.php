<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />

    <?php echo stylesheet_tag(sprintf('themes/%s/jquery-ui-1.8.4.custom.css', $sf_user->getGuardUser()->getTheme()->getFolder())); ?>
    <?php echo stylesheet_tag('blueprint/screen.css', 'common.css', 'main.css'); ?>
    <!--[if lt IE 8]><?php echo stylesheet_tag('blueprint/ie.css'); ?><![endif]-->
    <?php include_stylesheets(); ?>

    <?php echo javascript_include_tag('jquery-1.4.2.min.js', 'jquery-ui-1.8.4.custom.min.js'); ?>
    <?php if ($sf_user->getCulture() == 'fr'): ?>
      <?php echo javascript_include_tag('jquery.ui.datepicker-fr.js'); ?>
    <?php endif; ?>
    <!--[if IE]><?php echo javascript_include_tag('excanvas.min.js'); ?><![endif]-->
    <?php echo javascript_include_tag('main.js'); ?>
    <?php include_javascripts(); ?>
  </head>
  <body class="<?php echo $module = sfContext::getInstance()->getRequest()->getParameter('module'); ?>">
    <div class="container">
      <?php include_partial('global/header', array('module' => $module)); ?>
      <?php echo $sf_content; ?>
    </div>
  </body>
</html>