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
    <!-- Add Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Add Garet font -->
    <style>
        /* Awareness page styles are now scoped under .awareness-container */
        .awareness-container {
            max-width: 100%;
            margin: 0;
            padding: 1rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(rgba(0, 28, 46, 0.70), rgba(0, 28, 46, 0.70));
            background-size: cover;
            background-position: center;
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
            overflow-y: auto;
        }
        .awareness-container .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
            flex: 1;
            width: 100%;
            margin: 0 auto;
            padding: 0;
        }
        .awareness-container .content-left {
            max-width: 65%;
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .awareness-container .content-wrapper {
            flex: 1;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
            position: relative;
        }
        .awareness-container .content-wrapper.fade-out {
            opacity: 0;
        }
        .awareness-container .main-title {
            font-family: 'Garet', sans-serif;
            color: #00a2ff;
            margin-bottom: 2rem;
            line-height: 1;
            font-weight: 700;
            letter-spacing: -0.02em;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        .awareness-container .main-title .small-text {
            font-size: 27px;
            display: block;
        }
        .awareness-container .main-title .large-text {
            font-size: 48.8px;
            display: block;
        }
        .awareness-container .main-description {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 1.00rem;
            margin-bottom: 1rem;
            max-width: 700px;
            line-height: 1.6;
            transition: all 0.3s ease;
        }
        .awareness-container .main-description strong {
            color: #ffffff;
            font-weight: 600;
        }
        .awareness-container .sub-description {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 700px;
            line-height: 1.5;
            opacity: 0.9;
        }
        .awareness-container .button-group {
            display: flex;
            gap: 1rem;
            position: fixed;
            z-index: 2000;
            top: 0;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }
        .awareness-container .learn-more, .awareness-container .how-to-help {
            font-family: 'Montserrat', Arial, sans-serif;
            padding: 1rem 2rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .awareness-container .learn-more {
            background-color: #00a2ff;
            color: white;
        }
        .awareness-container .learn-more:hover {
            background-color: #0088d6;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 162, 255, 0.3);
        }
        .awareness-container .how-to-help {
            background-color: rgba(0, 162, 255, 0.1);
            color: #00a2ff;
            border: 2px solid #00a2ff;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .awareness-container .how-to-help:hover {
            background-color: rgba(0, 162, 255, 0.2);
            transform: translateY(-2px);
        }
        .awareness-container .globe-icon {
            width: 24px;
            height: 24px;
            filter: brightness(0) saturate(100%) invert(47%) sepia(98%) saturate(1726%) hue-rotate(176deg) brightness(102%) contrast(105%);
        }
        .awareness-container .image-grid {
            display: flex;
            flex-direction: row;
            gap: 2rem;
            max-width: 100vw;
            margin: 8rem auto 2rem auto;
            height: 420px;
            justify-content: center;
            align-items: stretch;
        }
        .awareness-container .static-title {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: #00a2ff;
            text-align: center;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: -0.02em;
            position: absolute;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
        }
        .awareness-container .image-card {
            flex: 1 1 0;
            min-width: 0;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            border-radius: 40px;
            transition: flex 0.5s cubic-bezier(0.4,0,0.2,1), box-shadow 0.3s, z-index 0s;
            aspect-ratio: unset;
            height: 100%;
            box-shadow: 0 4px 32px rgba(0,0,0,0.18);
            z-index: 1;
            background: #222;
            display: flex;
            align-items: stretch;
            justify-content: stretch;
        }
        .awareness-container .image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4,0,0.2,1), filter 0.3s;
            border-radius: 40px;
        }
        .awareness-container .info-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 2rem;
            color: #fff;
            background: rgba(0, 0, 0, 0.65);
            z-index: 2;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        .awareness-container .info-overlay .main-title {
            color: #3ec6ff;
            font-family: 'Montserrat', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-transform: none;
        }
        .awareness-container .info-overlay p {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            color: white;
            max-width: 90%;
        }
        .awareness-container .info-overlay p strong {
            color: white;
            font-weight: 600;
        }
        .awareness-container .image-card:hover .info-overlay,
        .awareness-contair .image-card:focus-within .info-overlay {
            opacity: 1;
            pointer-events: auto;
        }
        .awareness-container .image-card:not(:hover):not(:focus-within) img {
            filter: brightness(0.85) grayscale(0.2);
        }
        .awareness-container .image-card:hover,
        .awareness-container .image-card:focus-within {
            flex: 3 1 0;
            z-index: 2;
            box-shadow: 0 12px 48px rgba(0,0,0,0.28);
        }
        .awareness-container .image-card:hover img,
        .awareness-container .image-card:focus-within img {
            transform: scale(1.08);
            filter: brightness(1.08) saturate(1.1);
        }
        .awareness-container .image-label,
        .awareness-container .subtitle {
            position: absolute;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
            z-index: 1;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        .awareness-container .image-label {
            bottom: 2rem;
            left: 2rem;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .awareness-container .subtitle {
            position: absolute;
            color:rgb(39, 165, 238);
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.88);
            z-index: 1;
            transition: opacity 0.9s;
            pointer-events: none;
            bottom: 0.5rem;
            left: 2rem;
            font-size: 1.2rem;
            opacity: 2.0;
        }
        .awareness-container .image-card:hover .image-label,
        .awareness-container .image-card:hover .subtitle,
        .awareness-container .image-card:focus-within .image-label,
        .awareness-container .image-card:focus-within .subtitle {
            opacity: 0;
        }
        .awareness-container .modal {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            max-height: 80vh;
            background: transparent;
            z-index: 2000;
            justify-content: center;
            align-items: flex-end;
        }
        .awareness-container .modal.active {
            display: flex;
        }
        .awareness-container .modal-content {
            background: linear-gradient(90deg, #0f2d54 0%, #0c4d50 100%);
            color: #fff;
            border-radius: 24px 24px 0 0;
            width: 100%;
            margin: 0;
            padding: 2.5rem 2rem 2rem 2rem;
            box-shadow: 0 -8px 32px rgba(0,0,0,0.35);
            font-family: 'Montserrat', Arial, sans-serif;
            text-align: left;
            position: relative;
            opacity: 1;
            transform: none;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            max-height: 80vh;
            overflow-y: auto;
        }
        .awareness-container .modal-content h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: left;
            line-height: 1.2;
        }
        .awareness-container .modal-content p {
            font-size: 1.15rem;
            line-height: 1.7;
            margin-bottom: 1.2rem;
        }
        .awareness-container .modal-content strong {
            font-weight: 700;
            color: #fff;
        }
        .awareness-container .close {
            position: absolute;
            top: 1.2rem;
            right: 1.2rem;
            background: none;
            border: none;
            color: #fff;
            font-size: 2rem;
            cursor: pointer;
            z-index: 10;
            transition: background 0.2s;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .awareness-container .close:hover {
            background: rgba(255,255,255,0.08);
        }
        .awareness-container .footer {
            font-family: 'Montserrat', Arial, sans-serif;
            background: linear-gradient(90deg, #0f2d54 0%, #0c4d50 100%);
            color: white;
            text-align: center;
            padding: 1rem;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
            font-size: 1rem;
            letter-spacing: 0.5px;
            backdrop-filter: blur(10px);
            z-index: 100;
        }
        /* General responsiveness for smaller screens */
        @media (max-width: 1200px) {
            .awareness-container .image-grid {
                height: auto;
                gap: 1rem;
                flex-wrap: wrap;
            }
            .awareness-container .image-card {
                flex: 1 1 calc(50% - 1rem);
                height: 200px;
            }
            .awareness-container .image-card img {
                border-radius: 16px;
            }
            .content-cards {
                width: 70%;
            }
        }

        @media (max-width: 900px) {
            .awareness-container .image-grid {
                flex-direction: column;
                height: auto;
                gap: 1rem;
            }
            .awareness-container .image-card {
                flex: 1 1 100%;
                height: 180px;
            }
            .awareness-container .static-title {
                font-size: 1.8rem;
            }
            .content-cards {
                width: 80%;
            }
        }

        @media (max-width: 768px) {
            .awareness-container .image-grid {
                gap: 0.5rem;
            }
            .awareness-container .image-card {
                height: 150px;
            }
            .awareness-container .static-title {
                font-size: 1.5rem;
            }
            .content-cards {
                width: 90%;
            }
            .content-card {
                padding: 1.5rem;
            }
            .content-card h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 600px) {
            .awareness-container .image-grid {
                flex-direction: column;
                gap: 0.5rem;
            }
            .awareness-container .image-card {
                height: 120px;
            }
            .awareness-container .static-title {
                font-size: 1.2rem;
            }
            .content-cards {
                width: 95%;
            }
            .content-card {
                padding: 1rem;
            }
            .content-card h2 {
                font-size: 1.2rem;
            }
            .content-card ul {
                font-size: 0.9rem;
            }
            .content-card li {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .awareness-container .image-card {
                height: 100px;
            }
            .awareness-container .static-title {
                font-size: 1rem;
            }
            .content-card h2 {
                font-size: 1rem;
            }
            .content-card ul {
                font-size: 0.8rem;
            }
            .content-card li {
                font-size: 0.8rem;
            }
        }

        /* New styles for content cards */
        .content-cards {
            width: 50%;
            margin: 0 auto 4rem auto;
            padding: 0;
        }

        .content-card {
            background: linear-gradient(90deg, #0f2d54 0%, #0c4d50 100%);
            border-radius: 16px;
            padding: 2.5rem;
            margin: 0;
            position: relative;
            color: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.35);
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            display: none;
        }

        .content-card.active {
            opacity: 1;
            transform: translateY(0);
            display: block;
        }

        .content-card h2 {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #00a2ff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .content-card .section-title {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: #00a2ff;
            margin: 2rem 0 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .content-card h2::before,
        .content-card .section-title::before {
            font-size: 1.5rem;
        }

        .content-card h2::before {
            content: "🚨";
        }

        .content-card .section-title::before {
            content: "💥";
        }

        .content-card p {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 1.15rem;
            line-height: 1.7;
            margin-bottom: 1.2rem;
        }

        .content-card ul {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 2rem;
        }

        .content-card li {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .content-card li:before {
            content: "•";
            color: #00a2ff;
            position: absolute;
            left: 0;
        }

        .close-card {
            position: absolute;
            top: 1.2rem;
            right: 1.2rem;
            background: none;
            border: none;
            color: #fff;
            font-size: 2rem;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }

        .close-card:hover {
            background: rgba(255,255,255,0.08);
        }

        body {
            background-size: cover !important;
            background-position: center !important;
            background-attachment: fixed !important;
            transition: background 0.3s ease;
        }

        .button-container {
            position: absolute;
            bottom: 20px;
            left: 20px;
            display: flex;
            gap: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 3;
        }

        .image-card:hover .button-container {
            opacity: 1;
        }

        .learn-more-btn, .how-to-help-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Montserrat', Arial, sans-serif;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .learn-more-btn {
            background-color: #00a2ff;
            color: white;
        }

        .how-to-help-btn {
            background-color: rgba(0, 162, 255, 0.1);
            color: #00a2ff;
            border: 2px solid #00a2ff;
        }

        .learn-more-btn:hover, .how-to-help-btn:hover {
            transform: translateY(-2px);
        }

        .learn-more-btn:hover {
            background-color: #0088d6;
        }

        .how-to-help-btn:hover {
            background-color: rgba(0, 162, 255, 0.2);
        }
    </style>
</head>

<body>
    <div class="awareness-container">
        <div class="main-content" id="main-content">
            <h2 class="static-title">The Triple Planetary Crisis</h2>
            <div class="image-grid">
                <div class="image-card" data-category="tpc">
                    <img src="../assets/images/tripleplanetary1.jpg" alt="Triple Planetary Crisis">
                    <div class="info-overlay">
                        <h2 class="main-title">THE<br>TRIPLE<br>PLANETARY CRISIS</h2>
                        <p>The TPC refers to three <strong>interconnected environmental threats</strong> caused by human activity: <strong>Pollution, Climate Change, and Biodiversity Loss</strong>.</p>
                        <p>These problems might sound overwhelming, but knowledge is power! Keep reading to uncover the causes, impacts, and—most importantly—<strong>how YOU can make a difference</strong>.</p>
    <div class="tpc-content">
        <div class="container">
            <section class="hero-section">
                <h1>The Triple Planetary Crisis</h1>
                <p class="hero-text">Our planet faces three interconnected challenges that threaten
                    our environment,
                    health, and future. Understanding these crises is the first step toward creating positive
                    change.
                </p>
            </section>

            <div class="crisis-grid">
                <div class="crisis-card">
                    <img src="../assets/images/pollution.jpg" alt="Environmental Pollution" class="card-image">
                    <div class="card-content">
                        <h3 class="card-title">Pollution Crisis</h3>
                        <p class="card-text">Pollution affects air, water, and soil quality, posing serious
                            risks to both human health and ecosystems.</p>
                        <ul class="info-list">
                            <li>Industrial emissions and waste</li>
                            <li>Plastic pollution in oceans</li>
                            <li>Air quality deterioration</li>
                            <li>Chemical contamination</li>
                        </ul>
                    </div>
                    <div class="button-container">
                        <button class="learn-more-btn">Learn More</button>
                        <button class="how-to-help-btn">How to Help</button>
                    </div>
                    <div class="image-label">The Triple Planetary Crisis</div>
                </div>
                <div class="image-card" data-category="pollution">
                    <img src="../assets/images/pollution1.jpg" alt="Pollution">
                    <div class="info-overlay">
                        <h2 class="main-title">Pollution</h2>
                        <p>Pollution exists in many forms—air, water, soil, and plastic waste. Factories, vehicles, and improper waste disposal introduce harmful chemicals into our surroundings. Burning fossil fuels (coal, oil, gas) releases pollutants that poison the air we breathe and disrupt ecosystems.</p>
                    </div>
                    <div class="button-container">
                        <button class="learn-more-btn">Learn More</button>
                <div class="crisis-card">
                    <img src="../assets/images/climate_change.jpg" alt="Climate Change" class="card-image">
                    <div class="card-content">
                        <h3 class="card-title">Climate Crisis</h3>
                        <p class="card-text">Global climate change leads to rising temperatures,
                            extreme weather events,
                            and disrupted ecosystems.</p>
                        <ul class="info-list">
                            <li>Rising sea levels</li>
                            <li>Extreme weather patterns</li>
                            <li>Global temperature rise</li>
                            <li>Melting ice caps</li>
                        </ul>
                    </div>
                    <div class="image-label">Pollution</div>
                    <div class="subtitle">A toxic legacy</div>
                </div>
                <div class="image-card" data-category="climate">
                    <img src="../assets/images/climate_change1.jpg" alt="Climate Change">
                    <div class="info-overlay">
                        <h2 class="main-title">Climate Change</h2>
                        <p>Climate change results from <strong>greenhouse gases</strong>—mainly from burning fossil fuels—which trap heat in the atmosphere, leading to a warming Earth, rising sea levels, and extreme weather patterns.</p>
                    </div>
                    <div class="button-container">
                        <button class="learn-more-btn">Learn More</button>
                    </div>
                    <div class="image-label">Climate Change</div>
                    <div class="subtitle">A Warming World</div>
                </div>
                <div class="image-card" data-category="biodiversity">
                    <img src="../assets/images/bioloss1.jpg" alt="Biodiversity Loss">
                    <div class="info-overlay">
                        <h2 class="main-title">Biodiversity Loss</h2>
                        <p>Nature thrives on balance, but human activities disrupt ecosystems, leading to the <strong>loss of plant and animal species at alarming rates</strong>. Deforestation and pollution force countless species to <strong>struggle for survival</strong>.</p>
                    </div>
                    <div class="button-container">
                        <button class="learn-more-btn">Learn More</button>

                <div class="crisis-card">
                    <img src="../assets/images/bioloss.jpg" alt="Biodiversity Loss" class="card-image">
                    <div class="card-content">
                        <h3 class="card-title">Biodiversity Crisis</h3>
                        <p class="card-text">The rapid loss of species and habitats threatens the delicate
                            balance of Earth's ecosystems.</p>
                        <ul class="info-list">
                            <li>Species extinction</li>
                            <li>Habitat destruction</li>
                            <li>Ecosystem collapse</li>
                            <li>Food chain disruption</li>
                        </ul>
                    </div>
                    <div class="image-label">Biodiversity Loss</div>
                    <div class="subtitle">A Silent Disaster</div>
                </div>
            </div>

            <!-- New Content Cards Section -->
            <div class="content-cards">
                <div class="content-card" id="tpcCard" style="display: none;">
                    <button class="close-card">×</button>
                    <h2>What's Really Happening to Our Planet?</h2>
                    <p>Imagine waking up to skies thick with smog, oceans choked with plastic, and forests reduced to barren wastelands. <strong>This isn't science fiction—it's our reality.</strong></p>
                    <p>Pollution, climate change, and biodiversity loss are pushing Earth to its limits. Together, these crises form the <strong>Triple Planetary Crisis (TPC)</strong>—an urgent environmental challenge that affects everyone, from bustling cities to remote villages.</p>
                    <p>But here's the good news: <strong>we still have time to act!</strong></p>
                </div>
            <section class="tips-section">
                <h2 class="section-title">Taking Action</h2>
                <div class="tips-grid">
                    <div class="tip-item">
                        <div class="tip-icon">🌱</div>
                        <h4 class="tip-title">Reduce Carbon Footprint</h4>
                        <p class="tip-text">Choose sustainable transportation and energy-efficient appliances.
                        </p>
                    </div>

                <div class="content-card" id="pollutionCard" style="display: none;">
                    <button class="close-card">×</button>
                    <h2>Causes of Pollution</h2>
                    <ul>
                        <li>Heavy reliance on fossil fuels for energy and transportation</li>
                        <li>Industrial waste dumping and improper waste management</li>
                        <li>Excessive plastic use and lack of recycling</li>
                    </ul>
                    <div class="section-title">Impacts of Pollution</div>
                    <ul>
                        <li>Human Health: Causes respiratory diseases, water contamination, and other health problems.</li>
                        <li>Economic Burden: Pollution-related illnesses increase healthcare costs and reduce productivity.</li>
                        <li>Environmental Damage: Toxic substances seep into soil and water, harming wildlife and crops.</li>
                    </ul>
                </div>

                <div class="content-card" id="climateCard" style="display: none;">
                    <button class="close-card">×</button>
                    <h2>Causes of Climate Change</h2>
                    <ul>
                        <li>Burning fossil fuels like coal, oil, and gas for energy.</li>
                        <li>Deforestation for land and industry.</li>
                        <li>Excessive emissions from vehicles, factories, and power plants.</li>
                        <li>Unsustainable farming and waste.</li>
                    </ul>
                    <div class="section-title">Impacts of Climate Change</div>
                    <ul>
                        <li>More frequent storms, droughts, and heat waves.</li>
                        <li>Rising sea levels threatening coastal communities.</li>
                        <li>Disrupted agriculture and food supply.</li>
                        <li>Warmer temperatures accelerating the spread of harmful bacteria.</li>
                    </ul>
                </div>

                <div class="content-card" id="biodiversityCard" style="display: none;">
                    <button class="close-card">×</button>
                    <h2>Causes of Biodiversity Loss</h2>
                    <ul>
                        <li>Land clearing for mining and energy production.</li>
                        <li>Pollution destroying habitats and food sources.</li>
                        <li>Overexploitation of natural resources without restoration efforts.</li>
                    </ul>
                    <div class="section-title">Impacts of Biodiversity Loss</div>
                    <ul>
                        <li>Ecosystem Collapse: Loss of essential species weakens food chains and disrupts nature's balance.</li>
                        <li>Declining Natural Resources: Fewer fish, plants, and animals for food and medicine.</li>
                        <li>Disrupted agriculture and food supply.</li>
                        <li>Reduced Climate Resilience: Less biodiversity makes it harder for nature to adapt to climate change.</li>
                    </ul>
                    <div class="tip-item">
                        <div class="tip-icon">🌳</div>
                        <h4 class="tip-title">Support Conservation</h4>
                        <p class="tip-text">Participate in local conservation efforts and wildlife protection.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modals, footer, and scripts remain unchanged, but should also be scoped if styled -->
        <div class="footer">
            2025 ReGenEarth | Join the movement today!
        </div>
    </div>

    <!-- Learn More Modal -->
    <div class="modal" id="learnMoreModal">
        <div class="modal-content">
            <button class="close">×</button>
            <h2>What's Really Happening to Our Planet?</h2>
            <p>Imagine waking up to skies thick with smog, oceans choked with plastic, and forests reduced to barren wastelands. <strong>This isn't science fiction—it's our reality.</strong></p>
            <p>Pollution, climate change, and biodiversity loss are pushing Earth to its limits. Together, these crises form the <strong>Triple Planetary Crisis (TPC)</strong>—an urgent environmental challenge that affects everyone, from bustling cities to remote villages.</p>
            <p>But here's the good news: <strong>we still have time to act!</strong></p>
        </div>
    </div>

    <!-- Pollution Modal -->
    <div class="modal" id="pollutionModal">
        <div class="modal-content">
            <button class="close">×</button>
            <h2>🚨 Causes of Pollution</h2>
            <ul>
                <li>Heavy reliance on fossil fuels for energy and transportation</li>
                <li>Industrial waste dumping and improper waste management</li>
                <li>Excessive plastic use and lack of recycling</li>
            </ul>
            <div class="section-title">💥 Impacts of Pollution</div>
            <ul>
                <li>Human Health: Causes respiratory diseases, water contamination, and other health problems.</li>
                <li>Economic Burden: Pollution-related illnesses increase healthcare costs and reduce productivity.</li>
                <li>Environmental Damage: Toxic substances seep into soil and water, harming wildlife and crops.</li>
            </ul>
        </div>
    </div>

    <!-- Climate Change Modal -->
    <div class="modal" id="climateModal">
        <div class="modal-content">
            <button class="close">×</button>
            <h2>🔥 Causes of Climate Change</h2>
            <ul>
                <li>Burning fossil fuels like coal, oil, and gas for energy.</li>
                <li>Deforestation for land and industry.</li>
                <li>Excessive emissions from vehicles, factories, and power plants.</li>
                <li>Unsustainable farming and waste.</li>
            </ul>
            <div class="section-title">🌍 Impacts of Climate Change</div>
            <ul>
                <li>More frequent storms, droughts, and heat waves.</li>
                <li>Rising sea levels threatening coastal communities.</li>
                <li>Disrupted agriculture and food supply.</li>
                <li>Warmer temperatures accelerating the spread of harmful bacteria.</li>
            </ul>
        </div>
    </div>

    <!-- Biodiversity Loss Modal -->
    <div class="modal" id="biodiversityModal">
        <div class="modal-content">
            <button class="close">×</button>
            <h2>⭕ Causes of Biodiversity Loss</h2>
            <ul>
                <li>Land clearing for mining and energy production.</li>
                <li>Pollution destroying habitats and food sources.</li>
                <li>Overexploitation of natural resources without restoration efforts.</li>
            </ul>
            <div class="section-title">🌱 Impacts of Biodiversity Loss</div>
            <ul>
                <li>Ecosystem Collapse: Loss of essential species weakens food chains and disrupts nature's balance.</li>
                <li>Declining Natural Resources: Fewer fish, plants, and animals for food and medicine.</li>
                <li>Disrupted agriculture and food supply.</li>
                <li>Reduced Climate Resilience: Less biodiversity makes it harder for nature to adapt to climate change.</li>
            </ul>
        </div>
    </div>

    <!-- How to Help Modal -->
    <div class="modal" id="howToHelpModal">
        <div class="modal-content">
            <button class="close">×</button>
            <h2>Ways to Combat the Triple Planetary Crisis</h2>
            <ul>
                <li><strong>Reduce Carbon Footprint:</strong> Choose sustainable transportation, energy-efficient appliances, and renewable energy sources</li>
                <li><strong>Conserve Energy:</strong> Turn off unused electronics and lights; consider solar panels for your home</li>
                <li><strong>Protect Habitats:</strong> Participate in reforestation and conservation projects</li>
                <li><strong>Support Sustainable Practices:</strong> Promote eco-friendly farming and fishing</li>
                <li><strong>Minimize Plastic Usage:</strong> Opt for reusable items like eco-bags and stainless containers</li>
                <li><strong>Dispose of Waste Responsibly:</strong> Recycle, compost, and properly discard hazardous waste</li>
                <li><strong>Back Eco-Friendly Industries:</strong> Support businesses and policies that reduce pollution</li>
                <li><strong>Raise Awareness:</strong> Share knowledge and advocate for green initiatives</li>
                <li><strong>Engage in Environmental Campaigns:</strong> Take action locally or globally</li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageCards = document.querySelectorAll('.image-card');
            const contentCards = document.querySelectorAll('.content-card');
            const closeButtons = document.querySelectorAll('.close-card');
            const body = document.querySelector('body');
            const tpcCard = document.getElementById('tpcCard');

            // Define background images for each category
            const bgMap = {
                'tpc': '../assets/images/tripleplanetary1.jpg',
                'pollution': '../assets/images/pollution1.jpg',
                'climate': '../assets/images/climate_change1.jpg',
                'biodiversity': '../assets/images/bioloss1.jpg'
            };

            // Store original TPC content
            const originalTpcContent = tpcCard.innerHTML;

            // How to Help content
            const howToHelpContent = `
                <button class="close-card">×</button>
                <h2>Ways to Combat the Triple Planetary Crisis</h2>
                <ul>
                    <li><strong>Reduce Carbon Footprint:</strong> Choose sustainable transportation, energy-efficient appliances, and renewable energy sources</li>
                    <li><strong>Conserve Energy:</strong> Turn off unused electronics and lights; consider solar panels for your home</li>
                    <li><strong>Protect Habitats:</strong> Participate in reforestation and conservation projects</li>
                    <li><strong>Support Sustainable Practices:</strong> Promote eco-friendly farming and fishing</li>
                    <li><strong>Minimize Plastic Usage:</strong> Opt for reusable items like eco-bags and stainless containers</li>
                    <li><strong>Dispose of Waste Responsibly:</strong> Recycle, compost, and properly discard hazardous waste</li>
                    <li><strong>Back Eco-Friendly Industries:</strong> Support businesses and policies that reduce pollution</li>
                    <li><strong>Raise Awareness:</strong> Share knowledge and advocate for green initiatives</li>
                    <li><strong>Engage in Environmental Campaigns:</strong> Take action locally or globally</li>
                </ul>
            `;

            function setBackground(imagePath) {
                body.style.background = `linear-gradient(rgba(0, 28, 46, 0.45), rgba(0, 28, 46, 0.60)), url('${imagePath}')`;
                body.style.backgroundSize = 'cover';
                body.style.backgroundPosition = 'center';
                body.style.backgroundAttachment = 'fixed';
            }

            function hideAllCards() {
                contentCards.forEach(card => {
                    card.style.display = 'none';
                    card.classList.remove('active');
                });
                // Reset TPC content to original when hiding cards
                tpcCard.innerHTML = originalTpcContent;
                // Reattach close button event listener
                attachCloseButtonListeners();
            }

            function attachCloseButtonListeners() {
                closeButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const card = button.closest('.content-card');
                        card.classList.remove('active');
                        setTimeout(() => {
                            card.style.display = 'none';
                            setBackground(bgMap['tpc']);
                            if (card === tpcCard) {
                                tpcCard.innerHTML = originalTpcContent;
                                attachCloseButtonListeners();
                            }
                        }, 300);
                    });
                });
            }

            // Handle both image clicks, hovers, and button clicks
            imageCards.forEach(card => {
                const learnMoreBtn = card.querySelector('.learn-more-btn');
                const howToHelpBtn = card.querySelector('.how-to-help-btn');
                const category = card.getAttribute('data-category');

                // Image click handler for background change
                card.addEventListener('click', (e) => {
                    if (e.target.closest('.button-container')) {
                        return; // Don't process if clicking buttons
                    }
                    
                    if (bgMap[category]) {
                        setBackground(bgMap[category]);
                    }
                });

                // Mouse enter handler to close other cards
                card.addEventListener('mouseenter', () => {
                    hideAllCards();
                    if (bgMap[category]) {
                        setBackground(bgMap[category]);
                    }
                });

                // Learn More button click handler
                if (learnMoreBtn) {
                    learnMoreBtn.addEventListener('click', (e) => {
                        e.stopPropagation(); // Prevent image card click
                        const targetCard = document.getElementById(`${category}Card`);
                        
                        if (bgMap[category]) {
                            setBackground(bgMap[category]);
                        }
                        
                        if (targetCard.style.display === 'none' || !targetCard.style.display) {
                            hideAllCards();
                            targetCard.style.display = 'block';
                            setTimeout(() => {
                                targetCard.classList.add('active');
                                targetCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }, 10);
                        }
                    });
                }

                // How to Help button click handler
                if (howToHelpBtn) {
                    howToHelpBtn.addEventListener('click', (e) => {
                        e.stopPropagation(); // Prevent image card click
                        
                        hideAllCards();
                        tpcCard.innerHTML = howToHelpContent;
                        tpcCard.style.display = 'block';
                        setTimeout(() => {
                            tpcCard.classList.add('active');
                            tpcCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            attachCloseButtonListeners();
                        }, 10);
                    });
                }
            });

            // Initial setup
            attachCloseButtonListeners();
            setBackground(bgMap['tpc']);
        });
    </script>
</body>
</html>