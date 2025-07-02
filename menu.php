<?php
include "./controller.php";


echo '
<nav class="navbar bg-primary">
            <div class="container d-flex flex-col justify-content-between py-3">
                <div class="text-white">
                    <h3 class="mb-4">HR System</h3>
                    <p class="mb-0">Human Resource Management System</p>
                    <hr />
                </div>
                
                            
                                <ul class="navbar-nav w-100">
                                    <li class="nav-item mb-1"> <a href="./home.php" class="nav-link ' . (isActive('home.php') ? 'bg-menu-item-active' : 'bg-menu-item') . '"><i class="fa-brands fa-microsoft"></i><span class="px-2">Dashboard</span></a></li>
                                    <li class="nav-item mb-1"><a href="./create_newEmp.php" class="nav-link ' . (isActive('create_newEmp.php') ? 'bg-menu-item-active' : 'bg-menu-item') . '"><i class="fa-solid fa-users" style="font-size: 12.5px;"></i><span class="px-2">Employees</span></a></li>
                                    <li class="nav-item mb-1"><a href="./create_department.php" class="nav-link bg-menu-item ' . (isActive('create_department.php') ? 'bg-menu-item-active' : 'bg-menu-item') . '"><i class="fa-solid fa-list"></i><span class="px-2">Department</span></a></li>
                                    <li class="nav-item mb-1"><a href="./create_attendance.php" class="nav-link bg-menu-item ' . (isActive('create_attendance.php') ? 'bg-menu-item-active' : 'bg-menu-item') . '"><i class="fa-solid fa-user-clock" style="font-size: 13px;"></i><span class="px-2">Attendance</span></a></li>
                                    <li class="nav-item mb-1"><a href="./create_job_title.php" class="nav-link bg-menu-item ' . (isActive('create_job_title.php') ? 'bg-menu-item-active' : 'bg-menu-item') . '"><i class="fa-solid fa-suitcase"></i><span class="px-2">Job Position</span></a></li>
                                    <li class="nav-item mb-1"><a href="./create_salaries.php" class="nav-link bg-menu-item ' . (isActive('create_salaries.php') ? 'bg-menu-item-active' : 'bg-menu-item') . '"><i class="fa-solid fa-money-check-dollar"></i><span class="px-2">Salary</span></a></li>
                                    <li class="nav-item" style="margin-top: 14rem;"> <a href="./login.php" class="nav-link bg-menu-item ' . (isActive('login.php') ? 'bg-menu-item-active' : 'bg-menu-item') . '"><i class="fa-solid fa-right-from-bracket"></i><span class="px-2">Log out</span></a></li>
                                </ul>


                  

            </div>
        </nav>';
