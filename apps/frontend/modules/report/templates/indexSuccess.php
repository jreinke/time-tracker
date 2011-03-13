<?php use_helper('InputTime'); ?>

<div id="sf_admin_container">
  <h1><?php echo __('Reports'); ?></h1>

  <div id="sf_admin_bar">
    <?php include_partial('report/filters', array('form' => $filters)) ?>
  </div>

  <div id="report-by-menu">
    <ul>
      <li><?php echo link_to(__('By user'), '@report_by?by=user', array('class' => $group_by == 'user' ? 'selected' : '')); ?></li>
      <li><?php echo link_to(__('By milestone'), '@report_by?by=milestone', array('class' => $group_by == 'milestone' ? 'selected' : '')); ?></li>
      <li><?php echo link_to(__('By module'), '@report_by?by=module', array('class' => $group_by == 'module' ? 'selected' : '')); ?></li>
      <li><?php echo link_to(__('By profile'), '@report_by?by=profile', array('class' => $group_by == 'profile' ? 'selected' : '')); ?></li>
      <li><?php echo link_to(__('By task'), '@report_by?by=task', array('class' => $group_by == 'task' ? 'selected' : '')); ?></li>
      <li><?php echo link_to(__('By assignment'), '@report_by?by=assignment', array('class' => $group_by == 'assignment' ? 'selected' : '')); ?></li>
    </ul>
  </div>

  <div>
    <?php include_partial('report/by_' . $group_by, array('report' => $report)); ?>
  </div>
</div>