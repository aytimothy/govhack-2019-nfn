<center>
    <div style="width:75%;">
        {!! $light_chart->render() !!}
    </div>
    <div style="width:75%;">
        {!! $humidity_chart->render() !!}
    </div>
    <div style="width:75%;">
        {!! $temperature_chart->render() !!}
    </div>
    <script src="/vendor/chart.js/Chart.js"></script>
</center>