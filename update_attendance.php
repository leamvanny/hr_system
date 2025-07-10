<?php
include "./controller.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Attendance</title>
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
                                <h2 class="mb-3">Update Employee Attendance</h2>
                                <?php
                                if (isset($error_msg)) {
                                    echo '<div class="text-danger text-center" style="font-size: 12px;">' . $error_msg . '</div>';
                                }
                                ?>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <input type="hidden" name="newAttendance_id" id="newAttendance_id"
                                        value="<?= isset($edit_attendance_data['id']) ? $edit_attendance_data['id'] : '' ?>">
                                    <div class="mb-3">
                                        <label for="newSelect_emp" class="form-label">Employee's Name<span class="text-danger">*</span></label>
                                        <select name="newSelect_emp" id="newSelect_emp" class="form-select">
                                            <option value="">-- Select a Specific Employee --</option>
                                            <?php while ($row = $queryEmployeeNames->fetch_assoc()): ?>
                                                <option value="<?= $row['full_name'] ?>" <?= (isset($edit_attendance_data['emp_name']) && $edit_attendance_data['emp_name'] == $row['full_name']) ? 'selected' : '' ?>>
                                                    <?= $row['full_name'] ?>
                                                </option>
                                            <?php endwhile; ?>

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="newCheck_in" class="form-label">Check In<span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="newCheck_in" name="newCheck_in"
                                            value="<?= isset($edit_attendance_data['check_in']) ? $edit_attendance_data['check_in'] : '' ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="newCheck_out" class="form-label">Check Out<span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="newCheck_out" name="newCheck_out"
                                            value="<?= isset($edit_attendance_data['check_out']) ? $edit_attendance_data['check_out'] : '' ?>">
                                    </div>
                                    <button type="submit" name="btn_updateAttendance" class="btn btn-primary">Submit</button>
                                </form>


                            </div>
                        </div>
                    </div>

                </div>
                <div>
                    <div class="text-center bg-white p-3 mt-5">
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