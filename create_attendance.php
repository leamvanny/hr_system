<?php
include "./controller.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Attendance</title>
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
                    <div class="bg-white rounded p-3 py-5">
                        <div class="container d-flex justify-content-center align-items-center">
                            <div class="bg-light p-5 rounded shadow w-50">
                                <h2 class="mb-3">Create Attendance</h2>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="mb-3">
                                        <label for="select_emp">Employee's Name<span class="text-danger">*</span></label>
                                        <select name="select_emp" id="select_emp" class="form-select" required>
                                            <option value="">-- Select a Specific Employee --</option>
                                            <?php while ($row = $queryEmployeeNames->fetch_assoc()): ?>
                                                <option value="<?= $row['full_name'] ?>"><?= $row['full_name'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="check_in" class="form-label">Check In<span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="check_in" name="check_in" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="check_out" class="form-label">Check Out<span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="check_out" name="check_out" required>
                                    </div>
                                    <button type="submit" name="btn_create_attendance" class="btn btn-primary">Submit</button>
                                </form>


                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-3 rounded mt-3">
                        <table class="table table-striped table-bordered table-hover">
                            <h5 class="text-center fw-bold">Attendance List</h5>
                            <thead class="table-dark">
                                <tr>
                                    <th><span>No.</span></th>
                                    <th><span>Name</span></th>
                                    <th><span>Check In</span></th>
                                    <th><span>Check Out</span></th>
                                    <th><span>Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $attendanceQuery = $conn->query("SELECT * FROM attendances");
                                if ($attendanceQuery->num_rows > 0) {
                                    $count = 1;
                                    while ($row = $attendanceQuery->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td style='font-size: 14px;'>" . $count++ . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars($row['emp_name']) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars(date("d M Y, h:i A", strtotime($row['check_in']))) . "</td>";
                                        echo "<td style='font-size: 14px;'>" . htmlspecialchars(date("d M Y, h:i A", strtotime($row['check_out']))) . "</td>";
                                        echo "<td style='font-size: 14px;'><a href='edit_attendance.php?id=" . $row['id'] . "' class='text-primary'><i class='fa-solid fa-pen-to-square'></i></a>  <a href='delete_attendance.php?id=" . $row['id'] . "' class='text-danger'><i class='fa-solid fa-trash'></i></a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center' style='font-size: 14px;'>No attendance records found.</td></tr>";
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