<?php
include "./controller.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
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
            <div class="col-md-2 bg-primary text-white">
                <div class="sticky-top">
                    <?php

                    include "./menu.php";
                    ?>
                </div>
            </div>
            <div class="col-md-10 p-0">
                <div class="sticky-top">
                    <?php
                    include "./navBar.php";
                    ?>
                </div>
                <div class="p-3">
                    <div class="bg-white rounded p-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="bg-light p-5 rounded shadow w-50">
                                <div class="mb-3">
                                    <h2 class="text-center">Employee Registration</h2>
                                    <p class="text-center">Please fill in the form below to register a new employee.</p>
                                </div>
                                <div class="mb-3">
                                    <label for="emp_id" class="form-label">Employee's ID</label>
                                    <input type="text" class="form-control" id="emp_id" name="emp_id" placeholder="EMP-001">
                                </div>
                                <div class="mb-3">
                                    <label for="emp_name" class="form-label">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="emp_name" name="emp_name" placeholder="Alex Sok" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dob" name="dob" placeholder="example@gmail.com" required>
                                </div>
                                <div class="mb-3">
                                    <label for="gender">Gender<span class="text-danger">*</span></label>
                                    <select name="gender" id="gender" class="form-select" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="emp_mail" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="emp_mail" name="emp_mail" placeholder="example@gmail.com" required>
                                </div>
                                <div class="mb-3">
                                    <label for="emp_phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="emp_phone" name="emp_phone" placeholder="096XXXXXXXX" required>
                                </div>
                                <div class="mb-3">
                                    <label for="department">Department<span class="text-danger">*</span></label>
                                    <select name="department" id="department" class="form-select" required>
                                        <option value="">-- Select Department --</option>
                                        <?php
                                        // Temporarily add this for debugging
                                        var_dump($queryDepartments);
                                        while ($row = $queryDepartments->fetch_assoc()): ?>
                                            <option value="<?= $row['department_id'] ?>"><?= $row['department_name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="position">Job Position<span class="text-danger">*</span></label>
                                    <select name="position" id="position" class="form-select" required>
                                        <option value="">-- Select Position --</option>
                                        <?php
                                        // Temporarily add this for debugging
                                        var_dump($queryPositions);
                                        while ($row = $queryPositions->fetch_assoc()): ?>
                                            <option value="<?= $row['position_id'] ?>"><?= $row['job_position'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="salary">Base Salary<span class="text-danger">*</span></label>
                                    <select name="salary" class="form-select" required>
                                        <option value="">-- Select Salary --</option>
                                        <?php
                                        // Temporarily add this for debugging
                                        var_dump($querySalaries);
                                        while ($row = $querySalaries->fetch_assoc()): ?>
                                            <option value="<?= $row['salary_id'] ?>"><?= $row['base_salary'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="role_id">Select Role:</label>
                                    <select name="role_id" class="form-select" required>
                                        <option value="">-- Select Role --</option>
                                        <?php while ($row = $roles->fetch_assoc()): ?>
                                            <option value="<?= $row['role_id'] ?>"><?= $row['role_name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="hire_date" class="form-label">Hire Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="hire_date" name="hire_date" required>
                                </div>
                                <div>
                                    <button class="btn btn-primary" name="btn_submit">Submit</button>
                                    <button class="btn btn-danger" type="reset" name="btn_reset">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="bg-white p-3 rounded mt-4">
                        <h5 class="text-center fw-bold">Employee List</h5>
                        <p class="text-center">Below is the list of registered employees.</p>

                        <table class="table table-striped table-bordered table-hover mt-4">
                            <thead class="table-dark">
                                <tr>
                                    <th><span style="font-size: 14px;" class="fw-bold">ID</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Name</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Date of Birth</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Gender</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Email</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Phone</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Department</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Job Position</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Salary</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Role</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Hire Date</span></th>
                                    <th><span style="font-size: 14px;" class="fw-bold">Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqlData = "SELECT 
                                            e.*, 
                                            r.role_name, 
                                            s.base_salary,
                                            s.salary_description,
                                            j.job_position,
                                            d.department_name
                                        FROM employees e 
                                        JOIN roles r ON e.role_id = r.role_id
                                        JOIN salaries s ON e.salary_id = s.salary_id
                                        JOIN jobs j ON e.position_id = j.position_id
                                        JOIN departments d ON e.department_id = d.department_id"; // No semicolon at the end here for PHP string

                                $result = $conn->query($sqlData);
                                $count = 1;

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td style='font-size: 14px;'>" . $count++ . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars($row['full_name']) . "</br>" . "<span class='text-secondary' style='font-size: 12px;'>" . htmlspecialchars($row['emp_id']) . "</span>" . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars(date("d M Y", strtotime($row['dob']))) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars($row['gender']) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars($row['phone']) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars($row['department_name']) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars($row['job_position']) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars(number_format($row['base_salary'], 2)) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars($row['role_name']) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars(date("d M Y", strtotime($row['hire_date']))) . "</td>";
                                        echo "<td style='font-size: 14px;'><a href='edit_employee.php?id=" . $row['id'] . "' class='text-primary'><i class='fa-solid fa-pen-to-square'></i></a>  <a href='delete_employee.php?id=" . $row['id'] . "' class='text-danger'><i class='fa-solid fa-trash'></i></a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='11' class='text-center'>No employees found.</td></tr>";
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