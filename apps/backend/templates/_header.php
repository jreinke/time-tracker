<div id="header">
  <div class="fright"><?php echo $sf_user ?>&nbsp;<?php echo link_to(__('Logout'), '@sf_guard_signout') ?></div>
</div>
<div id="menu" class="clear append-bottom ui-tabs ui-widget ui-widget-content ui-corner-all">
  <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
    <li class="ui-state-default ui-corner-top<?php echo $module == 'project' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Projects'), '@project'); ?></li>
    <li class="ui-state-default ui-corner-top<?php echo $module == 'project_user' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Project users'), '@project_user'); ?></li>
    <li class="ui-state-default ui-corner-top<?php echo $module == 'user' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Users'), '@user'); ?></li>
    <li class="ui-state-default ui-corner-top<?php echo $module == 'company' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Companies'), '@company'); ?></li>
    <li class="ui-state-default ui-corner-top<?php echo $module == 'customer' ? ' ui-state-active ui-tabs-selected' : ''; ?>"><?php echo link_to(__('Customers'), '@customer'); ?></li>
  </ul>
</div>