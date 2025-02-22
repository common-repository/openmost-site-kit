<div class="postbox" style="margin-bottom: 0">
    <div class="inner">
        <div id="visits-summary-chart" style="width: 100%; height: 400px;"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function () {

        let response = await fetchMatomoApi({
            'method': 'API.get',
            'period': '<?php echo omsk_get_matomo_period(); ?>',
            'date': '<?php echo omsk_get_matomo_date(); ?>',
            'showColumns': 'nb_visits,nb_pageviews',
            'segment': 'pageUrl==<?php echo get_the_permalink(get_the_ID()); ?>',
        }).then(response => response.json());

        let series = [
            {
                name: '<?php _e('Visits', 'openmost-site-kit'); ?>',
                data: Object.values(response.data).map(d => d.nb_visits),
                type: 'line'
            },
            {
                name: '<?php _e('Page views', 'openmost-site-kit'); ?>',
                data: Object.values(response.data).map(d => d.nb_pageviews),
                type: 'line'
            }
        ];

        let el = document.getElementById('visits-summary-chart');
        let chart = echarts.init(el);
        chart.setOption({
            tooltip: {
                trigger: 'axis'
            },
            grid: {
                top: '32px',
                left: '16px',
                right: '32px',
                bottom: '16px',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: Object.keys(response.data),
            },
            yAxis: {
                type: 'value'
            },
            series: series
        })
    });
</script>
