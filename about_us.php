<?php include 'inc/head.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>About Us | ReGenEarth</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<!-- Meta Description for SEO -->
<meta name="description" content="ReGenEarth empowers youth to take action for the environment through a fun, social platform that drives real-world eco-change.">

<style>
html {
  scroll-behavior: smooth;
}
body {
  font-family: 'Segoe UI', sans-serif;
  background-color: #f8f9fa;
  background-image: url('earth.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  height: 130vh;
  color: white;
}
.hero-section {
  background: linear-gradient(135deg, #02001459, #0402186e);
  color: white;
  text-align: center;
  padding: 35px 20px;
  border-radius: 0 0 40px 40px;
}
.team-photo {
  width: 100%;
  max-width: 1150px;
  margin: 40px auto 20px;
  border-radius: 20px;
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
}
.team-members {
  margin-top: 60px;
}
.member-card {
  background: white;
  border: none;
  border-radius: 15px;
  text-align: center;
  padding: 20px;
  box-shadow: 0px 5px 15px rgba(0,0,0,0.05);
  transition: transform 0.3s;
}
.img-hover-wrapper {
  position: relative;
  width: 180px;
  height: 230px;
  margin: 0 auto;
  border-radius: 50%;
  overflow: hidden;
}
.member-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: opacity 0.4s ease-in-out;
  border-radius: 50%;
  position: absolute;
  top: 0;
  left: 0;
}
.base-img {
  z-index: 1;
  opacity: 1;
}
.hover-img {
  z-index: 2;
  opacity: 0;
}
.img-hover-wrapper:hover .hover-img {
  opacity: 1;
}
.img-hover-wrapper:hover .base-img {
  opacity: 0;
}
.section-title {
  font-family: 'Segoe UI', sans-serif;
  font-size: 2rem;
  font-weight: bold;
  color: rgb(225, 236, 243);
  margin-bottom: 20px;
}
.section-paragraph {
  font-family: 'Segoe UI', sans-serif;
  font-size: 1.1rem;
  color: white;
  line-height: 1.6;
  text-align: center;
  margin: 0 auto;
  max-width: 800px;
  text-shadow: 2px 2px 5px rgb(6, 8, 12);
}
.vision-mission-section h2,
.vision-mission-section {
  color: white;
}
.vision-mission-section p {
  color: white;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
}
footer {
  background: #02001459;
  color: white;
  padding: 20px 0;
  margin-top: 50px;
  border-top: 5px solid #0d036959;
}
.core-value-card {
  transition: transform 0.5s ease, box-shadow 0.5s ease;
  perspective: 1000px;
  transform-style: preserve-3d;
  color: white;
}
.core-value-card:hover {
  transform: rotateY(10deg) translateY(-8px) scale(1.03);
  box-shadow: 0px 8px 20px rgba(9, 8, 88, 0.329);
}
</style>
</head>
  <?php include 'inc/head.php'; ?>
    <body>
    <?php include 'inc/header.php'; ?>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">ReGenEarth</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link active">About</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Platform</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Get Involved</a></li>
        </ul>
        </div>
    </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
    <div class="container">
        <h1 class="display-5 fw-bold">Hi there! We’re ReGenEarth 🌱</h1>
        <p class="lead">Acting Locally, Thinking Globally</p>
    </div>
    </section>

    <!-- Team Photo -->
    <div class="container text-center">
    <img src="wowers.png" alt="The ReGenEarth team posing together outdoors" class="team-photo" data-aos="fade-up">
    </div>

    <!-- Team Members Section (Dynamic) -->
    <div class="container team-members">
    <h2 class="section-title text-center" data-aos="fade-up">Meet Our Team</h2>
    <div class="row g-4 justify-content-center" id="teamMembers">
        <!-- Team members will be loaded here dynamically -->
    </div>
    </div>

        <!-- About Section -->
        <div class="container my-5">
  <h2 class="section-title text-center" data-aos="fade-up">About ReGenEarth</h2>
  <p class="section-paragraph" data-aos="fade-up" data-aos-delay="100">We’re a group of students who created a fun and easy-to-use online platform that combines social media with environmental action. Our goal is to help young people like us make a real difference for the planet—starting in our own schools and communities.</p>
        </div>

        <!-- What We Do Section -->
        <div class="container my-5">
        <h2 class="section-title text-center" data-aos="fade-up">What We Do</h2>
        <p class="section-paragraph" data-aos="fade-up" data-aos-delay="100">ReGenEarth supports green habits and eco-friendly actions using technology and teamwork. We started from Batangas State University - The National Engineering University Lipa Campus, and now help build greener cities by working together. Our work supports SDG 11: Sustainable Cities and Communities.</p>
        </div>

        <!-- Our Story Section -->
        <div class="container my-5">
        <h2 class="section-title text-center" data-aos="fade-up">Our Story</h2>
        <p class="section-paragraph" data-aos="fade-up" data-aos-delay="100">ReGenEarth started as a school project. We believed that small eco-friendly actions, when shared, could inspire big change. From a classroom idea, we are now building a global community of young people passionate about the environment.</p>
        </div>

        <!-- Vision and Mission -->
        <div class="container my-5 vision-mission-section">
  <div class="row g-5">
    <div class="col-md-6" data-aos="fade-left">
      <h2 class="section-title">Our Mission</h2>
      <p>To provide a platform where innovators can engage in environmental action, amplify efforts, and create real-world impact through community and technology.</p>
    </div>
    <div class="col-md-6" data-aos="fade-right">
      <h2 class="section-title">Our Vision</h2>
      <p>To create a world where every innovator contributes to a sustainable future—one action at a time, starting with SDG 11: building sustainable cities and communities.</p>
    </div>
  </div>
</div>


    <!-- Core Values Section (Dynamic) -->
    <div class="container my-5">
    <h2 class="section-title text-center mb-5" data-aos="fade-up">Core Values – REGEN</h2>
    <div class="row g-4 justify-content-center" id="coreValues">
        <!-- Core values will be loaded here dynamically -->
    </div>
    </div>

    <!-- Footer -->
    <footer>
    <p class="text-center">&copy; 2025 ReGenEarth. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <!-- Dynamic Content Scripts -->
    <script>
    AOS.init({
        duration: 1000,
        once: true,
    });

    const teamMembers = [
        {
        name: "Noe Gonzales",
        role: "JUNGLER",
        image: "uploads/member1.png",
        hoverImage: "uploads/member11.png",
        delay: 100
        },
        {
        name: "John Lorcan Paraiso",
        role: "GOLD LANE",
        image: "uploads/member2.png",
        hoverImage: "uploads/member22.png",
        delay: 200
        },
        {
        name: "Dianne Mcalalad",
        role: "ROAMER",
        image: "uploads/member3.png",
        hoverImage: "uploads/member33.png",
        delay: 300
        },
        {
        name: "Jasmin Esperida",
        role: "MID LANER",
        image: "uploads/member4.png",
        hoverImage: "uploads/member44.png",
        delay: 400
        },
        {
        name: "Graciella Mikaela Loyola",
        role: "EXP LANER",
        image: "uploads/member5.png",
        hoverImage: "uploads/member55.png",
        delay: 500
        },
        {
        name: "Mark Daniel Castillo",
        role: "ROAMER",
        image: "uploads/member6.png",
        hoverImage: "uploads/member66.png",
        delay: 600
        }
    ];

    const coreValues = [
        {
        icon: "bi-globe-americas",
        title: "Responsibility",
        desc: "Taking ownership for protecting our planet and future.",
        delay: 100
        },
        {
        icon: "bi-lightning-charge-fill",
        title: "Empowerment",
        desc: "Turning ideas into impactful actions for change.",
        delay: 200
        },
        {
        icon: "bi-bar-chart-line-fill",
        title: "Growth",
        desc: "Learning and evolving to maximize our eco-impact.",
        delay: 300
        },
        {
        icon: "bi-people-fill",
        title: "Engagement",
        desc: "Creating opportunities for everyone to take part.",
        delay: 400
        },
        {
        icon: "bi-share-fill",
        title: "Networking",
        desc: "Connecting changemakers to amplify impact globally.",
        delay: 500
        }

    ];



    const teamContainer = document.getElementById('teamMembers');
    teamMembers.forEach(member => {
    const col = document.createElement('div');
    col.className = "col-lg-2 col-md-3 col-sm-4 col-6 d-flex";
    col.setAttribute("data-aos", "fade-up");
    col.setAttribute("data-aos-delay", member.delay);

    const card = document.createElement('div');
    card.className = "card member-card text-center w-100 h-100 shadow-sm border-0 p-3";

    const imgWrapper = document.createElement('div');
    imgWrapper.className = "img-hover-wrapper mb-3";

    const img = document.createElement('img');
    img.src = member.image;
    img.alt = member.name;
    img.className = "member-img base-img";

    const hoverImg = document.createElement('img');
    hoverImg.src = member.hoverImage;
    hoverImg.alt = member.name + " Hover";
    hoverImg.className = "member-img hover-img";

    imgWrapper.appendChild(img);
    imgWrapper.appendChild(hoverImg);

    const name = document.createElement('h5');
    name.className = "fw-bold";
    name.innerText = member.name;

    const role = document.createElement('p');
    role.className = "text-muted mb-0";
    role.innerText = member.role;

    card.appendChild(imgWrapper);
    card.appendChild(name);
    card.appendChild(role);
    col.appendChild(card);
    teamContainer.appendChild(col);
    });
    const coreContainer = document.getElementById('coreValues');
    coreValues.forEach(value => {
        coreContainer.innerHTML += `
        <div class="col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="${value.delay}">
            <div class="card h-100 text-center p-3 border-0 shadow-sm core-value-card">
            <div class="mb-3">
                <i class="bi ${value.icon}" style="font-size: 2rem; color: #2d6a4f;"></i>
            </div>
            <h5 class="fw-bold">${value.title}</h5>
            <p class="small text-muted">${value.desc}</p>
            </div>
        </div>
        `;
    });
    </script>

    </body>
    </html>
