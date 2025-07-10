<?php
include "./controller.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee Information</title>
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
                    <div class="bg-white rounded p-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="bg-light p-5 rounded shadow w-50">
                                <div class="mb-3">
                                    <h2 class="text-center">Update Employee Information</h2>
                                    <p class="text-center">Please fill in to update the form below to register a new employee.</p>
                                </div>
                                <?php
                                if (isset($error_msg)) {
                                    echo '<div class="text-danger text-center" style="font-size: 12px;">' . $error_msg . '</div>';
                                }
                                ?>
                                <div class="mb-3">
                                    <label for="newEmp_id" class="form-label">Employee's ID</label>
                                    <input type="text" class="form-control" id="newEmp_id" name="newEmp_id" placeholder="EMP-001"
                                        value="<?= isset($edit_data['emp_id']) ? $edit_data['emp_id'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="newEmp_name" class="form-label">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="newEmp_name" name="newEmp_name" placeholder="Alex Sok"
                                        value="<?= isset($edit_data['full_name']) ? $edit_data['full_name'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="new_dob" class="form-label">Date of Birth<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="new_dob" name="new_dob" placeholder="example@gmail.com"
                                        value="<?= isset($edit_data['dob']) ? $edit_data['dob'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="new_gender">Gender<span class="text-danger">*</span></label>
                                    <select name="new_gender" id="new_gender" class="form-select">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="newEmp_mail" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="newEmp_mail" name="newEmp_mail" placeholder="example@gmail.com"
                                        value="<?= isset($edit_data['email']) ? $edit_data['email'] : '' ?>">

                                </div>
                                <div class="mb-3">
                                    <label for="newEmp_phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="newEmp_phone" name="newEmp_phone" placeholder="096XXXXXXXX"
                                        value="<?= isset($edit_data['phone']) ? $edit_data['phone'] : '' ?>">

                                </div>
                                <div class="mb-3">
                                    <label for="newDepartment">Department<span class="text-danger">*</span></label>
                                    <select name="newDepartment" id="newDepartment" class="form-select">
                                        <option value="">-- Select Department --</option>
                                        <?php while ($row = $queryDepartments->fetch_assoc()): ?>
                                            <option value="<?= $row['department_id'] ?>"
                                                <?= (isset($edit_data['department_id']) && $edit_data['department_id'] == $row['department_id']) ? 'selected' : '' ?>>
                                                <?= $row['department_name'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="new_position">Job Position<span class="text-danger">*</span></label>
                                    <select name="new_position" id="new_position" class="form-select">
                                        <option value="">-- Select Position --</option>
                                        <?php
                                        while ($row = $queryPositions->fetch_assoc()): ?>
                                            <option value="<?= $row['position_id'] ?>" <?= (isset($edit_data['position_id']) && $edit_data['position_id'] == $row['position_id']) ? 'selected' : '' ?>><?= $row['job_position'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="new_salary">Base Salary<span class="text-danger">*</span></label>
                                    <select name="new_salary" class="form-select">
                                        <option value="">-- Select Salary --</option>
                                        <?php
                                        while ($row = $querySalaries->fetch_assoc()): ?>
                                            <option value="<?= $row['salary_id'] ?>" <?= (isset($edit_data['salary_id']) && $edit_data['salary_id'] == $row['salary_id']) ? 'selected' : '' ?>><?= $row['base_salary'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="newRole_id">Select Role:</label>
                                    <select name="newRole_id" class="form-select">
                                        <option value="">-- Select Role --</option>
                                        <?php while ($row = $roles->fetch_assoc()): ?>
                                            <option value="<?= $row['role_id'] ?>" <?= (isset($edit_data['role_id']) && $edit_data['role_id']) ? 'selected' : '' ?>><?= $row['role_name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="newHire_date" class="form-label">Hire Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="newHire_date" name="newHire_date"
                                        value="<?= isset($edit_data['hire_date']) ? $edit_data['hire_date'] : '' ?>" placeholder="YYYY-MM-DD">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" name="btn_update">Save Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div>
                    <div class="text-center bg-white p-3">
                        <span>Vanny &copy; <?php echo $currentYear ?></span>
                    </div>
                </div>
            </div>
        </div>



        <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>