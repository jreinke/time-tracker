<?php if (! count($report)): ?>
  <p><?php echo __('No result'); ?></p>
<?php else: ?>
  <?php include_partial('report/table', array('rows' => $report->getRawValue(), 'th_col' => 'Milestone', 'name_col' => 'milestone')); ?>
<?php endif; ?>