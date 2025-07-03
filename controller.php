<?php
include './config.php';

// === LOGIN ===
if (isset($_POST['btn_login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error_msg = "Please enter both username and password.";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
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

    $sql = "INSERT INTO jobs (`job_position`, `job_description`) VALUES ('$job_title', '$job_description')";
    if ($conn->query($sql) === TRUE) {
        $success_msg = "New job title created successfully.";
    } else {
        $error_msg = "Error: " . $conn->error;
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
