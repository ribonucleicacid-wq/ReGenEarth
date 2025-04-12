<?php 
session_start();
include 'inc/header.php'; 
include '../auth/user_only.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triple Planetary Crisis Awareness | ReGenEarth</title>
    <style>
        .tpc-content {
            --moonstone: #57AFC3;
            --prussian-blue: #132F43;
            --silver: #CACFD3;
            --taupe-gray: #999A9C;
            --rich-black: #0B1A26;
            --brunswick-green: #234F38;
            
            font-family: 'Inter', 'Arial', sans-serif;
            color: var(--silver);
            line-height: 1.6;
            position: relative;
            background-color: var(--rich-black);
        }

        .tpc-content::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('../assets/images/earth-bg.jpg') center/cover no-repeat fixed;
            opacity: 0.15;
            z-index: -1;
        }

        .tpc-content .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }

        .tpc-content .hero-section {
            background: linear-gradient(135deg, rgba(19, 47, 67, 0.95), rgba(35, 79, 56, 0.95));
            padding: 60px 20px;
            margin: 0 -20px 40px;
            color: var(--silver);
            text-align: center;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 20px 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .tpc-content h1 {
            font-size: 2.8em;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--moonstone);
        }

        .tpc-content .hero-text {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.2em;
            line-height: 1.6;
            color: var(--silver);
        }

        .tpc-content .crisis-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }

        .tpc-content .crisis-card {
            background: var(--prussian-blue);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .tpc-content .crisis-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            background: linear-gradient(145deg, var(--prussian-blue), var(--brunswick-green));
        }

        .tpc-content .card-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .tpc-content .card-content {
            padding: 25px;
            background: rgba(19, 47, 67, 0.7);
        }

        .tpc-content .card-title {
            color: var(--moonstone);
            font-size: 1.5em;
            margin: 0 0 15px;
            font-weight: 600;
        }

        .tpc-content .card-text {
            color: var(--silver);
            margin-bottom: 20px;
        }

        .tpc-content .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tpc-content .info-list li {
            padding-left: 24px;
            position: relative;
            margin-bottom: 10px;
            color: var(--silver);
        }

        .tpc-content .info-list li::before {
            content: '•';
            color: var(--moonstone);
            position: absolute;
            left: 0;
            font-weight: bold;
        }

        .tpc-content .tips-section {
            background: linear-gradient(135deg, rgba(19, 47, 67, 0.9), rgba(35, 79, 56, 0.9));
            padding: 60px 40px;
            border-radius: 30px;
            margin-top: 60px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .tpc-content .section-title {
            color: var(--moonstone);
            text-align: center;
            font-size: 2em;
            margin-bottom: 40px;
        }

        .tpc-content .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .tpc-content .tip-item {
            background: rgba(19, 47, 67, 0.7);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }

        .tpc-content .tip-item:hover {
            transform: translateY(-5px);
            background: rgba(35, 79, 56, 0.7);
        }

        .tpc-content .tip-icon {
            font-size: 2em;
            color: var(--moonstone);
            margin-bottom: 15px;
        }

        .tpc-content .tip-title {
            color: var(--moonstone);
            font-size: 1.2em;
            margin: 0 0 10px;
            font-weight: 600;
        }

        .tpc-content .tip-text {
            color: var(--silver);
            margin: 0;
        }

        @media (max-width: 768px) {
            .tpc-content .container {
                padding: 20px;
            }

            .tpc-content .hero-section {
                padding: 40px 20px;
            }

            .tpc-content h1 {
                font-size: 2em;
            }

            .tpc-content .crisis-grid {
                grid-template-columns: 1fr;
            }

            .tpc-content .tips-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="tpc-content">
        <div class="container">
            <section class="hero-section">
                <h1>The Triple Planetary Crisis</h1>
                <p class="hero-text">Our planet faces three interconnected challenges that threaten our environment, health, and future. Understanding these crises is the first step toward creating positive change.</p>
            </section>

            <div class="crisis-grid">
                <div class="crisis-card">
                    <img src="../assets/images/pollution.jpg" alt="Environmental Pollution" class="card-image">
                    <div class="card-content">
                        <h3 class="card-title">Pollution Crisis</h3>
                        <p class="card-text">Pollution affects air, water, and soil quality, posing serious risks to both human health and ecosystems.</p>
                        <ul class="info-list">
                            <li>Industrial emissions and waste</li>
                            <li>Plastic pollution in oceans</li>
                            <li>Air quality deterioration</li>
                            <li>Chemical contamination</li>
                        </ul>
                    </div>
                </div>

                <div class="crisis-card">
                    <img src="../assets/images/climate_change.jpg" alt="Climate Change" class="card-image">
                    <div class="card-content">
                        <h3 class="card-title">Climate Crisis</h3>
                        <p class="card-text">Global climate change leads to rising temperatures, extreme weather events, and disrupted ecosystems.</p>
                        <ul class="info-list">
                            <li>Rising sea levels</li>
                            <li>Extreme weather patterns</li>
                            <li>Global temperature rise</li>
                            <li>Melting ice caps</li>
                        </ul>
                    </div>
                </div>

                <div class="crisis-card">
                    <img src="../assets/images/bioloss.jpg" alt="Biodiversity Loss" class="card-image">
                    <div class="card-content">
                        <h3 class="card-title">Biodiversity Crisis</h3>
                        <p class="card-text">The rapid loss of species and habitats threatens the delicate balance of Earth's ecosystems.</p>
                        <ul class="info-list">
                            <li>Species extinction</li>
                            <li>Habitat destruction</li>
                            <li>Ecosystem collapse</li>
                            <li>Food chain disruption</li>
                        </ul>
                    </div>
                </div>
            </div>

            <section class="tips-section">
                <h2 class="section-title">Taking Action</h2>
                <div class="tips-grid">
                    <div class="tip-item">
                        <div class="tip-icon">🌱</div>
                        <h4 class="tip-title">Reduce Carbon Footprint</h4>
                        <p class="tip-text">Choose sustainable transportation and energy-efficient appliances.</p>
                    </div>

                    <div class="tip-item">
                        <div class="tip-icon">♻️</div>
                        <h4 class="tip-title">Waste Management</h4>
                        <p class="tip-text">Practice recycling and minimize single-use plastics.</p>
                    </div>

                    <div class="tip-item">
                        <div class="tip-icon">🌳</div>
                        <h4 class="tip-title">Support Conservation</h4>
                        <p class="tip-text">Participate in local conservation efforts and wildlife protection.</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
