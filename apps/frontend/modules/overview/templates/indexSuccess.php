<div id="sf_admin_container">
  <h1><?php echo __('Overview'); ?></h1>

  <div id="sf_admin_bar">
    <?php include_partial('overview/filters', array('form' => $filters)) ?>
  </div>

  <?php if (isset($overview)): ?>
    <?php
      $tasks = array();
      foreach ($overview->getRawValue() as $row):
        $milestone = $row['milestone_id'] . '-' . $row['milestone'];

        if (! isset($tasks[$milestone])):
          $tasks[$milestone] = array();
        endif;

        if ($row['module_id']):
          $module = $row['module_id'] . '-' . $row['module'];

          if (! isset($tasks[$milestone][$module])):
            $tasks[$milestone][$module] = array();
          endif;

          $task = $row['task_id'] . '-' . $row['task'];

          if (! isset($tasks[$milestone][$module][$task])):
            $tasks[$milestone][$module][$task] = array();
          endif;

          if ($row['profile_id']):
            $tasks[$milestone][$module][$task][$row['profile_id']] = array(
              'time_estimated' => $row['time_estimated'],
              'time_allocated' => $row['time_allocated'],
              'time_diff'      => $row['time_estimated'] - $row['time_allocated'],
            );
          endif;
        endif;
      endforeach;
    ?>

    <?php if ($sf_user->hasCredential('manager')): ?>
      <?php include_partial('overview/estimated_time', array('tasks' => $tasks, 'profiles' => $profiles, 'costs' => $costs, 'currency' => $currency)); ?>
    <?php else: ?>
      <?php include_partial('overview/allocated_time', array('tasks' => $tasks, 'profiles' => $profiles)); ?>
    <?php endif; ?>
  <?php endif; ?>
</div>