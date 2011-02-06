<?php use_helper('InputTime'); ?>

<h3 class="prepend-top"><?php echo __('Assignment List') ?></h3>

<div id="assignment-list-errors" class="error_list"></div>

<div class="assignment-list">
  <?php if (! count($task->getAssignments())): ?>
    <p><?php echo __('No assignment found'); ?></p>
  <?php else: ?>
    <table cellspacing="0" class="ui-widget w-auto">
      <thead class="ui-widget-header">
        <tr>
          <th><?php echo __('User'); ?></th>
          <th><?php echo __('Profile'); ?></th>
          <th><?php echo __('Time estimated'); ?></th>
          <th><?php echo __('Time allocated'); ?></th>
          <th><?php echo __('Actions'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php $total_estimated = $total_allocated = 0; ?>
        <?php foreach ($task->getAssignments() as $i => $assignment): ?>
          <tr class="sf_admin_row <?php echo $i % 2 ? 'even' : 'odd'; ?>">
            <td><?php echo $assignment->getUserId() ? $assignment->getUser() : '<em>' . __('Non assigned') . '</em>'; ?></td>
            <td><?php echo $assignment->getProfile(); ?></td>
            <td class="right"><?php echo format_time($assignment->getTimeEstimated()); ?></td>
            <td class="right"><?php echo format_time($assignment->getTimeAllocated()); ?></td>
            <td>
              <ul class="sf_admin_td_actions">
                <li class="sf_admin_action_edit"><?php echo link_to(__('Edit', array(), 'sf_admin'), '@assignment_edit?id=' . $assignment->getId()); ?></li>
                <li class="sf_admin_action_delete"><?php echo link_to(__('Delete', array(), 'sf_admin'), '@ajax_assignment_delete?id=' . $assignment->getId()); ?></li>
              </ul>
            </td>
          </tr>
          <?php
            $total_estimated += $assignment->getTimeEstimated();
            $total_allocated += $assignment->getTimeAllocated();
          ?>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><?php echo __('Total'); ?></td>
          <td class="right"><?php echo format_time($total_estimated); ?></td>
          <td class="right"><?php echo format_time($total_allocated); ?></td>
          <td class="right"><?php echo format_time($total_estimated - $total_allocated, true); ?></td>
        </tr>
      </tfoot>
    </table>
  <?php endif; ?>
</div>
