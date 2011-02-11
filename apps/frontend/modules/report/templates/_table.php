<table>
  <thead>
    <tr>
      <th><?php echo __($th_col); ?></th>
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
    <?php foreach ($rows as $object_id => $row): ?>
      <?php
        $i++;
        $total['time_estimated'] += $row['time_estimated'];
        $total['time_allocated'] += $row['time_allocated'];
        $total['time_completed'] += $row['time_completed'];
        $total['time_spent'] += $row['time_spent'];
        $total['time_left'] += $row['time_left'];
        $total['total'] += ($row['time_allocated'] - $row['time_spent'] - $row['time_left']);
      ?>
      <tr class="<?php echo $i % 2 ? 'odd' : 'even'; ?><?php echo ! $object_id ? ' em quiet' : ''; ?>">
        <td><?php echo $row[$name_col]; ?></td>
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