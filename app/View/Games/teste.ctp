<?php //debug($teste); ?>

<?php $stats = array_slice($stats, 0, 5); ?>

<script>
    var chart1; // globally available
    $(document).ready(function() {
        chart1 = new Highcharts.Chart({
            chart: {
                type: 'bar',
                renderTo: 'pgraph'
            },
            title: {
                text: 'Tareias Históricas'
            },
            xAxis: {
                categories: [<?php foreach($stats as $game){echo "'".$game['id']." - ".$game['goal_dif']."',";} ?>]

            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Golos'
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            series: [{
                name: 'Pretos',
                data: [<?php foreach($stats as $game){echo $game['team_b'].',';} ?>]
            }, {
                name: 'Vermelhos',
                data: [<?php foreach($stats as $game){echo $game['team_a'].',';} ?>]
            }]
        });
    });
</script>



<!--<div class="players view">
<h2><?php /* echo __($player['Player']['nome']);*/?></h2>-->


<div id="pgraph" class="playerGraph">
    <?php echo $this->Html->script('highcharts'); ?>
</div>