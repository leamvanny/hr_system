<?php
include "./controller.php";
// include_once './helpers.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./custom.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart.js plugin for number on bars -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="./helper.js"></script>

    <style>
        .bg-menu-item-active {
            background-color: #cac6c672 !important;
            color: white !important;
            padding: 8px 10px;
            border-radius: 4px;
        }
    </style>

</head>

<body>
    <div class="container-fluid bg-page">
        <div class="row">
            <div class="col-md-2 bg-primary text-white" id="sidebar">
                <div class="sticky-top">
                    <?php

                    include "./menu.php";
                    ?>
                </div>
            </div>
            <div class="col-md-10 p-0" id="topbar">
                <div class="sticky-top">
                    <?php
                    include "./navBar.php";
                    ?>
                </div>
                <div class="p-3">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="bg-white rounded p-3 d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-bold fs-5 mb-1">Total Employees</p>
                                    <span class="text-small">Total number of employees</span>
                                    <h4 class="fw-bold text-primary mt-2">
                                        <?php echo getCount("employees", $conn); ?>
                                    </h4>
                                </div>
                                <div>
                                    <i class="fa-solid fa-users fa-2x text-primary fs-5" style=" background-color:rgba(108, 165, 226, 0.28) !important; padding: 6px; border-radius: 4px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="bg-white rounded p-3 d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-bold fs-5 mb-1">Total Departments</p>
                                    <span class="text-small">Total number of departments</span>
                                    <h4 class="fw-bold text-primary mt-2">
                                        <?php echo getCount("departments", $conn); ?>
                                    </h4>
                                </div>
                                <div>
                                    <i class="fa-solid fa-building-user text-primary fs-5" style=" background-color:rgba(108, 165, 226, 0.28) !important; padding: 6px; border-radius: 4px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="bg-white rounded p-3 d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-bold fs-5 mb-1">Total Salary</p>
                                    <span class="text-small">Total number of salary</span>
                                    <h4 class="fw-bold text-primary mt-2">
                                        <?php
                                        $sql = "SELECT SUM(s.base_salary) AS total_salary FROM salaries s
                                                JOIN employees e ON s.salary_id = e.salary_id";
                                        $result = $conn->query($sql);
                                        if ($result && $row = $result->fetch_assoc()) {
                                            echo formatSalaryShort($row['total_salary'], 2);
                                        } else {
                                            echo "$0.00";
                                        }
                                        ?>
                                    </h4>
                                </div>
                                <div>
                                    <i class="fa-solid fa-hand-holding-dollar text-primary fs-5" style=" background-color:rgba(108, 165, 226, 0.28) !important; padding: 6px; border-radius: 4px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="bg-white rounded p-3 d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-bold fs-5 mb-1">Avg. Salary</p>
                                    <span class="text-small">Total number of avg. salary</span>
                                    <h4 class="fw-bold text-primary mt-2">
                                        <?php
                                        // $sql = "SELECT AVG(base_salary) AS average_salary FROM salaries";
                                        $sql = "SELECT AVG(s.base_salary) AS average_salary FROM salaries s
                                                JOIN employees e ON s.salary_id = e.salary_id";
                                        $result = $conn->query($sql);
                                        if ($result && $row = $result->fetch_assoc()) {
                                            echo formatSalaryShort($row['average_salary'], 2);
                                        } else {
                                            echo "$0.00";
                                        }
                                        ?>
                                    </h4>
                                </div>
                                <div>
                                    <i class="fa-solid fa-money-bill-trend-up fa-2x text-primary fs-5" style=" background-color:rgba(108, 165, 226, 0.28) !important; padding: 6px; border-radius: 4px;"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4">
                        <div class="row align-items-start">
                            <div class="col-lg-8 col-md-8 col-12">
                                <div class="bg-white rounded p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <span class="fw-bold">
                                                All of Employees
                                            </span>
                                        </div>

                                        <!-- Filter -->
                                        <form method="GET">
                                            <select class="form-select" name="filterTotalEmployees" onchange="this.form.submit()" style="font-size: 14px;">
                                                <option value="<?php echo date("Y"); ?>" <?= $selectedYear == date("Y") ? 'selected' : '' ?>>Current Year</option>
                                                <option value="<?php echo date("Y") - 1; ?>" <?= $selectedYear == date("Y") - 1 ? 'selected' : '' ?>>Last Year</option>
                                                <option value="<?php echo date("Y") - 2; ?>" <?= $selectedYear == date("Y") - 2 ? 'selected' : '' ?>>Last Two Years</option>
                                            </select>
                                        </form>

                                    </div>

                                    <!-- Counts -->
                                    <div class="mb-4">
                                        <div>
                                            <span style="font-size: 14px;">- Total Male Employees: </span><span class="fw-bold"><?php echo json_encode(array_sum(array_values($maleData))); ?></span>
                                        </div>
                                        <div>
                                            <span style="font-size: 14px;">- Total Female Employees: </span><span class="fw-bold"><?php echo json_encode(array_sum(array_values($femaleData))); ?></span>
                                        </div>
                                    </div>

                                    <!-- Bar Chart Count-->
                                    <canvas id="employeeGenderChart"></canvas>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-12 bg-white rounded p-3">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <span class="fw-bold">
                                                All of Employees's Roles
                                            </span>
                                        </div>

                                        <!-- Filter -->
                                        <form method="GET">
                                            <select class="form-select" name="filterTotalEmployeesRole" onchange="this.form.submit()" style="font-size: 14px;">
                                                <option value="<?php echo date("Y"); ?>" <?= $selectedYearPie == date("Y") ? 'selected' : '' ?>>Current Year</option>
                                                <option value="<?php echo date("Y") - 1; ?>" <?= $selectedYearPie == date("Y") - 1 ? 'selected' : '' ?>>Last Year</option>
                                                <option value="<?php echo date("Y") - 2; ?>" <?= $selectedYearPie == date("Y") - 2 ? 'selected' : '' ?>>Last Two Years</option>
                                            </select>
                                        </form>

                                    </div>
                                    <!-- Counts -->
                                    <div class="mb-4">
                                        <div>
                                            <span style="font-size: 14px;">- Total Employee Admin Role: </span><span class="fw-bold"><?php echo json_encode(array_sum(is_array($adminCount) ? array_values($adminCount) : [$adminCount])); ?></span>
                                        </div>
                                        <div>
                                            <span style="font-size: 14px;">- Total Employees Manager Role: </span><span class="fw-bold"><?php echo json_encode(array_sum(is_array($managerCount) ? array_values($managerCount) : [$managerCount])); ?></span>
                                        </div>
                                        <div>
                                            <span style="font-size: 14px;">- Total Employees Default Employee Role: </span><span class="fw-bold"><?php echo json_encode(array_sum(is_array($employeeCount) ? array_values($employeeCount) : [$employeeCount])); ?></span>
                                        </div>
                                    </div>
                                    <canvas id="pieChartRole"></canvas>
                                </div>
                            </div>

                        </div>




                        <script>
                            // Bar Chart for Employee count
                            const ctx = document.getElementById('employeeGenderChart').getContext('2d');

                            const chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?php echo json_encode(array_keys($maleData)); ?>,
                                    datasets: [{
                                            label: 'Male',
                                            data: <?php echo json_encode(array_values($maleData)); ?>,
                                            backgroundColor: 'rgba(54, 162, 235, 0.7)'
                                        },
                                        {
                                            label: 'Female',
                                            data: <?php echo json_encode(array_values($femaleData)); ?>,
                                            backgroundColor: 'rgba(75, 192, 92, 0.7)'
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'bottom'
                                        },
                                        title: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 10
                                            }
                                        },
                                        x: {
                                            stacked: false
                                        }
                                    }
                                }
                            });
                        </script>


                        <!-- PieChart for couting role -->
                        <script>
                            const ctxRole = document.getElementById('pieChartRole').getContext('2d');
                            const pieChart = new Chart(ctxRole, {
                                type: 'pie',
                                data: {
                                    labels: <?php echo json_encode($roleNames); ?>,
                                    datasets: [{
                                        label: 'Total Employees',
                                        data: <?php echo json_encode($totalEmployees); ?>,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                        },
                                        title: {
                                            display: false,
                                            text: 'Employee Distribution by Role'
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>

                </div>
                <div>
                    <div class="text-center bg-white p-3">
                        <span>Vanny &copy; <?php echo $currentYear ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>

</html>