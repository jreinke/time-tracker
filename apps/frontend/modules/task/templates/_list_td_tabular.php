<td class="<?php echo $task->getPriority()->getClass(); ?>">&nbsp;</td>
<td class="sf_admin_text sf_admin_list_td_Milestone">
  <?php echo $task->getMilestone() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_Module">
  <?php echo $task->getModule() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_Priority">
  <?php echo $task->getPriority() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_name">
  <?php echo link_to($task->getName(), 'task_edit', $task) ?>
</td>
