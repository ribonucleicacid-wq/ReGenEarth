<?php
session_start();
include '../auth/user_only.php';
include 'inc/header.php';
?>


<!-- Add SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


<!-- Add Swiper CSS (for badges carousel if needed) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />


<!-- Internal Custom CSS -->
<style>
/* Core variables */
:root {
    --moonstone: #57AFC3;
    --prussian-blue: #132F43;
    --silver: #CACFD3;
    --taupe-gray: #999A9C;
    --rich-black: #0B1A26;
    --brunswick-green: #234F38;
    --header-height: 250px;
    --profile-image-size: 150px;
}

/* Reset and Base Styles */
.profile-container {
    max-width: 1200px;
    margin: 20px auto;
  padding: 20px;
    background: var(--rich-black);
    color: var(--silver);
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.profile-container::before {
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

/* Profile Header Enhancements */
.profile-header {
    min-height: 100px;
    padding: 20px 0;
    margin: -20px -20px 30px;
    background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80');
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, 
        rgba(19, 47, 67, 0.7) 0%,
        rgba(35, 79, 56, 0.9) 100%
    );
    z-index: 1;
}

.profile-header-content {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    color: white;
    padding: 20px;
    width: 100%;
    max-width: 600px;
}

.profile-image {
    width: var(--profile-image-size);
    height: var(--profile-image-size);
    border-radius: 50%;
    border: 5px solid rgba(255, 255, 255, 0.9);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    margin-bottom: 25px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile-image:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
}

.profile-header h2 {
    font-size: 2.5em;
    margin: 0 0 10px;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.profile-header p {
    font-size: 1.2em;
    color: var(--silver);
    margin: 0 0 25px;
    opacity: 0.9;
}

.edit-profile-btn {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 12px 30px;
    border-radius: 25px;
    color: white;
    font-size: 1.1em;
    transition: all 0.3s ease;
}

.edit-profile-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Stats Section Enhancement */
.stats {
    background: rgba(255, 255, 255, 0.15);
    margin: 0 0 30px;
    padding: 30px;
    border-radius: 20px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.stats div {
    text-align: center;
    padding: 20px;
    border-radius: 20px;
    background: rgba(19, 47, 67, 0.3);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: transform 0.3s ease;
}

.stats div:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.1);
}

.stats-value {
    font-size: 2.5em;
    font-weight: bold;
    background: linear-gradient(45deg, var(--moonstone), #90EE90);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 10px;
}

.stats-label {
    color: var(--silver);
    font-size: 1.1em;
    opacity: 0.9;
}

/* Impact Summary Enhancement */
.impact-summary {
    background: rgba(19, 47, 67, 0.3);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    margin: 30px 0;
    padding: 40px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.impact-item {
    text-align: center;
    padding: 20px;
}

.impact-item span {
    font-size: 1.2em;
    color: var(--silver);
    margin-bottom: 20px;
    display: block;
}

.progress-bar {
    height: 12px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    overflow: hidden;
    position: relative;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--moonstone), var(--brunswick-green));
    border-radius: 6px;
    position: relative;
    transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        90deg,
        rgba(255, 255, 255, 0) 0%,
        rgba(255, 255, 255, 0.3) 50%,
        rgba(255, 255, 255, 0) 100%
    );
    animation: shimmer 2s infinite;
}

/* Badges Section Enhancement */
.badges-section {
    background: rgba(19, 47, 67, 0.3);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 40px;
    margin: 30px 0;
}

.badges-title {
    font-size: 2em;
    color: white;
    text-align: center;
    margin-bottom: 40px;
    position: relative;
}

.badges-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, var(--moonstone), var(--brunswick-green));
    border-radius: 2px;
}

.badges-container {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 20px;
    position: relative;
    padding: 20px 0;
}

.badges-container::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg,
        var(--moonstone) 0%,
        var(--moonstone) calc((100% / 7) * 3),
        rgba(87, 175, 195, 0.2) calc((100% / 7) * 3),
        rgba(87, 175, 195, 0.2) 100%
    );
    z-index: 0;
}

.badge-item {
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease;
    cursor: pointer;
}

.badge-item:not(.locked):hover {
    transform: translateY(-10px);
}

.badge-item img {
    width: 100%;
    height: auto;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    padding: 10px;
    transition: all 0.3s ease;
}

.badge-item:not(.locked) img {
    filter: drop-shadow(0 5px 15px rgba(87, 175, 195, 0.3));
}

.badge-item.locked img {
    filter: grayscale(100%) brightness(40%);
}

.badge-level {
    position: absolute;
    bottom: -5px;
    right: -5px;
    width: 24px;
    height: 24px;
    background: linear-gradient(45deg, var(--moonstone), var(--brunswick-green));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.8em;
    border: 2px solid white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

/* Posts Section Enhancement */
.posts-section {
    background: rgba(19, 47, 67, 0.3);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 40px;
    margin: 30px 0;
}

.posts-title {
    font-size: 2em;
    color: white;
    margin-bottom: 30px;
    text-align: center;
}

.posts-tabs {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 40px;
}

.posts-tabs a {
    color: var(--silver);
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 20px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.1);
}

.posts-tabs a.active {
    background: linear-gradient(90deg, var(--moonstone), var(--brunswick-green));
    color: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.post-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.post-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.post-card:hover {
    transform: translateY(-10px);
}

.post-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-card:hover img {
    transform: scale(1.05);
}

.post-interactions {
    padding: 15px;
    display: flex;
    gap: 20px;
    color: var(--silver);
}

.interaction-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9em;
}

/* Responsive Enhancements */
@media (max-width: 1024px) {
    .badges-container {
        grid-template-columns: repeat(4, 1fr);
    }
    
    .impact-summary {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

@media (max-width: 768px) {
    :root {
        --header-height: 250px;
        --profile-image-size: 120px;
    }
    
    .stats {
        grid-template-columns: 1fr;
    }
    
    .badges-container {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .post-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .badges-container {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .profile-header h2 {
        font-size: 2em;
    }
}

/* Animation Keyframes */
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Special Awards Section */
.special-awards {
    position: relative;
    padding: 0 40px;
    margin-top: 40px;
}

.special-awards-container {
    overflow: hidden;
    position: relative;
}

.special-awards-wrapper {
    display: flex;
    gap: 20px;
    transition: transform 0.3s ease;
}

.special-award-item {
    flex: 0 0 calc(33.333% - 14px);
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.special-award-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.special-award-icon {
    width: 80px;
    height: 80px;
    border-radius: 15px;
    overflow: hidden;
    flex-shrink: 0;
}

.special-award-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.special-award-content {
    flex-grow: 1;
}

.special-award-content h4 {
    color: white;
    margin: 0 0 8px;
    font-size: 1.1em;
}

.special-award-content p {
    color: var(--silver);
    margin: 0;
    font-size: 0.9em;
    opacity: 0.8;
}

.special-award-date {
    font-size: 0.8em;
    color: var(--moonstone);
    margin-top: 8px;
    display: block;
}

.award-nav-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 2;
}

.award-nav-button:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-50%) scale(1.1);
}

.award-nav-prev {
    left: 0;
}

.award-nav-next {
    right: 0;
}

.section-divider {
    text-align: center;
    color: var(--silver);
    margin: 40px 0;
    position: relative;
    font-size: 20px;
    font-weight: bold;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    background: linear-gradient(90deg, var(--moonstone), var(--brunswick-green));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>


<!-- Add Page Title Section -->
<!-- <div class="page-title-section">
    <h1>Environmental Profile</h1>
    <p>Track your impact and contribution to environmental conservation</p>
</div> -->


<div class="profile-container">
  <div class="profile-header">
        <!-- Add floating particles -->
        <div class="nature-particles"></div>
        <div class="profile-header-content">
            <img src="https://picsum.photos/seed/profile/120/120" alt="Profile Picture" class="profile-image">
            <h2>Juan Dela Cruz</h2>
            <p>Eco Enthusiast</p>
            <button class="edit-profile-btn">Edit Profile</button>
        </div>
    </div>

  <div class="stats">
    <div>
            <span class="stats-value">740</span>
            <span class="stats-label">Eco Points</span>
    </div>
    <div>
            <span class="stats-value">150</span>
            <span class="stats-label">Followers</span>
    </div>
    <div>
            <span class="stats-value">85</span>
            <span class="stats-label">Actions</span>
        </div>
    </div>

    <div class="impact-summary">
        <div class="impact-item">
            <span>Climate Action</span>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 80%"></div>
            </div>
        </div>
        
        <div class="impact-item">
            <span>Pollution Prevention</span>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 60%"></div>
            </div>
        </div>
        
        <div class="impact-item">
            <span>Biodiversity Conservation</span>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 70%"></div>
            </div>
        </div>
    </div>

    <div class="badges-section">
        <h3 class="badges-title">Achievements & Recognition</h3>
        
        <!-- Badges Container -->
        <div class="badges-container">
            <!-- Level 1 - Seedware -->
            <div class="badge-item" data-name="Seedware" data-desc="Level 1 Achievement - Starting your eco journey!">
                <img class="badge-icon" src="../assets/images/badges/Level 1_Seedware.png" alt="Level 1 Badge">
                <div class="badge-level">1</div>
                <div class="badge-name" style="display:none;">Seedware</div>
                <div class="badge-tooltip" style="display:none;">Level 1 Achievement - Starting your eco journey!</div>
            </div>
            
            <!-- Level 2 - Sprigineer -->
            <div class="badge-item" data-name="Sprigineer" data-desc="Level 2 Achievement - Growing your environmental impact!">
                <img class="badge-icon" src="../assets/images/badges/Level 2_Sprigineer.png" alt="Level 2 Badge">
                <div class="badge-level">2</div>
                <div class="badge-name" style="display:none;">Sprigineer</div>
                <div class="badge-tooltip" style="display:none;">Level 2 Achievement - Growing your environmental impact!</div>
            </div>
            
            <!-- Level 3 - Saplinix -->
            <div class="badge-item" data-name="Saplinix" data-desc="Level 3 Achievement - Your environmental efforts are taking root!">
                <img class="badge-icon" src="../assets/images/badges/Level 3_Saplinix.png" alt="Level 3 Badge">
                <div class="badge-level">3</div>
                <div class="badge-name" style="display:none;">Saplinix</div>
                <div class="badge-tooltip" style="display:none;">Level 3 Achievement - Your environmental efforts are taking root!</div>
            </div>
            
            <!-- Level 4 - Treechitect (Locked) -->
            <div class="badge-item locked" data-name="Treechitect" data-desc="Level 4 Achievement - Building a greener future!">
                <img class="badge-icon" src="../assets/images/badges/Level 4_Treechitect.png" alt="Level 4 Badge">
                <div class="badge-level">4</div>
                <div class="badge-name" style="display:none;">Treechitect</div>
                <div class="badge-tooltip" style="display:none;">Level 4 Achievement - Building a greener future!</div>
            </div>
            
            <!-- Level 5 - Florabyte (Locked) -->
            <div class="badge-item locked" data-name="Florabyte" data-desc="Level 5 Achievement - Growing digital environmental awareness!">
                <img class="badge-icon" src="../assets/images/badges/Level 5_Florabyte.png" alt="Level 5 Badge">
                <div class="badge-level">5</div>
                <div class="badge-name" style="display:none;">Florabyte</div>
                <div class="badge-tooltip" style="display:none;">Level 5 Achievement - Growing digital environmental awareness!</div>
            </div>
            
            <!-- Level 6 - Canopreneur (Locked) -->
            <div class="badge-item locked" data-name="Canopreneur" data-desc="Level 6 Achievement - Reaching new heights in conservation!">
                <img class="badge-icon" src="../assets/images/badges/Level 6_Canopreneur.png" alt="Level 6 Badge">
                <div class="badge-level">6</div>
                <div class="badge-name" style="display:none;">Canopreneur</div>
                <div class="badge-tooltip" style="display:none;">Level 6 Achievement - Reaching new heights in conservation!</div>
            </div>
            
            <!-- Level 7 - Gaianova (Locked) -->
            <div class="badge-item locked" data-name="Gaianova" data-desc="Level 7 Achievement - The pinnacle of environmental stewardship!">
                <img class="badge-icon" src="../assets/images/badges/Level 7_Gaianova.png" alt="Level 7 Badge">
                <div class="badge-level">7</div>
                <div class="badge-name" style="display:none;">Gaianova</div>
                <div class="badge-tooltip" style="display:none;">Level 7 Achievement - The pinnacle of environmental stewardship!</div>
            </div>
        </div>

        <!-- Divider -->
        <div class="section-divider">Special Awards <i class="bi bi-trophy-fill" style="color: var(--moonstone);"></i></div>

        <div class="special-awards">
            <button class="award-nav-button award-nav-prev">←</button>
            <button class="award-nav-button award-nav-next">→</button>
            
            <div class="special-awards-container">
                <div class="special-awards-wrapper">
                    <div class="special-award-item">
                        <div class="special-award-icon">
                            <img src="https://picsum.photos/seed/award1/150/150" alt="Top Innovator Award">
                        </div>
                        <div class="special-award-content">
                            <h4>Top Innovator of the Month</h4>
                            <p>Recognized for outstanding innovation in waste management solutions.</p>
                            <span class="special-award-date">APRIL 2023</span>
                        </div>
                    </div>
                    
                    <div class="special-award-item">
                        <div class="special-award-icon">
                            <img src="https://picsum.photos/seed/award2/150/150" alt="Green Invention Award">
                        </div>
                        <div class="special-award-content">
                            <h4>Green Invention Award</h4>
                            <p>Awarded for creating a sustainable water purification system.</p>
                            <span class="special-award-date">JUNE 2023</span>
                        </div>
                    </div>

                    <div class="special-award-item">
                        <div class="special-award-icon">
                            <img src="https://picsum.photos/seed/award3/150/150" alt="Community Champion">
                        </div>
                        <div class="special-award-content">
                            <h4>Community Champion</h4>
                            <p>Recognized for organizing community clean-up drives across 5 cities.</p>
                            <span class="special-award-date">AUGUST 2023</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <div class="posts-section">
        <h3 class="posts-title">My Posts</h3>
    <div class="posts-tabs">
      <a href="#" class="active">All Posts</a>
      <a href="#">Climate Change</a>
      <a href="#">Pollution</a>
      <a href="#">Biodiversity Loss</a>
    </div>
    <div class="post-grid">
            <?php for($i = 0; $i < 6; $i++): ?>
        <div class="post-card">
                    <img src="https://picsum.photos/seed/post<?=$i?>/300/200" alt="Post">
                    <div class="post-interactions">
                        <div class="interaction-item">♥ 1</div>
                        <div class="interaction-item">💬 3</div>
          </div>
        </div>
      <?php endfor; ?>
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


    // Updated badge functionality with shine effect
    document.addEventListener('DOMContentLoaded', function() {
        // Badge detail modal
        const unlockedBadges = document.querySelectorAll('.badge-item:not(.locked)');
        const lockedBadges = document.querySelectorAll('.badge-item.locked');
       
        unlockedBadges.forEach(badge => {
            badge.addEventListener('click', function() {
                showBadgeDetail(this, false);
            });
        });
       
        lockedBadges.forEach(badge => {
            badge.addEventListener('click', function() {
                showBadgeDetail(this, true);
            });
        });
        
        function showBadgeDetail(badge, isLocked) {
            const badgeName = badge.querySelector('.badge-name').innerText;
            const badgeDesc = badge.querySelector('.badge-tooltip').innerText;
            const badgeImg = badge.querySelector('.badge-icon').src;
           
            Swal.fire({
                title: badgeName + ' Badge',
                html: `
                    <div style="margin-bottom: 25px; position: relative; overflow: hidden;">
                        <img src="${badgeImg}" style="width: 180px; height: 180px; ${isLocked ? 'filter: grayscale(100%) opacity(0.5);' : 'filter: drop-shadow(0 6px 12px rgba(0,0,0,0.15));'}">
                        ${!isLocked ? '<div class="badge-shine"></div>' : ''}
                    </div>
                    <div style="font-size: 1.1rem; color: #333; background-color: ${isLocked ? '#f8f8f8' : '#f0f9ff'}; padding: 15px; border-radius: 10px; max-width: 400px; margin: 0 auto;">
                        ${isLocked ? '<span style="font-weight: bold; color: #888;">🔒 This badge is still locked!</span><br><br>' : '<span style="font-weight: bold; color: #4CAF50;">🏆 Congratulations!</span><br><br>'}
                        ${badgeDesc}
                    </div>
                `,
                background: 'white',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#87CEEB',
                width: '500px',
                padding: '2em',
                didOpen: () => {
                    // Add shine animation to badge in modal
                    if (!isLocked) {
                        const shineElement = document.querySelector('.badge-shine');
                        if (shineElement) {
                            shineElement.style.cssText = `
                                position: absolute;
                                top: -50%;
                                left: -60%;
                                width: 30px;
                                height: 200%;
                                background: rgba(255, 255, 255, 0.6);
                                transform: rotate(30deg);
                                filter: blur(6px);
                                animation: shine-animation 2.5s infinite;
                            `;
                            
                            // Add keyframes for animation
                            const style = document.createElement('style');
                            style.textContent = `
                                @keyframes shine-animation {
                                    0% { left: -60%; }
                                    100% { left: 150%; }
                                }
                            `;
                            document.head.appendChild(style);
                        }
                    }
                }
            });
        }
    });

    // Add to your existing JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const progressFill = entry.target;
                    const width = progressFill.style.width;
                    progressFill.style.setProperty('--progress-width', width);
                    progressFill.style.width = '0';
                    setTimeout(() => {
                        progressFill.style.width = width;
                    }, 100);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.progress-fill').forEach(fill => {
            observer.observe(fill);
        });
    });

    // Add this to your existing document.addEventListener
    document.addEventListener('DOMContentLoaded', function() {
        // Special Awards Navigation
        const awardsWrapper = document.querySelector('.special-awards-wrapper');
        const prevButton = document.querySelector('.award-nav-prev');
        const nextButton = document.querySelector('.award-nav-next');
        let currentPosition = 0;
        const itemWidth = 33.333; // percentage width of each item

        function updateAwardsPosition() {
            awardsWrapper.style.transform = `translateX(${currentPosition}%)`;
        }

        prevButton.addEventListener('click', () => {
            if (currentPosition < 0) {
                currentPosition += itemWidth;
                updateAwardsPosition();
            }
        });

        nextButton.addEventListener('click', () => {
            if (currentPosition > -(itemWidth * 2)) { // Show 3 items at a time
                currentPosition -= itemWidth;
                updateAwardsPosition();
            }
        });
    });

    // Add scroll animation
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.stats, .impact-summary, .badges-section, .special-awards, .posts-section');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        sections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'all 0.6s ease-out';
            observer.observe(section);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const particlesContainer = document.querySelector('.nature-particles');
        const particleCount = 20;

        // Create particles
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'nature-particle';
            
            // Random positioning and animation delay
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.opacity = Math.random() * 0.5 + 0.3;
            
            particlesContainer.appendChild(particle);
        }
    });
</script>

<?php include 'inc/footer.php'; ?>