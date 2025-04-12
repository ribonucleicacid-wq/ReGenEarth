<?php
include '../auth/admin_only.php';

$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;
$role = $_SESSION['role'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - ReGenEarth</title>
    <link rel="shortcut icon" href="../uploads/logo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --moonstone: #57AFC3;
            --prussian-blue: #132F43;
            --silver: #CACFD3;
            --taupe-gray: #999A9C;
            --rich-black: #0B1A26;
        }

        .light-mode {
            --moonstone: #489fb5;
            --prussian-blue: #e9ecef;
            --silver: #212529;
            --taupe-gray: #6c757d;
            --rich-black: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: var(--rich-black);
            color: var(--silver);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            height: 100%;
            width: 260px;
            background: var(--prussian-blue);
            padding: 15px;
            z-index: 99;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
        }

        .sidebar.close {
            padding: 15px;
        }

        body.light-mode .sidebar {
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
        }



        .sidebar a,
        .menu-title,
        .submenu-item {
            color: var(--silver);
            text-decoration: none;
        }

        .logo {
            font-size: 25px;
            padding: 0 15px;
        }

        .menu-content {
            margin-top: 40px;
            height: calc(100% - 40px);
            overflow-y: auto;
        }

        .menu-content::-webkit-scrollbar {
            display: none;
        }

        .menu-items {
            list-style: none;
        }

        .submenu-active .menu-items {
            transform: translateX(-56%);
        }

        .submenu {
            position: absolute;
            right: -100%;
            width: 100%;
            height: 100%;
            background: var(--rich-black);
            display: none;
        }

        .show-submenu~.submenu {
            display: block;
        }

        .submenu .menu-title {
            cursor: pointer;
        }

        .item a,
        .submenu-item {
            display: block;
            padding: 10px;
            border-radius: 5px;
        }

        .item a:hover,
        .submenu-item:hover,
        .submenu .menu-title:hover {
            background: var(--moonstone);
        }

        /* Navbar */
        .navbar {
            position: fixed;
            left: 260px;
            width: calc(100% - 260px);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            background-color: var(--prussian-blue);
            color: var(--silver);
            z-index: 100;
            transition: all 0.5s ease;
        }

        .sidebar.close~.navbar {
            left: 0;
            width: 100%;
        }

        .navbar #sidebar-close {
            font-size: 24px;
            cursor: pointer;
        }

        .navbar .right-items {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-img {
            width: 40px;
            height: auto;
            object-fit: contain;
            border-radius: 50%;
            margin: 5px;
        }

        .user-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--moonstone);
            margin-right: 8px;
        }

        .name {
            font-weight: 700;
            font-size: 20px;
            color: var(--silver);
        }

        .btn-rounded {
            padding: 3px 10px;
            font-size: 0.9rem;
        }

        .dropdown-menu {
            background-color: var(--prussian-blue);
            border-color: var(--moonstone);
        }

        .dropdown-item {
            color: var(--silver);
        }

        .dropdown-item:hover {
            background-color: var(--moonstone);
            color: white;
        }

        /* Main */
        .main {
            position: relative;
            left: 260px;
            width: calc(100% - 260px);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--silver);
            transition: all 0.5s ease;
        }

        .sidebar.close~.main {
            left: 0;
            width: 100%;
        }

        .main h1 {
            font-size: 40px;
            color: var(--rich-black);
        }

        @media (max-width: 576px) {
            .user-img {
                width: 26px !important;
                height: 26px !important;
                margin-right: 0 !important;
            }

            .logo-img {
                display: none;
            }

            .name {
                font-size: 16px;
            }
        }

        .hamburger {
            width: 30px;
            height: 22px;
            position: relative;
            cursor: pointer;
            display: inline-block;
            z-index: 101;
        }

        .bar {
            position: absolute;
            height: 3px;
            width: 100%;
            background-color: var(--silver);
            transition: all 0.3s ease;
            left: 0;
            padding-left: 5px;
        }

        .bar1 {
            top: 0;
        }

        .bar2 {
            top: 9px;
        }

        .bar3 {
            top: 18px;
        }

        .hamburger.close .bar1 {
            transform: rotate(45deg);
            top: 9px;
        }

        .hamburger.close .bar2 {
            opacity: 0;
        }

        .hamburger.close .bar3 {
            transform: rotate(-45deg);
            top: 9px;
        }

        .sidebar .item a {
            display: flex;
            align-items: center;
            gap: 15px;
            white-space: nowrap;
        }

        .sidebar.close {
            width: 80px;
        }

        .sidebar.close .text,
        .sidebar.close .menu-title {
            display: none;
        }

        .sidebar.close .logo {
            font-size: 0;
        }

        .sidebar.close .logo::before {
            content: url("../uploads/logo.png");
            font-size: 25px;
        }

        .divider {
            height: 1px;
            background-color: var(--taupe-gray);
            margin-top: -5px;
            margin-bottom: -5px;
        }

        .menu-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--taupe-gray);
        }

        .btn-right {
            background-color: var(--moonstone);
            padding: 5px;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 700;
            color: var(--silver);
            border: right 5px;
            border: left 5px;
        }

        .navbar-brand:hover {
            color: var(--moonstone) !important;

        }

        .bar:hover {
            color: var(--moonstone) !important;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <a class="navbar-brand" href="dashboard.php">
            <img src="../uploads/logo.png" class="d-inline-block align-center logo-img" alt=""
                loading="lazy" />ReGenEarth
        </a>
        <div class="menu-content">
            <ul class="menu-items margin-right-10px">
                <li class="item">
                    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span class="text">Dashboard</span></a>
                </li>
                <hr>
                <div class="menu-title">Main</div>
                <li class="item">
                    <a href="user_management.php"><i class="fas fa-users"></i><span class="text">List of
                            Users</span></a>
                </li>
                <li class="item">
                    <a href="post_management.php"><i class="fas fa-list"></i><span class="text">List of
                            Posts</span></a>
                </li>
                <hr>
                <div class="menu-title">Management</div>
                <li class="item">
                    <a href="tips_management.php"><i class="fas fa-leaf"></i><span class="text">List of
                            Tips</span></a>
                </li>
                <li class="item">
                    <a href="admin_management.php"><i class="fas fa-user-shield"></i><span class="text">List of
                            Admins</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Top Navbar -->
    <nav class="navbar">
        <div class="hamburger" id="sidebar-toggle" onclick="toggleSidebar(this)">
            <div class="bar bar1"></div>
            <div class="bar bar2"></div>
            <div class="bar bar3"></div>
        </div>
        <div class="right-items">
            <!-- User Dropdown -->
            <div class="dropdown">
                <button
                    class="btn-right btn-rounded badge badge-light dropdown-toggle text-reset d-flex align-items-center gap-2"
                    type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="../uploads/members/sample profile.png" class="user-img" alt="User Image">
                    <span class="d-none d-sm-inline">
                        <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#"><i class="fa fa-user mr-2"></i>My Account</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0);" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
            <!-- Dark/Light Mode Toggle -->
            <button class="btn btn-sm btn-outline-secondary" id="modeToggle">
                <i class="fas fa-moon" id="modeIcon"></i>
            </button>
        </div>
    </nav>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle
        function toggleSidebar(el) {
            document.querySelector(".sidebar").classList.toggle("close");
            el.classList.toggle("open");
        }

        // Submenu toggle
        const menu = document.querySelector(".menu-content");
        const menuItems = document.querySelectorAll(".submenu-item");
        const subMenuTitles = document.querySelectorAll(".submenu .menu-title");

        menuItems.forEach((item, index) => {
            item.addEventListener("click", () => {
                menu.classList.add("submenu-active");
                item.classList.add("show-submenu");
                menuItems.forEach((item2, index2) => {
                    if (index !== index2) {
                        item2.classList.remove("show-submenu");
                    }
                });
            });
        });

        subMenuTitles.forEach((title) => {
            title.addEventListener("click", () => {
                menu.classList.remove("submenu-active");
            });
        });

        // Light/Dark mode
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById('modeToggle');
            const modeIcon = document.getElementById('modeIcon');
            const body = document.body;

            if (localStorage.getItem('mode') === 'light') {
                body.classList.add('light-mode');
                modeIcon.classList.remove('fa-moon');
                modeIcon.classList.add('fa-sun');
            }

            toggleBtn.addEventListener('click', function () {
                body.classList.toggle('light-mode');
                const isLight = body.classList.contains('light-mode');
                modeIcon.classList.toggle('fa-moon', !isLight);
                modeIcon.classList.toggle('fa-sun', isLight);
                localStorage.setItem('mode', isLight ? 'light' : 'dark');
            });
        });

        function confirmLogout() {
            const confirmed = confirm("Are you sure you want to log out?");
            if (confirmed) {
                window.location.href = '../config.php?action=logout';
            }
        }
    </script>
</body>

</html>