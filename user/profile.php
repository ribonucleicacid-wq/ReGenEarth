<?php
session_start();
include '../auth/user_only.php';
include 'inc/header.php';
?>

<!-- Add SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<!-- Add Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

<style>
    /* Profile Content Wrapper */
    .profile-content {
        --moonstone: #57AFC3;
        --prussian-blue: #132F43;
        --silver: #CACFD3;
        --taupe-gray: #999A9C;
        --rich-black: #0B1A26;
        font-family: 'Inter', 'Arial', sans-serif;
        color: var(--silver);
        background-color: var(--rich-black);
        min-height: 100vh;
        padding-bottom: 40px;
        width: 100%;
        padding: 0;
        margin: 0;
        background: linear-gradient(rgba(11, 26, 38, 0.97), rgba(11, 26, 38, 0.9)), 
                  url('../assets/images/eco-banner.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    
    /* Profile Container */
    .profile-container {
        margin: 0;
        transition: all 0.5s ease;
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: auto auto;
        gap: 20px;
        grid-template-areas:
            "profile-info achievements"
            "posts posts";
        width: 100%;
        padding: 25px 30px;
        box-sizing: border-box;
    }

    /* Profile Info Container */
    .profile-info-container {
        grid-area: profile-info;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.9), rgba(35, 79, 56, 0.9));
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        height: 100%;
    }

    .profile-header {
        display: flex;
        flex-direction: column;
    }

    .profile-photo-container {
        width: 100px;
        height: 100px;
        margin: 0 auto 15px;
    }

    .profile-photo {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 3px solid var(--moonstone);
        object-fit: cover;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .profile-details {
        text-align: center;
        margin-bottom: 15px;
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: white;
    }

    .profile-bio {
        font-size: 0.85rem;
        opacity: 0.9;
        margin-bottom: 12px;
        color: var(--silver);
    }

    .profile-stats {
        display: flex;
        justify-content: center;
        margin-top: 15px;
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 15px;
    }

    .stat-item {
        text-align: center;
        flex: 1;
    }

    .stat-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--moonstone);
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--silver);
    }

    .edit-profile-btn {
        margin: 0 auto;
        font-size: 0.8rem;
        color: var(--silver);
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 6px;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.6), rgba(35, 79, 56, 0.6));
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .edit-profile-btn:hover {
        color: white;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.8), rgba(35, 79, 56, 0.8));
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    }

    /* Badges Section */
    .achievements-container {
        grid-area: achievements;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.9), rgba(35, 79, 56, 0.9));
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        height: 100%;
    }

    .section-title {
        color: var(--moonstone);
        font-size: 1.2rem;
        margin-bottom: 15px;
        font-weight: 700;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 12px;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 8px;
        color: var(--moonstone);
    }

    .badges-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .badge-item {
        text-align: center;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.8), rgba(35, 79, 56, 0.8));
        border-radius: 10px;
        padding: 20px 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .badge-item:hover {
        transform: translateY(-5px);
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.95), rgba(35, 79, 56, 0.95));
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        border: 1px solid var(--moonstone);
    }

    .badge-item:not(.locked):hover .badge-icon {
        transform: scale(1.1);
    }

    .badge-icon {
        width: 85px;
        height: 85px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }
    
    /* Bling and shine effects */
    .badge-item:not(.locked)::before {
        content: none;
    }
    
    .badge-item:not(.locked):hover::before {
        animation: none;
        opacity: 0;
    }
    
    .badge-item:not(.locked)::after {
        content: none;
    }
    
    .badge-item:not(.locked):hover::after {
        opacity: 0.9;
        animation: none;
    }
    
    /* Badge locked/unlocked states */
    .badge-item.locked .badge-icon {
        filter: brightness(0.2) contrast(0.5);
        opacity: 0.7;
    }
    
    .badge-item.locked .badge-name,
    .badge-item.locked .badge-description {
        opacity: 0.6;
    }
    
    .badge-item.locked {
        cursor: not-allowed;
        border: 1px solid rgba(255, 255, 255, 0.05);
        position: relative;
    }
    
    .badge-item.locked:hover {
        transform: none;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.7), rgba(35, 79, 56, 0.7));
        box-shadow: none;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .badge-item:not(.locked):hover .badge-icon {
        transform: scale(1.1);
        filter: none;
    }

    .badge-name {
        font-size: 0.8rem;
        color: var(--silver);
        margin-bottom: 3px;
        font-weight: 600;
    }

    .badge-description {
        font-size: 0.7rem;
        color: var(--taupe-gray);
    }
    
    /* Badge tooltips */
    .badge-tooltip {
        position: absolute;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(11, 26, 38, 0.95);
        color: var(--silver);
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.7rem;
        width: 180px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        pointer-events: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        border: 1px solid var(--moonstone);
        z-index: 100;
    }
    
    .badge-tooltip::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 6px;
        border-style: solid;
        border-color: var(--moonstone) transparent transparent transparent;
    }
    
    .badge-item:hover .badge-tooltip {
        opacity: 1;
        visibility: visible;
        bottom: 105%;
    }

    /* Posts Container */
    .posts-container {
        grid-area: posts;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.9), rgba(35, 79, 56, 0.9));
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .posts-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 12px;
    }

    .post-category-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .post-category {
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--silver);
        background: rgba(0,0,0,0.2);
    }

    .post-category.active, .post-category:hover {
        background-color: var(--moonstone);
        color: white;
    }

    /* Swiper for Posts */
    .swiper {
        width: 100%;
        height: 450px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .swiper-wrapper {
        display: flex;
        align-items: stretch;
    }
    
    .swiper-slide {
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.8), rgba(35, 79, 56, 0.8));
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(255, 255, 255, 0.1);
        height: auto;
    }

    .post-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .post-content {
        padding: 15px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .post-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        margin-bottom: 8px;
    }

    .post-description {
        font-size: 0.85rem;
        color: var(--silver);
        margin-bottom: 10px;
        flex: 1;
    }

    .post-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        font-size: 0.75rem;
        color: var(--taupe-gray);
    }

    .post-interaction {
        display: flex;
        gap: 12px;
    }

    .interaction-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .interaction-item i {
        color: var(--moonstone);
    }

    .post-date {
        font-size: 0.75rem;
    }

    .swiper-pagination {
        position: relative;
        margin-top: 15px;
    }

    .swiper-button-next, .swiper-button-prev {
        color: var(--moonstone);
        background-color: rgba(0,0,0,0.2);
        width: 35px;
        height: 35px;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 1rem;
        font-weight: bold;
    }

    /* Impact Tracker */
    .impact-tracker {
        margin: 15px 0;
        padding: 15px;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.8), rgba(35, 79, 56, 0.8));
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .impact-title {
        font-size: 0.9rem;
        color: white;
        margin-bottom: 12px;
        font-weight: 600;
        text-align: center;
    }

    .impact-stats {
        display: flex;
        gap: 12px;
    }

    .impact-item {
        flex: 1;
    }

    .impact-item h4 {
        color: var(--silver);
        font-size: 0.8rem;
        margin-bottom: 6px;
    }

    .progress {
        height: 0.7rem;
        background-color: rgba(87, 175, 195, 0.1);
        border-radius: 12px;
    }

    .progress-bar {
        background-color: var(--moonstone);
        border-radius: 12px;
        transition: width 1s ease;
        font-size: 0.7rem;
    }

    /* SweetAlert2 Customization */
    .swal2-popup {
        background: var(--prussian-blue);
        color: var(--silver);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .swal2-title, .swal2-html-container {
        color: var(--silver) !important;
    }
    
    .swal2-confirm {
        background-color: var(--moonstone) !important;
    }
    
    .swal2-deny {
        background-color: #ff6b6b !important;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .profile-container {
            max-width: 950px;
        }
        
        .badges-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
    }

    @media (max-width: 992px) {
        .profile-container {
            grid-template-columns: 1fr;
            grid-template-areas:
                "profile-info"
                "achievements"
                "posts";
            padding: 15px;
        }
        
        .badges-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .badge-icon {
            width: 75px;
            height: 75px;
        }
        
        .profile-header {
            flex-direction: column;
        }
        
        .profile-photo-container {
            margin: 0 auto 15px;
        }
        
        .profile-details, .impact-tracker {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .badges-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .badge-icon {
            width: 70px;
            height: 70px;
        }
        
        .edit-profile-btn {
            width: 80%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .badges-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .badge-icon {
            width: 60px;
            height: 60px;
        }
        
        .badge-item {
            padding: 15px 8px;
        }
        
        .post-category-tabs {
            overflow-x: auto;
            padding-bottom: 10px;
        }
        
        .post-category {
            white-space: nowrap;
            padding: 5px 10px;
            font-size: 0.75rem;
        }
    }

    .view-all-badges {
        color: var(--moonstone);
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
        transition: all 0.3s ease;
    }
    
    .view-all-badges:hover {
        color: white;
        transform: translateX(3px);
    }
    
    .view-all-badges i {
        font-size: 0.7rem;
        margin-left: 3px;
    }

    /* Badge celebration styles */
    .badge-item.celebrating {
        animation: none;
    }
    
    .badge-confetti {
        display: none;
    }
    
    @keyframes confetti-fly {
        0%, 100% { 
            opacity: 0;
        }
    }
</style>

<div class="profile-content">
    <!-- Profile Container -->
    <div class="profile-container">
        <!-- Left Top Box - Profile Info -->
        <div class="profile-info-container">
            <div class="profile-header">
                <div class="profile-photo-container">
                    <img src="../uploads/members/sample profile.png" alt="Profile Photo" class="profile-photo">
                </div>
                <div class="profile-details">
                    <h1 class="profile-name">Juan Dela Cruz</h1>
                    <p class="profile-bio">Eco-enthusiast • Planting trees and reducing waste • Working towards a sustainable future for all</p>
                </div>
                
                <div class="impact-tracker">
                    <h3 class="impact-title"><i class="fas fa-chart-line"></i> Impact Summary</h3>
                    <div class="impact-stats">
                        <div class="impact-item">
                            <h4>Carbon Saved</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="120" aria-valuemin="0" aria-valuemax="160">120 kg</div>
                            </div>
                        </div>
                        <div class="impact-item">
                            <h4>Water Conserved</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">740</div>
                        <div class="stat-label">EcoPoints</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">150</div>
                        <div class="stat-label">Followers</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">85</div>
                        <div class="stat-label">Actions</div>
                    </div>
                </div>
                
                <button class="edit-profile-btn">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </button>
            </div>
        </div>
        
        <!-- Right Top Box - Achievements -->
        <div class="achievements-container">
            <h2 class="section-title">
                <i class="fas fa-trophy"></i> Badges & Achievements
            </h2>
            <div class="badges-grid">
                <div class="badge-item">
                    <img src="../assets/images/badges/Level 1_Seedware.png" alt="Level 1 - Seedware" class="badge-icon">
                    <p class="badge-name">Seedware</p>
                    <span class="badge-description">Level 1</span>
                    <div class="badge-tooltip">Seed + Tech → The impact of your action is just starting, like planting a seed for environmental change. (0 - 500 points)</div>
                </div>
                <div class="badge-item">
                    <img src="../assets/images/badges/Level 2_Sprigineer.png" alt="Level 2 - Sprigineer" class="badge-icon">
                    <p class="badge-name">Sprigineer</p>
                    <span class="badge-description">Level 2</span>
                    <div class="badge-tooltip">Sprig + Engineer → Your impact is growing and starting to shape a better future. (500 - 1,000 points)</div>
                </div>
                <div class="badge-item locked">
                    <img src="../assets/images/badges/Level 3_Saplinix.png" alt="Level 3 - Saplinix" class="badge-icon">
                    <p class="badge-name">Saplinix</p>
                    <span class="badge-description">Level 3</span>
                    <div class="badge-tooltip">Sapling + Tech → Your impact is becoming more noticeable, helping address big environmental challenges. (1,000 - 2,000 points)</div>
                </div>
                <div class="badge-item locked">
                    <img src="../assets/images/badges/Level 4_Treechitect.png" alt="Level 4 - Treechitect" class="badge-icon">
                    <p class="badge-name">Treechitect</p>
                    <span class="badge-description">Level 4</span>
                    <div class="badge-tooltip">Tree + Builder → Your impact is strong and is helping the environment in a big way. (2,000 - 3,000 points)</div>
                </div>
                <div class="badge-item locked">
                    <img src="../assets/images/badges/Level 5_Florabyte.png" alt="Level 5 - Florabyte" class="badge-icon">
                    <p class="badge-name">Florabyte</p>
                    <span class="badge-description">Level 5</span>
                    <div class="badge-tooltip">Flower + Data → Your impact is blooming, combining nature and tech to create solutions for sustainability. (3,000 - 4,000 points)</div>
                </div>
                <div class="badge-item locked">
                    <img src="../assets/images/badges/Level 6_Canopreneur.png" alt="Level 6 - Canopreneur" class="badge-icon">
                    <p class="badge-name">Canopreneur</p>
                    <span class="badge-description">Level 6</span>
                    <div class="badge-tooltip">Canopy + Entrepreneur → Your impact is growing larger, helping ecosystems and communities thrive. (4,000 - 5,000 points)</div>
                </div>
                <div class="badge-item locked">
                    <img src="../assets/images/badges/Level 7_Gaianova.png" alt="Level 7 - Gaianova" class="badge-icon">
                    <p class="badge-name">Gaianova</p>
                    <span class="badge-description">Level 7</span>
                    <div class="badge-tooltip">Earth + Big Bang → Your impact is massive, causing a transformative change for the planet. (5,000+ points)</div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Box - Posts -->
        <div class="posts-container">
            <div class="posts-header">
                <h2 class="section-title mb-0">
                    <i class="fas fa-newspaper"></i> My Posts
                </h2>
            </div>
            
            <div class="post-category-tabs">
                <div class="post-category active">All Posts</div>
                <div class="post-category">Eco Tips</div>
                <div class="post-category">Projects</div>
                <div class="post-category">Events</div>
                <div class="post-category">Articles</div>
            </div>
            
            <!-- Swiper for Posts -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="../assets/images/eco-banner.jpg" class="post-image" alt="Sustainable Garden">
                        <div class="post-content">
                            <h3 class="post-title">Creating a Sustainable Garden</h3>
                            <p class="post-description">Learn how to create an eco-friendly garden that conserves water and supports local wildlife. This guide includes tips for composting, native plant selection, and natural pest control.</p>
                            <div class="post-meta">
                                <div class="post-interaction">
                                    <div class="interaction-item">
                                        <i class="fas fa-heart"></i> 45
                                    </div>
                                    <div class="interaction-item">
                                        <i class="fas fa-comment"></i> 12
                                    </div>
                                    <div class="interaction-item">
                                        <i class="fas fa-share"></i> 8
                                    </div>
                                </div>
                                <div class="post-date">
                                    2 days ago
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="../assets/images/eco-banner.jpg" class="post-image" alt="Renewable Energy">
                        <div class="post-content">
                            <h3 class="post-title">5 Tips for Reducing Plastic Waste</h3>
                            <p class="post-description">Simple yet effective strategies to minimize your plastic footprint. From reusable alternatives to smarter shopping choices, these tips will help you make a significant impact on the environment.</p>
                            <div class="post-meta">
                                <div class="post-interaction">
                                    <div class="interaction-item">
                                        <i class="fas fa-heart"></i> 67
                                    </div>
                                    <div class="interaction-item">
                                        <i class="fas fa-comment"></i> 23
                                    </div>
                                    <div class="interaction-item">
                                        <i class="fas fa-share"></i> 15
                                    </div>
                                </div>
                                <div class="post-date">
                                    1 week ago
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="../assets/images/eco-banner.jpg" class="post-image" alt="Community Cleanup">
                        <div class="post-content">
                            <h3 class="post-title">Community Beach Cleanup Results</h3>
                            <p class="post-description">Our recent beach cleanup event was a huge success! 50 volunteers collected over 500 pounds of trash. See the impact we made and learn how you can join our next environmental action day.</p>
                            <div class="post-meta">
                                <div class="post-interaction">
                                    <div class="interaction-item">
                                        <i class="fas fa-heart"></i> 112
                                    </div>
                                    <div class="interaction-item">
                                        <i class="fas fa-comment"></i> 34
                                    </div>
                                    <div class="interaction-item">
                                        <i class="fas fa-share"></i> 27
                                    </div>
                                </div>
                                <div class="post-date">
                                    2 weeks ago
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="../assets/images/eco-banner.jpg" class="post-image" alt="Renewable Energy">
                        <div class="post-content">
                            <h3 class="post-title">Household Renewable Energy Guide</h3>
                            <p class="post-description">Discover affordable ways to incorporate renewable energy in your home. From solar panels to energy-efficient appliances, this guide helps you reduce your carbon footprint while saving on utility bills.</p>
                            <div class="post-meta">
                                <div class="post-interaction">
                                    <div class="interaction-item">
                                        <i class="fas fa-heart"></i> 89
                                    </div>
                                    <div class="interaction-item">
                                        <i class="fas fa-comment"></i> 16
                                    </div>
                                    <div class="interaction-item">
                                        <i class="fas fa-share"></i> 24
                                    </div>
                                </div>
                                <div class="post-date">
                                    1 month ago
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script>
    // Initialize Swiper
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    
    // Post category tabs
    const categories = document.querySelectorAll('.post-category');
    categories.forEach(category => {
        category.addEventListener('click', () => {
            // Remove active class from all categories
            categories.forEach(c => c.classList.remove('active'));
            // Add active class to clicked category
            category.classList.add('active');
            // Here you would add logic to filter posts
            // For this demo, we're just showing the UI interaction
        });
    });

    // Simple badge detail modal (no sound or animations)
    document.addEventListener('DOMContentLoaded', function() {
        const unlockedBadges = document.querySelectorAll('.badge-item:not(.locked)');
        
        unlockedBadges.forEach(badge => {
            badge.addEventListener('click', function() {
                showBadgeDetail(this);
            });
        });
        
        // Make unlocked badges clickable with cursor pointer
        unlockedBadges.forEach(badge => {
            badge.style.cursor = 'pointer';
        });
        
        function showBadgeDetail(badge) {
            const badgeName = badge.querySelector('.badge-name').innerText;
            const badgeDesc = badge.querySelector('.badge-tooltip').innerText;
            const badgeImg = badge.querySelector('.badge-icon').src;
            
            Swal.fire({
                title: badgeName + ' Badge',
                html: `
                    <div style="margin-bottom: 20px;">
                        <img src="${badgeImg}" style="width: 120px; height: 120px;">
                    </div>
                    <p style="font-size: 1rem; color: var(--silver);">${badgeDesc}</p>
                `,
                background: 'linear-gradient(135deg, rgba(19, 47, 67, 0.95), rgba(35, 79, 56, 0.95))',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: 'var(--moonstone)'
            });
        }
    });
</script>

<?php include 'inc/footer.php'; ?>