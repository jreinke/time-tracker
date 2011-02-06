<?php use_helper('InputTime'); ?>

<?php if (! count($tasks)): ?>
  <p><?php echo __('No task found') ?></p>
<?php else: ?>
  <table class="overview">
    <thead>
      <tr>
        <th></th>
        <?php foreach ($profiles as $profile): ?>
          <th class="compact right"><?php echo $profile->getCode(); ?></th>
        <?php endforeach; ?>
        <th class="compact right"><?php echo __('Total'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
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
          <td class="ui-state-hover border-right-bold"><?php echo $pieces[1]; ?></td>
          <?php foreach ($profiles as $profile): ?>
            <td class="ui-state-hover right"><?php echo count($modules) ? '{{time_' . $profile->getId() . '}}' : 0; ?></td>
          <?php endforeach; ?>
          <td class="ui-state-hover right border-left-bold"><?php echo count($modules) ? '{{milestone_time}}' : 0; ?></td>
        </tr>

        <?php foreach ($modules as $module => $tasks): ?>
          <?php $pieces = explode('-', $module, 2); ?>
          <tr>
            <td class="border-right-bold ui-state-active"><strong><?php echo $pieces[1]; ?></strong></td>
            <td colspan="<?php echo count($profiles); ?>" class="ui-state-active"></td>
            <td class="border-left-bold ui-state-active"></td>
          </tr>

          <?php foreach ($tasks as $task => $array): ?>
          <?php $pieces = explode('-', $task, 2); ?>
            <tr>
              <td class="prepend-2 border-right-bold">
                <?php echo $pieces[1]; ?>
              </td>
              <?php foreach ($profiles as $profile): ?>
                <?php @$total_times[$profile->getId()] += isset($array[$profile->getId()]) ? $array[$profile->getId()]['time_allocated'] : 0; ?>
                <?php @$replace_pairs['{{time_' . $profile->getId() . '}}'] += isset($array[$profile->getId()]) ? $array[$profile->getId()]['time_allocated'] : 0; ?>
                <?php @$replace_pairs['{{milestone_time}}'] += isset($array[$profile->getId()]) ? $array[$profile->getId()]['time_allocated'] : 0; ?>
                <td class="right"><?php echo isset($array[$profile->getId()]) ? format_time($array[$profile->getId()]['time_allocated']) : ''; ?></td>
              <?php endforeach; ?>
              <td class="border-left-bold"></td>
            </tr>
          <?php endforeach; ?>

        <?php endforeach; ?>

        <?php
          $html = ob_get_clean();
          $html = strtr($html, $replace_pairs);
          echo $html;
        ?>

      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td><?php echo __('Total'); ?></td>
        <?php $project_total_time = 0; ?>
        <?php foreach ($profiles as $profile): ?>
          <?php $project_total_time += isset($total_times[$profile->getId()]) ? format_time($total_times[$profile->getId()]) : 0; ?>
          <td class="right"><?php echo isset($total_times[$profile->getId()]) ? format_time($total_times[$profile->getId()]) : 0; ?></td>
        <?php endforeach; ?>
        <td class="right"><?php echo format_time($project_total_time); ?></td>
      </tr>
    </tfoot>
  </table>
<?php endif; ?>