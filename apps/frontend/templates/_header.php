<div id="header">
  <div class="fright"><?php echo $sf_user ?>&nbsp;<?php echo link_to(__('Logout'), '@sf_guard_signout') ?></div>
  <div id="project-switcher" class="fleft append-1">
    <?php include_component('default', 'projectSwitcher', array('user' => $sf_user)); ?>
  </div>
  <div id="theme-switcher" class="fleft">
    <?php include_component('default', 'themeSwitcher', array('user' => $sf_user)); ?>
  </div>
</div>
<div id="menu" class="clear append-bottom ui-tabs ui-widget ui-widget-content ui-corner-all">
  <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
    <li class="ui-state-default ui-corner-top<?php echo $module == 'dashboard' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Dashboard'), '@dashboard'); ?></li>
    <?php if ($sf_user->hasCurrentProject()): ?>
      <li class="ui-state-default ui-corner-top<?php echo $module == 'input' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Inputs'), '@input'); ?></li>
      <li class="ui-state-default ui-corner-top<?php echo $module == 'overview' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Overview'), '@overview'); ?></li>
      <li class="ui-state-default ui-corner-top<?php echo $module == 'report' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Reports'), '@report'); ?></li>

      <?php if ($sf_user->hasCredential('manager')): ?>
        <li class="ui-state-default ui-corner-top<?php echo $module == 'milestone' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Milestones'), '@milestone'); ?></li>
        <li class="ui-state-default ui-corner-top<?php echo $module == 'module' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Modules'), '@module'); ?></li>
        <li class="ui-state-default ui-corner-top<?php echo $module == 'task' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Tasks'), '@task'); ?></li>
        <li class="ui-state-default ui-corner-top<?php echo $module == 'user' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Users'), '@project_user'); ?></li>
      <?php endif; ?>
    <?php endif; ?>
  </ul>
</div>
