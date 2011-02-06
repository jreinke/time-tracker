<?php use_helper('I18N') ?>

<div class="ui-widget ui-widget-content ui-corner-all">
  <h2 class="ui-widget-header ui-corner-all"><?php echo __('Signin', null, 'sf_guard') ?></h2>
  <?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form)) ?>
</div>