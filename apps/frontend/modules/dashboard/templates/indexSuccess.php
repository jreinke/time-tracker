<h1><?php echo __('Dashboard'); ?></h1>
<?php if (! count($projects)): ?>
  <p><?php echo __('No project found.'); ?></p>
<?php elseif (! $sf_user->hasCurrentProject()): ?>
  <p><?php echo __('Please select a project.'); ?></p>
<?php else: ?>
  <?php use_javascript('highcharts.js'); ?>
  <h3><?php echo $sf_user->getCurrentProject(); ?></h3>
  <div class="span-12">
    <div id="chart1"></div>
  </div>
  <div class="span-12 last">
    <div id="chart2"></div>
  </div>
  <div class="span-24 last clear">
    <div id="chart3"></div>
  </div>
  <script type="text/javascript">
    var chart1;
    var chart2;
    var chart3;
    $(document).ready(function() {
      <?php if ($total_time_spent): ?>
        data1 = [];
        data2 = [];
        data3 = [];
        categories = [];
        <?php foreach (array_slice($report_by_period->getRawValue(), -8, null, true) as $period => $row): ?>
          <?php if (! $period): continue; endif; ?>
          data1.push(<?php echo $total_time_estimated ?>);
          data2.push(<?php echo $row['time_spent'] ?>);
          categories.push('<?php echo substr($period, 0, 4) . ' S' . ltrim(substr($period, 4, 2), '0'); ?>');
        <?php endforeach; ?>
        yticks = [<?php echo implode(', ', range(0, round($total_time_spent))) ?>];

        chart1 = new Highcharts.Chart({
          chart: {
             renderTo: 'chart1',
             defaultSeriesType: 'line'
          },
          title: { text: '<?php echo __('Project progress') ?>' },
          xAxis: { categories: categories },
          yAxis: { title: { text: '<?php echo __('Days') ?>' }, min: 0 },
          plotOptions: {
             line: {
                dataLabels: { enabled: false },
                enableMouseTracking: true
             }
          },
          credits: { enabled: false },
          series: [{
             name: '<?php echo __('Time estimated') ?>',
             color: '#AA4643',
             data: data1
          }, {
             name: '<?php echo __('Time spent') ?>',
             color: '#4572A7',
             data: data2
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
             enabled: false
          },
          plotOptions: {
             pie: {
                size: '25%',
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

        data1 = [];
        data2 = [];
        data3 = [];
        data4 = [];
        categories = [];
        <?php foreach ($report_by_user->getRawValue() as $row): ?>
          data1.push(<?php echo $row['time_estimated'] ?>);
          data2.push(<?php echo $row['time_allocated'] ?>);
          data3.push(<?php echo $row['time_spent'] ?>);
          data4.push(<?php echo $row['time_left'] ?>);
          categories.push('<?php echo $row['name'] ? $row['name'] : __('Non assigned') ?>');
        <?php endforeach; ?>
        chart3 = new Highcharts.Chart({
            chart: {
               renderTo: 'chart3',
               defaultSeriesType: 'column'
            },
            title: {
               text: '<?php echo __('Employees stats') ?>'
            },
            xAxis: {
               categories: categories,
               title: {
                  text: null
               }
            },
            yAxis: {
               title: {
                  text: '<?php echo __('Days') ?>',
               }
            },
            plotOptions: {
               bar: {
                  dataLabels: {
                     enabled: true
                  }
               }
            },
            tooltip: {
              enabled: false
            },
            credits: { enabled: false },
            series: [
            <?php if ($sf_user->hasCredential('manager')): ?>{
                name: '<?php echo __('Time estimated') ?>',
                data: data1,
                color: '#AA4643',
                dataLabels: { enabled: true }
            },<?php endif; ?>{
               name: '<?php echo __('Time allocated') ?>',
               data: data2,
               color: '#89A54E',
               dataLabels: { enabled: true }
            }, {
               name: '<?php echo __('Time spent') ?>',
               data: data3,
               color: '#4572A7',
               dataLabels: { enabled: true }
            }, {
               name: '<?php echo __('Time left') ?>',
               data: data4,
               color: '#DB843D',
               dataLabels: { enabled: true }
            }]
         });
      <?php endif; ?>
    });
  </script>
<?php endif; ?>
