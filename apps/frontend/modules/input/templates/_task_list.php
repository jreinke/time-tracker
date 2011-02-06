<?php use_helper('InputTime'); ?>

<?php ! isset($with_time_spent) ? $with_time_spent = true : null; ?>

<?php if (! count($assignments)): ?>
  <p><?php echo __('No task found'); ?></p>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th class="compact"></th>
        <th><?php echo __('Module'); ?></th>
        <th><?php echo __('Task'); ?></th>
        <th class="right" title="<?php echo __('Time allocated'); ?>"><?php echo __('Alloc.'); ?></th>
        <?php if ($with_time_spent): ?>
          <th class="right" title="<?php echo __('Time spent'); ?>"><?php echo __('Spent'); ?></th>
          <th class="right" title="<?php echo __('Time left'); ?>"><?php echo __('Left'); ?></th>
          <th class="right"><?php echo __('Total'); ?></th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php $total = array('time_allocated' => 0, 'time_spent' => 0, 'time_left' => 0, 'total' => 0); ?>
      <?php foreach ($assignments as $key => $assignment): ?>
        <?php
          $total['time_allocated'] += $assignment->getTimeAllocated();
          if ($with_time_spent):
            $total['time_spent'] += $assignment->getTimeSpent();
            $total['time_left'] += $assignment->getTimeLeft();
            $total['total'] += ($assignment->getTimeAllocated() - $assignment->getTimeSpent() - $assignment->getTimeLeft());
          endif;
        ?>
        <tr class="<?php echo $key % 2 ? 'even' : 'odd'; ?><?php echo $current_assignment_id == $assignment->getId() ? ' bold' : '' ?>">
          <td class="<?php echo $assignment->getTask()->getPriority()->getClass(); ?>">&nbsp;</td>
          <td><?php echo $assignment->getTask()->getModule(); ?></td>
          <td><?php echo link_to('[' . $assignment->getProfile()->getCode() . '] ' . $assignment->getTask()->getName(), sprintf('@input_new?assignment_id=%d&date=%s', $assignment->getId(), $date), array('title' => $assignment->getTask()->getMilestone())); ?></td>
          <td class="right"><?php echo format_time($assignment->getTimeAllocated()); ?></td>
          <?php if ($with_time_spent): ?>
            <td class="right"><?php echo format_time($assignment->getTimeSpent()); ?></td>
            <td class="right"><?php echo format_time($assignment->getTimeLeft()); ?></td>
            <td class="right nowrap"><?php echo format_time($assignment->getTimeAllocated() - $assignment->getTimeSpent() - $assignment->getTimeLeft(), true); ?></td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3"><?php echo __('Total'); ?></td>
        <td class="right"><?php echo format_time($total['time_allocated']); ?></td>
        <?php if ($with_time_spent): ?>
          <td class="right"><?php echo format_time($total['time_spent']); ?></td>
          <td class="right"><?php echo format_time($total['time_left']); ?></td>
          <td class="right nowrap"><?php echo format_time($total['total'], true); ?></td>
        <?php endif; ?>
      </tr>
    </tfoot>
  </table>
<?php endif; ?>