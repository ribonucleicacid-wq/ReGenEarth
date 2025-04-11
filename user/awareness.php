<?php
include 'inc/header.php'; // Ensuring the header is included correctly but remains unchanged
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triple Planetary Crisis Awareness | ReGenEarth</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #0B1A26; /* Rich Black */
            color: #CACFD3; /* Silver */
            margin: 0;
            padding: 0;
        }

        /* Grid Layout for Maximizing Landscape Space */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 70px;
            text-align: center;
        }

        /* Cards with Hover Effect */
        .card {
            position: relative;
            background: rgba(19, 47, 67, 0.9); /* Prussian Blue */
            padding: 20px;
            border-radius: 12px;
            color: #CACFD3;
            text-align: center;
            transition: transform 0.3s, background 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        .card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
        }
        .card:hover {
            transform: scale(1.05);
            background: #57AFC3; /* Moonstone */
            color: #132F43;
        }
        .card .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40%;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .card:hover .overlay {
            opacity: 1;
        }

        /* Solutions Section */
        .solutions {
            padding: 20px;
            background: rgba(35, 79, 56, 0.9); /* Brunswick Green */
            text-align: center;
        }
        .solutions ul {
            list-style: none;
            padding-left: 0;
        }
        .solutions ul li {
            font-size: 18px;
            padding: 10px;
            color: #CACFD3;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background: rgba(19, 47, 67, 0.8); /* Semi-transparent Prussian Blue */
            color: #CACFD3;
        }
    </style>
</head>
<body>

<!-- Grid Section for TPC Information -->
<section class="grid-container">
    <div class="card" id="pollution">
        <img src="assets/images/pollution.jpg" alt="Pollution">
        <div class="overlay">
            <p>🌍 <strong>Causes:</strong> Heavy reliance on fossil fuels, industrial waste dumping, excessive plastic use.</p>
        </div>
    </div>

    <div class="card" id="climate">
        <img src="climate change.jpg" alt="Climate Change">
        <div class="overlay">
            <p>🌪️ <strong>Causes:</strong> Burning fossil fuels, deforestation, unsustainable farming.</p>
        </div>
    </div>

    <div class="card" id="biodiversity">
        <img src="bioloss.jpg" alt="Biodiversity Loss">
        <div class="overlay">
            <p>🦜 <strong>Impact:</strong> Species extinction, reduced climate resilience, ecosystem imbalance.</p>
        </div>
    </div>
</section>

<!-- Solutions Section -->
<section id="tips" class="solutions">
    <h2>🌱 Solutions & How You Can Help</h2>
    <ul>
        <li>♻️ Reduce carbon footprint: Choose sustainable energy sources.</li>
        <li>🌳 Protect habitats: Participate in conservation programs.</li>
        <li>🚯 Minimize plastic waste: Switch to reusable alternatives.</li>
    </ul>
</section>

<!-- Footer -->
<footer>
    <p>© 2025 ReGenEarth | Join the movement today!</p>
</footer>

</body>
</html>