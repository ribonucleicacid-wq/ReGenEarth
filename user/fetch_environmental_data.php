<?php

header('Content-Type: application/json');
$apiKey = 'bd5f50fa8246ba25c5caf48136dc8897';

// Get the category from the request
$category = isset($_GET['category']) ? $_GET['category'] : null;

if (!$category) {
    echo json_encode(['error' => 'Category is required']);
    exit;
}

try {
    if ($category === 'pollution') {
        // Fetch air quality data for Manila, Philippines
        $lat = '14.5995'; // Latitude for Manila
        $lon = '120.9842'; // Longitude for Manila
        $url = "https://api.openweathermap.org/data/2.5/air_pollution?lat=$lat&lon=$lon&appid=$apiKey";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        // Extract relevant pollution data
        $pollutionData = [
            'pm2_5' => $data['list'][0]['components']['pm2_5'] ?? null,
            'pm10' => $data['list'][0]['components']['pm10'] ?? null,
            'aqi' => $data['list'][0]['main']['aqi'] ?? null,
        ];

        echo json_encode($pollutionData);

    } elseif ($category === 'climate') {
        // Fetch weather data for Manila, Philippines
        $city = 'Manila';
        $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

        $response = file_get_contents($url);
        echo $response;


    } elseif ($category === 'biodiversity') {
        // Fetch biodiversity data
        $url = "https://api.gbif.org/v1/species/search?q=threatened";

        $response = file_get_contents($url);
        if ($response === false) {
            echo json_encode(['error' => 'Unable to fetch biodiversity data']);
            exit;
        }

        $data = json_decode($response, true);

        // Extract relevant biodiversity data
        $biodiversityData = [
            'threatened_species' => $data['count'] ?? 'N/A',
            'status' => 'Threatened',
        ];

        echo json_encode($biodiversityData);

    } else {
        echo json_encode(['error' => 'Invalid category']);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Unable to fetch data', 'details' => $e->getMessage()]);
}