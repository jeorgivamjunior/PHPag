<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel">
            <div class="panel-body">
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>


<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Ago", 'Set', "Out"],
            datasets: [
                {
                    label: 'Contas à receber',
                    data: [1, 2, 3],
                    backgroundColor: "rgba(38,185,155,0.5)",
                    borderColor: "rgba(38,185,155,1)",
                    borderWidth: 1
                },
                {
                    label: 'Contas à pagar',
                    data: [5, 5, 3],
                    backgroundColor: "rgba(217,83,79,0.5)",
                    borderColor: "rgba(217,83,79,1)",
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>