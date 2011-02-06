<?php if (! count($report)): ?>
  <p><?php echo __('No result'); ?></p>
<?php else: ?>
  <?php
    $rows = array();
    foreach ($report->getRawValue() as $row):
      if (null === $row['user_id']):
        $row['user_id'] = 0;
      endif;

      if (! array_key_exists($row['user_id'], $rows)):
        $rows[$row['user_id']] = array(
          'name' => $row['user_id'] ? trim($row['first_name'] . ' ' . $row['last_name']) : __('Non assigned'),
          'first_name' => (string) $row['first_name'],
          'last_name' => (string) $row['last_name'],
          'time_estimated' => 0,
          'time_allocated' => 0,
          'time_completed' => 0,
          'time_spent' => 0,
          'time_left' => 0,
        );
      endif;

      $rows[$row['user_id']]['time_estimated'] += $row['time_estimated'];
      $rows[$row['user_id']]['time_allocated'] += $row['time_allocated'];
      $rows[$row['user_id']]['time_completed'] += $row['is_completed'] ? $row['time_spent'] : 0;
      $rows[$row['user_id']]['time_spent'] += $row['time_spent'];
      $rows[$row['user_id']]['time_left'] += (null === $row['time_spent'] ? $row['time_allocated'] : $row['time_left']); // if no input, time left is time allocated
    endforeach;

    include_partial('report/table', array('rows' => $rows, 'th_col' => 'Employee'));
  ?>
<?php endif; ?>