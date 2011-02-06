<?php if (! count($report)): ?>
  <p><?php echo __('No result'); ?></p>
<?php else: ?>
  <?php
    $rows = array();
    foreach ($report->getRawValue() as $row):
      if (! array_key_exists($row['module_id'], $rows)):
        $rows[$row['module_id']] = array(
          'name' => (string) $row['module'],
          'time_estimated' => 0,
          'time_allocated' => 0,
          'time_completed' => 0,
          'time_spent' => 0,
          'time_left' => 0,
        );
      endif;

      $rows[$row['module_id']]['time_estimated'] += $row['time_estimated'];
      $rows[$row['module_id']]['time_allocated'] += $row['time_allocated'];
      $rows[$row['module_id']]['time_completed'] += $row['is_completed'] ? $row['time_spent'] : 0;
      $rows[$row['module_id']]['time_spent'] += $row['time_spent'];
      $rows[$row['module_id']]['time_left'] += (null === $row['time_spent'] ? $row['time_allocated'] : $row['time_left']); // if no input, time left is time allocated
    endforeach;

    include_partial('report/table', array('rows' => $rows, 'th_col' => 'Module'));
  ?>
<?php endif; ?>