<?php use_javascript('highcharts.js'); ?>

<h1><?php echo __('Dashboard'); ?></h1>

<div class="span-10">
  <h3><?php echo __('My projects'); ?></h3>
  <?php if (! count($projects)): ?>
    <p><?php echo __('No project found'); ?></p>
  <?php else: ?>
    <ul>
      <?php foreach ($projects as $project): ?>
        <li <?php if ($sf_user->getCurrentProjectId() == $project->getId()): echo 'class="bold"'; endif; ?>><?php echo link_to($project, '@switch_project_id?id=' . $project->getId()); ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>
<?php if (isset($project_report)): ?>
  <?php
    $rows = array();
    $previous_period = null;
    $previous_time_spent = $time_spent = $total_time_spent = 0;
    foreach ($project_report->getRawValue() as $row):
      if (null === $row['period']):
        continue;
      endif;

      $time_spent = $row['time_spent'];
      $previous_time_spent += $time_spent;
      if ($previous_period != $row['period']):
        $time_spent = $previous_time_spent;
        $previous_period = $row['period'];
      endif;

      @$rows[$row['period']]['time_allocated'] += $row['time_allocated'];
      @$rows[$row['period']]['time_completed'] += $row['is_completed'] ? $row['time_spent'] : 0;
      @$rows[$row['period']]['time_spent'] += $time_spent;
      @$rows[$row['period']]['time_left'] += (null === $row['time_spent'] ? $row['time_allocated'] : $row['time_left']); // if no input, time left is time allocated
      $total_time_spent = $rows[$row['period']]['time_spent'];
    endforeach;
  ?>
  <div class="span-14 last">
    <?php if ($total_time_spent): ?>
      <div id="chart"></div>
      <script type="text/javascript">
        line1 = [];
        categories = [];
        <?php $i = 0; ?>
        <?php foreach (array_slice($rows, -8, null, true) as $period => $row): $i++; ?>
          line1.push(<?php echo $row['time_spent'] ?>);
          categories.push('<?php echo substr($period, 0, 4) . ' S' . ltrim(substr($period, 4, 2), '0'); ?>');
        <?php endforeach; ?>
        yticks = [<?php echo implode(', ', range(0, round($total_time_spent))) ?>];
        var chart;
        $(document).ready(function() {
           chart = new Highcharts.Chart({
              chart: {
                 renderTo: 'chart',
                 defaultSeriesType: 'line'
              },
              title: {
                 text: '<?php echo __('Progress') ?>'
              },
              xAxis: {
                 categories: categories
              },
              yAxis: {
                 title: {
                    text: '<?php echo __('Days') ?>'
                 }
              },
              plotOptions: {
                 line: {
                    dataLabels: {
                       enabled: true
                    },
                    enableMouseTracking: false
                 }
              },
              credits: {
                  enabled: false,
              },
              series: [{
                 name: '<?php echo __('Time spent') ?>',
                 data: line1
              }]
           });
        });
      </script>
    <?php endif; ?>
  </div>
<?php endif; ?>