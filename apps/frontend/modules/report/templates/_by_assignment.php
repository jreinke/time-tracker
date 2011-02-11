<?php if (! count($report)): ?>
  <p><?php echo __('No result'); ?></p>
<?php else: ?>
  <?php
    $milestones_name = array();
    $modules_name = array();
    $tasks_name = array();
    $rows = array();
    foreach ($report->getRawValue() as $row):
      @$rows[$row['milestone_id']][$row['module_id']][$row['task_id']][$row['user_id']]['name'] = ($row['user_id'] ? trim($row['first_name'] . ' ' . $row['last_name']) : __('Non assigned'));
      @$rows[$row['milestone_id']][$row['module_id']][$row['task_id']][$row['user_id']]['time_estimated'] += $row['time_estimated'];
      @$rows[$row['milestone_id']][$row['module_id']][$row['task_id']][$row['user_id']]['time_allocated'] += $row['time_allocated'];
      @$rows[$row['milestone_id']][$row['module_id']][$row['task_id']][$row['user_id']]['time_completed'] += $row['is_completed'] ? $row['time_spent'] : 0;
      @$rows[$row['milestone_id']][$row['module_id']][$row['task_id']][$row['user_id']]['time_spent'] += $row['time_spent'];
      @$rows[$row['milestone_id']][$row['module_id']][$row['task_id']][$row['user_id']]['time_left'] += $row['time_left'];

      $milestones_name[$row['milestone_id']] = $row['milestone'];
      $modules_name[$row['module_id']] = $row['module'];
      $tasks_name[$row['task_id']] = $row['task'];
    endforeach;
  ?>
  <table class="report">
    <thead>
      <tr>
        <th></th>
        <?php if ($sf_user->hasCredential('manager')): ?>
          <th class="compact right" title="<?php echo __('Time estimated'); ?>"><?php echo __('Estim.'); ?></th>
        <?php endif; ?>
        <th class="compact right" title="<?php echo __('Time allocated'); ?>"><?php echo __('Alloc.'); ?></th>
        <th class="compact right" title="<?php echo __('Time spent'); ?>"><?php echo __('Spent'); ?></th>
        <th class="compact right" title="<?php echo __('Time left'); ?>"><?php echo __('Left'); ?></th>
        <th class="compact right" title="<?php echo __('Time completed'); ?>"><?php echo __('Compl.'); ?></th>
        <th class="compact right"><?php echo __('Total'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 0; $total = array('time_estimated' => 0, 'time_allocated' => 0, 'time_spent' => 0, 'time_left' => 0, 'time_completed' => 0, 'total' => 0); ?>
      <?php foreach ($rows as $milestone_id => $modules): ?>
        <tr>
          <td colspan="7" class="ui-state-hover"><?php echo $milestones_name[$milestone_id]; ?></td>
        </tr>
        <?php foreach ($modules as $module_id => $tasks): ?>
          <tr>
            <td colspan="7" class="prepend-1 ui-state-active"><?php echo $modules_name[$module_id]; ?></td>
          </tr>
          <?php foreach ($tasks as $task_id => $users): ?>
            <tr>
              <td colspan="7" class="prepend-2 bold"><?php echo $tasks_name[$task_id]; ?></td>
            </tr>
            <?php foreach ($users as $user_id => $row): ?>
              <?php
                $i++;
                $total['time_estimated'] += $row['time_estimated'];
                $total['time_allocated'] += $row['time_allocated'];
                $total['time_completed'] += $row['time_completed'];
                $total['time_spent'] += $row['time_spent'];
                $total['time_left'] += $row['time_left'];
                $total['total'] += ($row['time_allocated'] - $row['time_spent'] - $row['time_left']);
              ?>
              <tr class="<?php echo ! $user_id ? 'em quiet' : ''; ?>">
                <td class="prepend-3"><?php echo $row['name']; ?></td>
                <?php if ($sf_user->hasCredential('manager')): ?>
                  <td class="right"><?php echo format_time($row['time_estimated']); ?></td>
                <?php endif; ?>
                <td class="right"><?php echo format_time($row['time_allocated']); ?></td>
                <td class="right"><?php echo format_time($row['time_spent']); ?></td>
                <td class="right"><?php echo format_time($row['time_left']); ?></td>
                <td class="right"><?php echo format_time($row['time_completed']); ?></td>
                <td class="right nowrap"><?php echo format_time($row['time_allocated'] - $row['time_spent'] - $row['time_left'], true); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td><?php echo __('Total'); ?></td>
        <?php if ($sf_user->hasCredential('manager')): ?>
          <td class="right"><?php echo format_time($total['time_estimated']); ?></td>
        <?php endif; ?>
        <td class="right"><?php echo format_time($total['time_allocated']); ?></td>
        <td class="right"><?php echo format_time($total['time_spent']); ?></td>
        <td class="right"><?php echo format_time($total['time_left']); ?></td>
        <td class="right"><?php echo format_time($total['time_completed']); ?></td>
        <td class="right nowrap"><?php echo format_time($total['total'], true); ?></td>
      </tr>
    </tfoot>
  </table>
<?php endif; ?>