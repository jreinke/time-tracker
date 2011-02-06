<?php use_helper('InputTime'); ?>

<?php if (! count($inputs)): ?>
  <p><?php echo __('No input found'); ?></p>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th class="compact"></th>
        <th><?php echo __('Project'); ?></th>
        <th><?php echo __('Milestone'); ?></th>
        <th><?php echo __('Task'); ?></th>
        <th class="right" title="<?php echo __('Time allocated'); ?>"><?php echo __('Alloc.'); ?></th>
        <th class="right" title="<?php echo __('Time spent'); ?>"><?php echo __('Spent'); ?></th>
        <th class="right" title="<?php echo __('Time left'); ?>"><?php echo __('Left'); ?></th>
        <th class="right"><?php echo __('Total'); ?></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($inputs as $key => $input): ?>
        <?php
          @$total_time_spent += $input->getTimeSpent();
          @$total += ($input->getTimeAllocated() - $input->getTotalTimeSpent() - $input->getTimeLeft());
        ?>
        <tr class="<?php echo $key % 2 ? 'even' : 'odd'; ?>">
          <td class="<?php echo $input->getPriority(); ?>">&nbsp;</td>
          <td><?php echo $input->getProject(); ?></td>
          <td><?php echo $input->getMilestone(); ?></td>
          <td><?php echo link_to('[' . $input->getAssignment()->getProfile()->getCode() . '] ' . $input->getAssignment()->getTask(), '@input_edit?id=' . $input->getId(), array('title' => __('Edit'))); ?></td>
          <td class="right"><?php echo format_time($input->getTimeAllocated()); ?></td>
          <td class="right"><?php echo format_time($input->getTimeSpent()); ?></td>
          <td class="right"><?php echo format_time($input->getTimeLeft()); ?></td>
          <td class="right nowrap"><?php echo format_time($input->getTimeAllocated() - $input->getTotalTimeSpent() - $input->getTimeLeft(), true); ?></td>
          <td class="right nowrap">
            <?php echo link_to(image_tag('edit.png', array('alt' => __('Edit'), 'title' => __('Edit'))), '@input_edit?id=' . $input->getId()); ?>
            <?php echo link_to(image_tag('delete.png', array('alt' => __('Delete'), 'title' => __('Delete'))), '@input_delete?id=' . $input->getId(), array('confirm' => __('Are you sure?'), 'method' => 'post')); ?>
          </td>
        </tr>
        <?php if ($input->getComment()): ?>
          <tr class="<?php echo $key % 2 ? 'even' : 'odd'; ?>">
            <td class="<?php echo $input->getPriority(); ?>">&nbsp;</td>
            <td colspan="8"><em><?php echo $input->getComment(); ?></em></td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="5"><?php echo __('Total'); ?></td>
        <td class="right nowrap"><?php echo format_time($total_time_spent); ?></td>
        <td></td>
        <td class="right nowrap"><?php echo format_time($total, true); ?></td>
        <td></td>
      </tr>
    </tfoot>
  </table>
<?php endif; ?>