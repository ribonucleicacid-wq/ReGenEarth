<?php
session_start();
include "inc/navigation.php";
include '../../auth/staff_only.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - ReGenEarth</title> <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="../../uploads/logo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
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

        .dashboard-container {
            padding: 2rem;
        }

        .dashboard-header {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .card {
            border-radius: 12px;
            padding: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s;
            height: 120px;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .card .icon-container {
            font-size: 1.5rem;
            margin-left: auto;
        }

        .card .count {
            font-size: 2rem;
            font-weight: bold;
        }

        .card .label {
            font-size: 1rem;
        }

        .climate {
            background: #4caf50;
        }

        .pollution {
            background: #2196f3;
        }

        .biodiversity {
            background: #ff9800;
        }

        .users {
            background: #9c27b0;
        }

        .admins {
            background: #f44336;
        }

        .main {
            background-color: var(--prussian-blue);
            display: flex;
            flex-direction: column;
        }

        .dashboard {
            background-color: var(--rich-black);
            flex-grow: 100%;
            overflow: hidden;
        }

        .main {
            padding: 10px 20px;
            height: 89vh;
            background-color: var(--prussian-blue);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .container-fluid {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        #dashboard-cards h2 {
            margin-bottom: 1rem;
            margin-top: 0.5rem;
        }

        .mb-4 {
            font-size: 25px;
            font-weight: 600;
            color: var(--silver);
        }

        .mb-5 {
            font-size: 30px;
            font-weight: 800;
            color: var(--silver);
            align-items: flex-start;
            flex-direction: column;
            display: flex;
        }

        hr {
            border: 1px solid var(--silver);
        }
    </style>
</head>

<body class="dashboard">
    <div class="main">
        <h2 class="mb-5">Management Dashboard | ReGenEarth</h2>
        <div class="container-fluid p-4" id="dashboard-cards">
            <h2 class="mb-4">Welcome back, Admin!</h2>

            <!-- Top Section: Users and Admins -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card text-white bg-primary shadow p-3">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Users</h5>
                                <h2 id="userCount">0</h2>
                            </div>
                            <div class="icon-container">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card text-white bg-danger shadow p-3">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Admins</h5>
                                <h2 id="adminCount">0</h2>
                            </div>
                            <div class="icon-container">
                                <i class="fas fa-user-shield fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Posts by Category -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-white bg-success shadow p-3">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Climate Change</h5>
                                <h2 id="climateCount">0</h2>
                            </div>
                            <div class="icon-container">
                                <i class="fas fa-globe-americas fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-info shadow p-3">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Pollution</h5>
                                <h2 id="pollutionCount">0</h2>
                            </div>
                            <div class="icon-container">
                                <i class="fas fa-smog fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-warning shadow p-3">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Biodiversity Loss</h5>
                                <h2 id="biodiversityCount">0</h2>
                            </div>
                            <div class="icon-container">
                                <i class="fas fa-leaf fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Simulated data (you would fetch from your backend via AJAX or embed via PHP)
        const dashboardData = {
            users: 1240,
            admins: 12,
            posts: {
                climate: 198,
                pollution: 132,
                biodiversity: 89
            }
        };

        // Populate numbers
        document.getElementById("userCount").textContent = dashboardData.users;
        document.getElementById("adminCount").textContent = dashboardData.admins;
        document.getElementById("climateCount").textContent = dashboardData.posts.climate;
        document.getElementById("pollutionCount").textContent = dashboardData.posts.pollution;
        document.getElementById("biodiversityCount").textContent = dashboardData.posts.biodiversity;
    </script>

</body>

</html>