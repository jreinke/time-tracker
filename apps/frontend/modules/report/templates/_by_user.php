<?php if (! count($report)): ?>
  <p><?php echo __('No result'); ?></p>
<?php else: ?>
  <?php include_partial('report/table', array('rows' => $report->getRawValue(), 'th_col' => 'Employee', 'name_col' => 'name')); ?>
<?php endif; ?>