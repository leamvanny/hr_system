<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Salary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./custom.css" />
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
                    <div class="bg-white rounded p-3 py-5">
                        <div class="container d-flex justify-content-center align-items-center">
                            <div class="bg-light p-5 rounded shadow w-50">
                                <h2 class="text-center">Create Salary</h2>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="mb-3">
                                        <label for="salary" class="form-label">Salary<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="salary" name="salary" placeholder="Salary amount" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="salaryDescription" class="form-label">Salary Description</label>
                                        <textarea class="form-control" name="salaryDescription" id="salaryDescription" rows="3" placeholder="Leave the description..."></textarea>
                                    </div>

                                    <button type="submit" name="btn_create_salary" class="btn btn-primary">Submit</button>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="bg-white p-3 mt-3 rounded">
                        <table class="table table-striped table-bordered table-hover">
                            <h5 class="text-center fw-bold mb-3">List of Salary</h5>

                            <thead class="table-dark">
                                <th>
                                    <span>No.</span>
                                </th>
                                <th>
                                    <span>Salary Amount</span>
                                </th>
                                <th>
                                    <span>Salary Description</span>
                                </th>
                                <th>
                                    <span>Action</span>
                                </th>
                            </thead>
                            <tbody>
                                <?php
                                include "./controller.php";
                                $count = 1;
                                if ($querySalaries->num_rows > 0) {
                                    while ($row = $querySalaries->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td style='font-size: 14px;'>" . $count++ . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars($row['base_salary']) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars($row['salary_description']) . "</td>";
                                        echo "<td style='font-size: 14px;'><a href='edit_salary.php?id=" . $row['salary_id'] . "' class='text-primary'><i class='fa-solid fa-pen-to-square'></i></a>  <a href='delete_salary.php?id=" . $row['salary_id'] . "' class='text-danger'><i class='fa-solid fa-trash'></i></a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No salary records found.</td></tr>";
                                }

                                ?>
                            </tbody>
                        </table>
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