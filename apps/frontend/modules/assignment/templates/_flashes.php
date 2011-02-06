<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="messages ui-state-highlight ui-corner-all">
    <p>
      <span class="ui-icon ui-icon-info"></span><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?>
    </p>
    <script type="text/javascript">
      setTimeout(function() { $('#assignment-form-dialog').dialog('close') }, 1000);
    </script>
  </div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>
  <div class="messages ui-state-error ui-corner-all">
    <p>
      <span class="ui-icon ui-icon-info"></span><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?>
    </p>
  </div>
<?php endif; ?>
