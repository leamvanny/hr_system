<?php
include './config.php';

// === LOGIN ===

if (isset($_POST['btn_login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error_msg = "Please enter both username and password.";
    } else {
        // Escape inputs to avoid SQL injection
        $username_safe = $conn->real_escape_string($username);
        $password_safe = $conn->real_escape_string($password);
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: home.php");
            exit();
        } else {
            $error_msg = "Invalid username or password.";
        }
    }
}

// === Menu Active ===
if (!function_exists('isActive')) {
    function isActive($page)
    {
        return basename($_SERVER['PHP_SELF']) == $page ? 'bg-menu-item-active' : '';
    }
}
// === Query all Data ===
$roles = $conn->query("SELECT * FROM roles");
$queryEmployeeNames = $conn->query("SELECT full_name FROM employees");
$queryJopPositions = $conn->query("SELECT * FROM jobs");

// === Query Salaries ===
$querySalaries = $conn->query("SELECT * FROM salaries");
$querySalariesJoin = "SELECT e.*, r.role_name, s.base_salary 
        FROM employees e
        JOIN roles r ON e.role_id = r.role_id
        JOIN salaries s ON e.salary_id = s.salary_id";
$querySalariesJoinResult = $conn->query($querySalariesJoin);

// === Query Departments ===
$queryDepartments = $conn->query("SELECT * FROM departments");
$queryDepartmentsJoin = "SELECT e.*, d.department_name
        FROM employees e
        JOIN departments d ON e.department_id = d.department_id";
$queryDepartmentsJoinResult = $conn->query($queryDepartmentsJoin);

// === Query Job Positions ===
$queryPositions = $conn->query("SELECT * FROM jobs");
$queryJopPositionsJoin = "SELECT e.*, j.job_position
        FROM employees e
        JOIN jobs j ON e.position_id = j.position_id";




// === Employee Registration ===
$emp_id = $emp_name = $emp_mail = $emp_phone = $hire_date = $job_position = $department = $salary = $check_in = $check_out = $dob = "";
$emp_name_err = $emp_mail_err = $emp_phone_err = $hire_date_err = "";
$success_msg = $error_msg = "";



if (isset($_POST['btn_submit'])) {
    $emp_id = trim($_POST['emp_id']);
    $emp_name = trim($_POST['emp_name']);
    $emp_gender = trim($_POST['gender']);
    $dob = trim($_POST['dob']);
    $emp_mail = trim($_POST['emp_mail']);
    $emp_phone = trim($_POST['emp_phone']);
    $hire_date = trim($_POST['hire_date']);
    $position_id = trim($_POST['position']);
    $department_id = trim($_POST['department']);
    $salary_id = trim($_POST['salary']);
    $role_id = $_POST['role_id'];
    // $check_in = trim($_POST['check_in']);
    // $check_out = trim($_POST['check_out']);

    // === VALIDATIONS ===
    $check_email_sql = "SELECT id FROM employees WHERE email = '$emp_mail'";
    $check_email_result = $conn->query($check_email_sql);
    if ($check_email_result->num_rows > 0) {
        $emp_mail_err = "This email address is already registered.";
    }
    if (empty($emp_name)) {
        $emp_name_err = "Please enter a name.";
    }

    if (empty($emp_mail)) {
        $emp_mail_err = "Please enter an email.";
    } elseif (!filter_var($emp_mail, FILTER_VALIDATE_EMAIL)) {
        $emp_mail_err = "Please enter a valid email address.";
    }

    if (empty($emp_phone)) {
        $emp_phone_err = "Please enter a phone number.";
    } elseif (!preg_match('/^[0-9]{8,15}$/', $emp_phone)) {
        $emp_phone_err = "Phone number must be between 8 to 15 digits.";
    }

    if (empty($hire_date)) {
        $hire_date_err = "Please enter a hire date.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $hire_date)) {
        $hire_date_err = "Invalid date format.";
    } elseif (strtotime($hire_date) > time()) {
        $hire_date_err = "Hire date cannot be in the future.";
    }

    // === INSERT DATA ===
    if (empty($emp_name_err) && empty($emp_mail_err) && empty($emp_phone_err) && empty($hire_date_err)) {
        $sql = "INSERT INTO employees (`emp_id`, `full_name`, `dob`, `gender`, `email`, `phone`, `hire_date`, `department_id`, `position_id`, `salary_id`, `role_id`) 
        VALUES ('$emp_id', '$emp_name', '$dob', '$emp_gender', '$emp_mail', '$emp_phone', '$hire_date', '$department_id', '$position_id', '$salary_id', '$role_id')";

        if ($conn->query($sql) === TRUE) {
            $success_msg = "New department created successfully.";
        } else {
            $error_msg = "Error: " . $conn->error;
        }
    }
}


// === Department ===
$department_code = $department_name = $department_color_code = "";
if (isset($_POST['btn_create_dep'])) {
    $department_code = $_POST['department_code'];
    $department_name = $_POST['department_name'];
    $department_color_code = $_POST['department_color_code'];

    $sql = "INSERT INTO departments (`department_code`, `department_name`, `department_color_code`) VALUES ('$department_code', '$department_name', '$department_color_code')";
    if ($conn->query($sql) === TRUE) {
        $success_msg = "New department created successfully.";
    } else {
        $error_msg = "Error: " . $conn->error;
    }
}

//=== Attendance ===
$select_emp = $check_in = $check_out = "";
if (isset($_POST['btn_create_attendance'])) {
    $select_emp = $_POST['select_emp'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $today = date('Y-m-d', strtotime($check_in));

    $check = $conn->query("SELECT * FROM attendances WHERE emp_name = '$select_emp' AND DATE(check_in) = '$today'");

    if ($check->num_rows === 0) {
        $sql = "INSERT INTO attendances (`emp_name`, `check_in`, `check_out`) VALUES ('$select_emp', '$check_in', '$check_out')";
        if ($conn->query($sql) === TRUE) {
            $success_msg = "New department created successfully.";
        } else {
            $error_msg = "Error: " . $conn->error;
        }
    } else {
        $error_msg = "This employee already checked in today.";
    }
}

// Fetch all attendance records
$attendance_records = [];
$sql = "SELECT * FROM attendances";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attendance_records[] = $row;
    }
} else {
    $error_msg = "No attendance records found.";
}

//==== Job Title ====
$job_title = $job_description = "";

if (isset($_POST['btn_create_job_title'])) {
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];

    $checkSql = "SELECT * FROM jobs WHERE job_position = '$job_title'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult && $checkResult->num_rows > 0) {
        $error_msg = "Job title already exists.";
    } else {
        $sql = "INSERT INTO jobs (`job_position`, `job_description`) VALUES ('$job_title', '$job_description')";
        if ($conn->query($sql) === TRUE) {
            $success_msg = "New job title created successfully.";
        } else {
            $error_msg = "Error: " . $conn->error;
        }
    }
}


//=== Create Salary ===
$salary = "";
if (isset($_POST['btn_create_salary'])) {
    $salary = $_POST['salary'];
    $salaryDescription = $_POST['salaryDescription'];

    $sql = "INSERT INTO salaries (`base_salary`, `salary_description`) VALUES ('$salary', '$salaryDescription')";
    if ($conn->query($sql) === TRUE) {
        $success_msg = "New job title created successfully.";
    } else {
        $error_msg = "Error: " . $conn->error;
    }
}

//=== Query Data Count ===
if (!function_exists('getCount')) {
    function getCount($table, $conn)
    {
        $sql = "SELECT COUNT(*) as count FROM $table";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['count'];
        }
        return 0;
    }
}

if (!function_exists('formatSalaryShort')) {
    function formatSalaryShort($number)
    {
        if ($number >= 1000000) {
            return '$' . round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return '$' . round($number / 1000, 1) . 'K';
        } else {
            return '$' . number_format($number);
        }
    }
}

// === Chart.js Data Preparation ===


$selectedYear = isset($_GET['filterTotalEmployees']) ? $_GET['filterTotalEmployees'] : date('Y');
$months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];

$maleData = array_fill_keys($months, 0);
$femaleData = array_fill_keys($months, 0);

$currentYear = date("Y");

$queryTotalEmployees = "SELECT 
            DATE_FORMAT(hire_date, '%M') as month_name,
            gender,
            COUNT(*) as total
        FROM employees
        WHERE YEAR(hire_date) = '$selectedYear'
        GROUP BY MONTH(hire_date), gender";

$result = $conn->query($queryTotalEmployees);
while ($row = $result->fetch_assoc()) {
    $month = $row['month_name'];
    $gender = strtolower($row['gender']);

    if ($gender === 'male') {
        $maleData[$month] = $row['total'];
    } elseif ($gender === 'female') {
        $femaleData[$month] = $row['total'];
    }
}







$selectedYearPie = isset($_GET['filterTotalEmployeesRole']) ? $_GET['filterTotalEmployeesRole'] : date('Y');
$queryRole = "SELECT e.role_id, r.role_name, COUNT(*) as total
              FROM employees e
              JOIN roles r ON e.role_id = r.role_id
              WHERE YEAR(e.hire_date) = '$selectedYearPie'
              GROUP BY e.role_id, r.role_name";
$resultRole = $conn->query($queryRole);

// Arrays for chart
$roleNames = [];
$totalEmployees = [];

// Separate role totals
$adminCount = 0;
$managerCount = 0;
$employeeCount = 0;

while ($row = $resultRole->fetch_assoc()) {
    $roleName = strtolower($row['role_name']); // Convert to lowercase to avoid case issues
    $total = $row['total'];

    // Store for chart
    $roleNames[] = $row['role_name'];
    $totalEmployees[] = $total;

    // Separate counts
    if ($roleName === 'admin office') {
        $adminCount = $total;
    } elseif ($roleName === 'manager') {
        $managerCount = $total;
    } else {
        $employeeCount += $total; // Count any other roles as default employee
    }
}





// === Update and Delete Employee ===
$edit_id = "";
$edit_data = [];

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM employees WHERE emp_id='$edit_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $edit_data = mysqli_fetch_assoc($result);
    }
}

$newEmp_id = $newEmp_name = $newEmp_mail = $newEmp_phone = $newHire_date = $new_position = $newDepartment = "";
$new_salary = null;
if (isset($_POST['btn_update'])) {
    $newEmp_id = $_POST['newEmp_id'];
    $newEmp_name = trim($_POST['newEmp_name']);
    $newEmp_mail = trim($_POST['newEmp_mail']);
    $newEmp_phone = trim($_POST['newEmp_phone']);
    $newHire_date = trim($_POST['newHire_date']);
    $new_position = $_POST['new_position'];
    $newDepartment = $_POST['newDepartment'];
    $new_salary = $_POST['new_salary'];
    $newRole_id = $_POST['newRole_id'];

    // === VALIDATIONS ===
    if (empty($newEmp_name)) {
        $error_msg = "Please enter a name.";
    } elseif (empty($newEmp_mail)) {
        $error_msg = "Please enter an email.";
    } elseif (!filter_var($newEmp_mail, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Please enter a valid email address.";
    } elseif (empty($newEmp_phone)) {
        $error_msg = "Please enter a phone number.";
    } elseif (!preg_match('/^[0-9]{8,15}$/', $newEmp_phone)) {
        $error_msg = "Phone number must be between 8 to 15 digits.";
    } elseif (empty($newHire_date)) {
        $error_msg = "Please enter a hire date.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $newHire_date)) {
        $error_msg = "Invalid date format.";
    } elseif (strtotime($newHire_date) > time()) {
        $error_msg = "Hire date cannot be in the future.";
    }

    // === UPDATE DATA ===
    if (empty($error_msg)) {
        $sqlUpdate = "UPDATE employees SET 
            full_name='$newEmp_name', 
            email='$newEmp_mail', 
            phone='$newEmp_phone', 
            hire_date='$newHire_date', 
            position_id='$new_position', 
            department_id='$newDepartment', 
            salary_id='$new_salary',
            role_id='$newRole_id'
            WHERE emp_id='$newEmp_id'";

        if ($conn->query($sqlUpdate) === TRUE) {
            header("Location: create_newEmp.php");
            exit();
        } else {
            $error_msg = "Error updating record: " . $conn->error;
        }
    }
}

// === Delete Employee ===
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sqlDelete = "DELETE FROM employees WHERE emp_id='$delete_id'";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: create_newEmp.php");
        exit();
    } else {
        $error_msg = "Error deleting record: " . $conn->error;
    }
}

if (isset($_POST['btn_delete'])) {
    $delete_id = $_POST['delete_id'];
    $sqlDelete = "DELETE FROM employees WHERE emp_id='$delete_id'";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: create_newEmp.php");
        exit();
    } else {
        $error_msg = "Error deleting record: " . $conn->error;
    }
}




// === Update and Delete Department ===
$edit_department_id = "";
$edit_department_data = [];
if (isset($_GET['edit_department_id'])) {
    $edit_department_id = $_GET['edit_department_id'];
    $sql = "SELECT * FROM departments WHERE department_id='$edit_department_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $edit_department_data = mysqli_fetch_assoc($result);
    }
}
$newDepartment_code = $newDepartment_name = $newDepartment_color_code = "";
if (isset($_POST['btn_updateDepartment'])) {
    $newDepartment_code = $_POST['newDepartment_code'];
    $newDepartment_name = trim($_POST['newDepartment_name']);
    $newDepartment_color_code = $_POST['newDepartment_color_code'];
    $newDepartment_id = $_POST['newDepartment_id'];
    // === VALIDATIONS ===
    if (empty($newDepartment_code)) {
        $error_msg = "Please enter a department code.";
    } elseif (empty($newDepartment_name)) {
        $error_msg = "Please enter a department name.";
    } elseif (empty($newDepartment_color_code)) {
        $error_msg = "Please select a color code.";
    } elseif (!preg_match('/^[A-Z]{2}-\d{2}$/', $newDepartment_code)) {
        $error_msg = "Department code must be in the format 'XX-YY'.";
    }

    if (!empty($newDepartment_code) && !empty($newDepartment_name) && !empty($newDepartment_color_code)) {
        // === UPDATE DATA ===
        $sqlUpdate = "UPDATE departments SET 
            department_code='$newDepartment_code', 
            department_name='$newDepartment_name', 
            department_color_code='$newDepartment_color_code' 
            WHERE department_id='$newDepartment_id'";

        if ($conn->query($sqlUpdate) === TRUE) {
            header("Location: create_department.php");
            exit();
        } else {
            $error_msg = "Error updating record: " . $conn->error;
        }
    }
}
// === Delete Department ===
if (isset($_GET['deleteDeprtment_id'])) {
    $deleteDeprtment_id = $_GET['deleteDeprtment_id'];
    $sqlDelete = "DELETE FROM departments WHERE department_code='$deleteDeprtment_id'";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: create_department.php");
        exit();
    } else {
        $error_msg = "Error deleting record: " . $conn->error;
    }
}

if (isset($_POST['btn_deleteDepartment'])) {
    $deleteDeprtment_id = $_POST['deleteDeprtment_id'];
    $sqlDelete = "DELETE FROM departments WHERE department_id='$deleteDeprtment_id'";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: create_department.php");
        exit();
    } else {
        $error_msg = "Error deleting record: " . $conn->error;
    }
}


// === Update and Delete Attendance ===

$edit_attendance_id = "";
$edit_attendance_data = [];
if (isset($_GET['edit'])) {
    $edit_attendance_id = $_GET['edit'];
    $sql = "SELECT * FROM attendances WHERE id='$edit_attendance_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $edit_attendance_data = mysqli_fetch_assoc($result);
    }
}
$newAttendance_emp_name = $newAttendance_check_in = $newAttendance_check_out = "";
if (isset($_POST['btn_updateAttendance'])) {
    $newAttendance_emp_name = $_POST['newSelect_emp'];
    $newAttendance_check_in = $_POST['newCheck_in'];
    $newAttendance_check_out = $_POST['newCheck_out'];
    $newAttendance_id = $_POST['newAttendance_id'];
    // === VALIDATIONS ===
    if (empty($newAttendance_emp_name)) {
        $error_msg = "Please select an employee.";
    } elseif (empty($newAttendance_check_in)) {
        $error_msg = "Please enter a check-in time.";
    } elseif (empty($newAttendance_check_out)) {
        $error_msg = "Please enter a check-out time.";
    } elseif (strtotime($newAttendance_check_in) >= strtotime($newAttendance_check_out)) {
        $error_msg = "Check-out time must be after check-in time.";
    }

    if (!empty($newAttendance_emp_name) && !empty($newAttendance_check_in) && !empty($newAttendance_check_out)) {
        // === UPDATE DATA ===
        $sqlUpdate = "UPDATE attendances SET 
            emp_name='$newAttendance_emp_name', 
            check_in='$newAttendance_check_in', 
            check_out='$newAttendance_check_out' 
            WHERE id='$newAttendance_id'";

        if ($conn->query($sqlUpdate) === TRUE) {
            header("Location: create_attendance.php");
            exit();
        } else {
            $error_msg = "Error updating record: " . $conn->error;
        }
    }
}

// === Delete Attendance ===

if (isset($_POST['btn_deleteAttendance'])) {
    $deleteAttendance_id = $_POST['deleteAttendance_id'];
    $sqlDelete = "DELETE FROM attendances WHERE id='$deleteAttendance_id'";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: create_attendance.php");
        exit();
    } else {
        $error_msg = "Error deleting record: " . $conn->error;
    }
}


// === Update and Delete Job Title ===
$editJobTitle_id = "";
$editJobTitle_data = [];
if (isset($_GET['editJobTitle'])) {
    $editJobTitle_id = $_GET['editJobTitle'];
    $sql = "SELECT * FROM jobs WHERE position_id='$editJobTitle_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $editJobTitle_data = mysqli_fetch_assoc($result);
    }
}
$newJob_title = $newJob_description = "";
if (isset($_POST['btn_UpdateJob'])) {
    $newJob_title = $_POST['newJob_title'];
    $newJob_description = $_POST['newJob_description'];
    $newJobTitle_id = $_POST['newJobTitle_id'];
    // === VALIDATIONS ===
    if (empty($newJob_title)) {
        $error_msg = "Please enter a job title.";
    } elseif (empty($newJob_description)) {
        $error_msg = "Please enter a job description.";
    }

    if (!empty($newJob_title) && !empty($newJob_description)) {
        // === UPDATE DATA ===
        $sqlUpdate = "UPDATE jobs SET 
            job_position='$newJob_title', 
            job_description='$newJob_description' 
            WHERE position_id='$newJobTitle_id'";

        if ($conn->query($sqlUpdate) === TRUE) {
            header("Location: create_job_title.php");
            exit();
        } else {
            $error_msg = "Error updating record: " . $conn->error;
        }
    }
}

// === Delete Job Title ===
if (isset($_POST['btn_deleteJobTitle'])) {
    $deleteJobTitle_id = $_POST['deleteJobTitle_id'];
    $sqlDelete = "DELETE FROM jobs WHERE position_id='$deleteJobTitle_id'";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: create_job_title.php");
        exit();
    } else {
        $error_msg = "Error deleting record: " . $conn->error;
    }
}


// === Update and Delete Salary ===
$editSalary_id = "";
$editSalary_data = [];
if (isset($_GET['edit_salary'])) {
    $editSalary_id = $_GET['edit_salary'];
    $sql = "SELECT * FROM salaries WHERE salary_id='$editSalary_id'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $editSalary_data = mysqli_fetch_assoc($result);
    }
}
$newSalary = $newSalaryDescription = "";
if (isset($_POST['btn_updateSalary'])) {
    $newSalary = $_POST['newSalary'];
    $newSalaryDescription = $_POST['newSalaryDescription'];
    $newSalary_id = $_POST['newSalary_id'];
    // === VALIDATIONS ===
    if (empty($newSalary)) {
        $error_msg = "Please enter a salary amount.";
    } elseif (!is_numeric($newSalary) || $newSalary <= 0) {
        $error_msg = "Salary must be a positive number.";
    }

    if (!empty($newSalary)) {
        // === UPDATE DATA ===
        $sqlUpdate = "UPDATE salaries SET 
            base_salary='$newSalary', 
            salary_description='$newSalaryDescription' 
            WHERE salary_id='$newSalary_id'";

        if ($conn->query($sqlUpdate) === TRUE) {
            header("Location: create_salaries.php");
            exit();
        } else {
            $error_msg = "Error updating record: " . $conn->error;
        }
    }
}

// === Delete Salary ===
if (isset($_POST['btn_deleteSalary'])) {
    $deleteSalary_id = $_POST['deleteSalary_id'];
    $sqlDelete = "DELETE FROM salaries WHERE salary_id='$deleteSalary_id'";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: create_salaries.php");
        exit();
    } else {
        $error_msg = "Error deleting record: " . $conn->error;
    }
}
