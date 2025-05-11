<?php
session_start();
$_SESSION['just_logged_in'] = true;

require_once '../src/db_connection.php';
include "inc/navigation.php";
include '../auth/admin_only.php';

$database = new Database();
$conn = $database->getConnection();

$userCount = 0;
$adminCount = 0;

try {
    $stmt = $conn->prepare("CALL CountUsers()");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $userCount = $result['user_count'];
        $adminCount = $result['admin_count'];
    }
    $stmt->closeCursor();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$climateChangeCount = 0;
$pollutionCount = 0;
$biodiversityLossCount = 0;

try {
    $stmt = $conn->prepare("CALL GetPostCountsPerTopic()");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $climateChangeCount = $result['Climate Change Posts'];
        $pollutionCount = $result['Pollution Posts'];
        $biodiversityLossCount = $result['Biodiversity Loss Posts'];
    }
    $stmt->closeCursor();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - ReGenEarth</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="uploads/logo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --moonstone: #57AFC3;
            --prussian-blue: #132F43;
            --silver: #CACFD3;
            --taupe-gray: #999A9C;
            --rich-black: #0B1A26;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        .main {
            position: relative;
            background-color: var(--prussian-blue);
            display: flex;
            flex-direction: column;
            padding: 10px 20px;
            padding-top: 70px;
            height: 100%;
        }

        .dashboard {
            background-color: var(--rich-black);
            flex-grow: 1;
            overflow: auto;
        }

        .dashboard-header-sticky {
            position: sticky;
            top: 0;
            background: var(--prussian-blue);
            z-index: 100;
        }

        .dashboard-header-sticky h2 {
            font-size: 30px;
            font-weight: 800;
            color: var(--silver);
            margin-bottom: 0;
        }

        .container-fluid {
            padding-top: 10px;
            padding-bottom: 10px;
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

        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .icon-container {
            font-size: 1.5rem;
            margin-left: auto;
        }

        .chart-container {
            margin-top: 40px;
            background: #1a1a1a;
            padding: 20px;
            border-radius: 16px;
        }

        canvas {
            width: 100% !important;
            height: 300px !important;
        }

        .text-white h5,
        .text-white h2 {
            color: #fff !important;
        }

        .greet {
            font-size: 24px;
            font-weight: 500;
            color: var(--silver);
            margin-bottom: 20px;
            text-align: justify;
            position: relative;
            opacity: 1;
            transition: opacity 1s ease-out;
        }

        .greet.hidden {
            opacity: 0;
        }

        .posts-title {
            font-size: 15px;
            font-weight: 400;
            color: var(--silver);
            margin-left: 5px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 500;
            color: var(--silver);
        }
    </style>
</head>

<body class="dashboard">
    <div class="main">
        <div>
            <h2>Management Dashboard | ReGenEarth</h2>
        </div>

        <div class="container-fluid" id="dashboard-cards">
            <hr>
            <!-- Top Section: Users and Admins -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card text-white bg-primary shadow p-3">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Users</h5>
                                <h2 id="userCount">
                                    <?php echo $userCount; ?>
                                </h2>
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
                                <h2 id="adminCount">
                                    <?php echo $adminCount; ?>
                                </h2>
                            </div>
                            <div class="icon-container">
                                <i class="fas fa-user-shield fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Posts by Category -->
            <hr>
            <div class="row">
                <div class="col-12 text-left">
                    <h5 class="posts-title mb-3">Innovative Posts by Category</h5>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-white bg-success shadow p-3">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Climate Change</h5>
                                <h2 id="climateCount">
                                    <?php echo $climateChangeCount; ?>
                                </h2>
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
                                <h2 id="pollutionCount">
                                    <?php echo $pollutionCount; ?>
                                </h2>
                            </div>
                            <div class="icon-container">
                                <i class="fas fa-trash-alt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-warning shadow p-3">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Biodiversity Loss</h5>
                                <h2 id="biodiversityCount">
                                    <?php echo $biodiversityLossCount; ?>
                                </h2>
                            </div>
                            <div class="icon-container">
                                <i class="fas fa-tree fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Chart Section -->
            <div class="chart-container mt-5">
                <h4 style="color:#fff;">Monthly User Engagement Trend</h4>
                <canvas id="lineChart"></canvas>
            </div>
            <div class="d-flex justify-content-center mb-3">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <button class="btn btn-outline-light active" onclick="updateChart('monthly')">Monthly</button>
                    <button class="btn btn-outline-light" onclick="updateChart('yearly')">Yearly</button>
                    <button class="btn btn-outline-light" onclick="updateChart('weekly')">Weekly</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        // Sample chart data
        let lineChart;

        const chartDataSets = {
            monthly: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                data: [50, 70, 65, 120, 150, 130, 180, 200, 220, 120, 200, 309]
            },
            yearly: {
                labels: ["2020", "2021", "2022", "2023", "2024"],
                data: [500, 820, 940, 1200, 1340]
            },
            weekly: {
                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                data: [10, 12, 15, 9, 20, 25, 30]
            }
        };

        function renderChart(type) {
            const ctx = document.getElementById('lineChart').getContext('2d');
            const { labels, data } = chartDataSets[type];

            if (lineChart) lineChart.destroy(); // destroy previous instance

            lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: `User Engagements (${type.charAt(0).toUpperCase() + type.slice(1)})`,
                        data: data,
                        backgroundColor: 'rgba(76, 175, 80, 0.1)',
                        borderColor: '#4caf50',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#fff'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#fff' }
                        },
                        y: {
                            ticks: { color: '#fff' },
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function updateChart(type) {
            renderChart(type);
            // Highlight the selected button
            document.querySelectorAll('.btn-group-toggle .btn').forEach(btn => btn.classList.remove('active'));
            const clickedBtn = Array.from(document.querySelectorAll('.btn-group-toggle .btn')).find(btn => btn.textContent.toLowerCase() === type);
            if (clickedBtn) clickedBtn.classList.add('active');
        }

        // Initial render
        renderChart('monthly');
    </script>
</body>

</html>