<?php
include './controller.php';


echo '<div>
    <canvas id="pieChartRole"></canvas>
</div>'
?>

<script>
    const ctxRole = document.getElementById('pieChartRole').getContext('2d');
    const pieChart = new Chart(ctxRole, {
        type: 'pie',
        data: {
            // labels: <?= json_encode($months) ?>,
            labels: ["Test1", "Test2", "Test3"],

            datasets: [{
                label: 'Total Employees',
                // data: <?= json_encode($totalEmployees) ?>,
                data: [10, 20, 30],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255,99,132)',
                    'rgba(54,162,235)',
                    'rgba(255,206,86)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Employee Distribution by Month'
                }
            }
        }
    });
</script>