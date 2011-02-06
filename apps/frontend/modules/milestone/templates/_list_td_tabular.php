<td class="sf_admin_text sf_admin_list_td_name">
  <?php echo link_to($milestone->getName(), 'milestone_edit', $milestone) ?>
</td>
<td class="sf_admin_date sf_admin_list_td_start_date nowrap">
  <?php echo false !== strtotime($milestone->getStartDate()) ? format_date($milestone->getStartDate(), "D") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_end_date nowrap">
  <?php echo false !== strtotime($milestone->getEndDate()) ? format_date($milestone->getEndDate(), "D") : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_td_description">
  <?php echo $milestone->getDescription() ?>
</td>
