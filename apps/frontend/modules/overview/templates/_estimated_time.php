<?php use_helper('InputTime', 'Number'); ?>

<?php if (! count($tasks)): ?>
  <p><?php echo __('No task found') ?></p>
<?php else: ?>
  <table class="overview">
    <thead>
      <tr>
        <th></th>
        <?php foreach ($profiles as $profile): ?>
          <th class="compact right" title="<?php echo $profile->getName(); ?>"><?php echo $profile->getCode(); ?></th>
        <?php endforeach; ?>
        <th class="compact right"><?php echo __('Total'); ?></th>
        <th class="compact right" title="<?php echo __('Time estimated - Time allocated'); ?>"><?php echo __('Diff.'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $project_cost = 0;
        $total_time_diff = 0;
        $total_times = array();
      ?>
      <?php foreach ($tasks as $milestone => $modules): ?>
        <?php
          $pieces = explode('-', $milestone, 2);
          $milestone_id = $pieces[0];
          $replace_pairs = array();
          ob_start(); // buffering to calculate milestone total profile time
        ?>
        <tr>
          <td rowspan="2" class="ui-state-hover border-right-bold"><?php echo $pieces[1]; ?></td>
          <?php foreach ($profiles as $profile): ?>
            <td class="ui-state-hover right"><?php echo count($modules) ? '{{time_' . $profile->getId() . '}}' : 0; ?></td>
          <?php endforeach; ?>
          <td class="ui-state-hover right border-left-bold border-right-bold"><?php echo count($modules) ? '{{milestone_time}}' : 0; ?></td>
          <td class="ui-state-hover">&nbsp;</td>
        </tr>
        <tr>
          <?php foreach ($profiles as $profile): ?>
            <td class="ui-state-hover right"><?php echo format_number(isset($costs[$milestone_id]) && isset($costs[$milestone_id][$profile->getId()]) ? $costs[$milestone_id][$profile->getId()] : 0); ?></td>
          <?php endforeach; ?>
          <td class="ui-state-hover right border-left-bold border-right-bold"><?php echo count($modules) ? '{{milestone_cost}}' : 0; ?></td>
          <td class="ui-state-hover">&nbsp;</td>
        </tr>

        <?php foreach ($modules as $module => $tasks): ?>
          <?php $pieces = explode('-', $module, 2); ?>
          <tr>
            <td class="prepend-1 border-right-bold ui-state-active"><?php echo $pieces[1]; ?></td>
            <td colspan="<?php echo count($profiles); ?>" class="ui-state-active"></td>
            <td class="border-left-bold border-right-bold ui-state-active"></td>
            <td class="ui-state-active"></td>
          </tr>

          <?php foreach ($tasks as $task => $array): ?>
            <?php $pieces = explode('-', $task, 2); ?>
            <tr>
              <td class="prepend-2 border-right-bold">
                <?php echo link_to($pieces[1], '@task_edit?id=' . $pieces[0], array('title' => __('Edit'))); ?>
              </td>
              <?php $task_cost = $task_time_diff = 0; ?>
              <?php foreach ($profiles as $profile): ?>
                <?php
                  if (isset($array[$profile->getId()]) && isset($costs[$milestone_id]) && isset($costs[$milestone_id][$profile->getId()])):
                    $task_cost += $array[$profile->getId()]['time_estimated'] * $costs[$milestone_id][$profile->getId()];
                  endif;
                  @$total_times[$profile->getId()] += isset($array[$profile->getId()]) ? $array[$profile->getId()]['time_estimated'] : 0;
                  @$replace_pairs['{{time_' . $profile->getId() . '}}'] += isset($array[$profile->getId()]) ? $array[$profile->getId()]['time_estimated'] : 0;
                  @$replace_pairs['{{milestone_time}}'] += isset($array[$profile->getId()]) ? $array[$profile->getId()]['time_estimated'] : 0;

                  $class = $title = '';
                  if (isset($array[$profile->getId()]) && $array[$profile->getId()]['time_diff'] != 0):
                    $task_time_diff += $array[$profile->getId()]['time_diff'];
                    $title = __('Time allocated: %time%', array('%time%' => format_time($array[$profile->getId()]['time_allocated'])));
                    $class .= ' bold ' . ($array[$profile->getId()]['time_diff'] > 0 ? 'positive' : 'negative');
                  endif;
                ?>
                <td class="right<?php echo $class; ?>" title="<?php echo $title; ?>">
                  <?php echo isset($array[$profile->getId()]) ? format_time($array[$profile->getId()]['time_estimated']) : ''; ?>
                </td>
              <?php endforeach; ?>
              <?php
                $total_time_diff += $task_time_diff;
                @$replace_pairs['{{milestone_cost}}'] += $task_cost;
              ?>
              <td class="right border-left-bold border-right-bold"><?php echo format_currency($task_cost, $currency); ?></td>
              <td class="right bold"><?php echo $task_time_diff != 0 ? format_time($task_time_diff, true) : ''; ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>

        <?php
          if (count($modules)):
            $project_cost += $replace_pairs['{{milestone_cost}}'];
            $replace_pairs['{{milestone_cost}}'] = format_currency($replace_pairs['{{milestone_cost}}'], $currency);
          endif;
          $html = ob_get_clean();
          $html = strtr($html, $replace_pairs);
          echo $html;
        ?>

      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td rowspan="2"><?php echo __('Total'); ?></td>
        <?php $project_total_time = 0; ?>
        <?php foreach ($profiles as $profile): ?>
          <?php $project_total_time += isset($total_times[$profile->getId()]) ? format_time($total_times[$profile->getId()]) : 0; ?>
          <td class="right"><?php echo isset($total_times[$profile->getId()]) ? format_time($total_times[$profile->getId()]) : 0; ?></td>
        <?php endforeach; ?>
        <td class="right"><?php echo format_time($project_total_time); ?></td>
        <td class="right"><?php echo format_time($total_time_diff, true); ?></td>
      </tr>
      <tr>
        <?php foreach ($profiles as $profile): ?>
          <td></td>
        <?php endforeach; ?>
        <td class="right"><?php echo format_currency($project_cost, $currency); ?></td>
        <td>&nbsp;</td>
      </tr>
    </tfoot>
  </table>
<?php endif; ?>