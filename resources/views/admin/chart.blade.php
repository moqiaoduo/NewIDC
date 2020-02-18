<canvas id="chart_{{$name=Str::random()}}" width="400" height="400"></canvas>
<script>
    $(function () {
        var ctx = document.getElementById("chart_{{$name}}").getContext('2d');
        var myChart = new Chart(ctx, JSON.parse('@json($options)'));
    });
</script>
