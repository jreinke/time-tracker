<h3 class="prepend-top"><?php echo __('Costs') ?></h3>

<div class="milestone-costs<?php $form['costs']->hasError() and print ' errors' ?>">
  <div>
    <div class="content"><?php echo $form['costs']->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?></div>
  </div>
</div>