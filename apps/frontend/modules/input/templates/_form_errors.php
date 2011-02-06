<?php if ($form->hasGlobalErrors()): ?>
  <div class="messages ui-state-error ui-corner-all">
    <p>
      <span class="ui-icon ui-icon-info"></span>
      <?php foreach ($form->getGlobalErrors() as $error): ?>
        <?php echo __($error); ?>
      <?php endforeach; ?>
    </p>
  </div>
<?php endif; ?>
