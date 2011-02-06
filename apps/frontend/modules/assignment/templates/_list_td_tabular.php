<?php use_helper('InputTime'); ?>

<td class="<?php echo $assignment->getTask()->getPriority()->getClass(); ?>">&nbsp;</td>
<td class="sf_admin_text sf_admin_list_td_Milestone">
  <?php echo $assignment->getTask()->getMilestone() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_Module">
  <?php echo $assignment->getTask()->getModule() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_Task">
  <?php echo link_to($assignment->getTask(), 'assignment_edit', $assignment) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_User">
  <?php echo $assignment->getUser() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_Profile">
  <?php echo $assignment->getProfile() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_time_estimated right">
  <?php echo format_time($assignment->getTimeEstimated()) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_time_allocated right">
  <?php echo format_time($assignment->getTimeAllocated()) ?>
</td>
