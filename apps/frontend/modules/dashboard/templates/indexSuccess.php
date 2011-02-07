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
<div class="span-14 last">
  <div id="chart1"></div>
  <div id="chart2"></div>

  <script type="text/javascript">
    var chart1;
    var chart2;
    $(document).ready(function() {
      <?php if ($total_time_spent): ?>
        line1 = [];
        categories = [];
        <?php foreach (array_slice($report_by_period->getRawValue(), -8, null, true) as $period => $row): ?>
          <?php if (! $period): continue; endif; ?>
          line1.push(<?php echo $row['time_spent'] ?>);
          categories.push('<?php echo substr($period, 0, 4) . ' S' . ltrim(substr($period, 4, 2), '0'); ?>');
        <?php endforeach; ?>
        yticks = [<?php echo implode(', ', range(0, round($total_time_spent))) ?>];

        chart1 = new Highcharts.Chart({
          chart: {
             renderTo: 'chart1',
             defaultSeriesType: 'line'
          },
          title: { text: '<?php echo __('Progress') ?>' },
          xAxis: { categories: categories },
          yAxis: { title: { text: '<?php echo __('Days') ?>' } },
          plotOptions: {
             line: {
                dataLabels: { enabled: true },
                enableMouseTracking: false
             }
          },
          credits: { enabled: false },
          series: [{
             name: '<?php echo __('Time spent') ?>',
             data: line1
          }]
        });
      <?php endif; ?>

      <?php if ($total_time_allocated): ?>
        data = [];
        <?php foreach ($report_by_user->getRawValue() as $row): ?>
          data.push(['<?php echo $row['name'] ? $row['name'] : __('Non assigned') ?>', <?php echo round($row['time_allocated'] * 100 / $total_time_allocated, 1) ?>]);
        <?php endforeach; ?>
        chart2 = new Highcharts.Chart({
          chart: {
             renderTo: 'chart2',
             plotBackgroundColor: null,
             plotBorderWidth: null,
             plotShadow: false
          },
          title: {
             text: '<?php echo __('User assignment') ?>'
          },
          tooltip: {
             formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
             }
          },
          plotOptions: {
             pie: {
                cursor: 'pointer',
                size: '50%',
                dataLabels: {
                   enabled: true,
                   formatter: function() {
                      return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
                   }
                }
             }
          },
          credits: { enabled: false },
          series: [{
             type: 'pie',
             name: 'Browser share',
             data: data
          }]
        });
      <?php endif; ?>
    });
  </script>
</div>
