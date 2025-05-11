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

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

  <link href="assets/css/styles.css" rel="stylesheet">

  <!-- Meta Description for SEO -->
  <meta name="description"
    content="ReGenEarth empowers youth to take action for the environment through a fun, social platform that drives real-world eco-change.">

  <style>
    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #132F43;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      color: white;
      overflow-y: auto;
      height: auto;
      min-height: 100vh;
    }

    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
    }

    body {
      background-color: #132F43;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }

    main {
      flex: 1;
    }

    footer {
      background: #02001459;
      color: white;
      padding: 20px 0;
      margin-top: 50px;
      border-top: 5px solid #0d036959;
      position: relative;
      width: 100%;
      text-align: center;
      box-sizing: border-box;
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

    .image-container {
      position: relative;
      width: 100%;
      height: 200px;
      overflow: hidden;
    }

    .image-container img {
      transition: transform 0.5s ease, opacity 0.5s ease;
      object-fit: cover;
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
    }

    .image-container:hover .default-img {
      opacity: 0;
      transform: scale(1.1);
    }

    .image-container:hover .hover-img {
      opacity: 1;
      transform: scale(1.1);
    }

    .hover-img {
      opacity: 0;
      z-index: 0;
    }

    .default-img {
      z-index: 10;
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

    .vision-mission-section {
      color: white;
      padding-left: 2.5rem;
      padding-right: 2.5rem;
    }

    .vision-mission-section h2 {
      color: white;
    }

    .vision-mission-section p {
      color: white;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
    }

    .card {
      width: 100%;
      height: 200px;
      margin: 1rem auto;
      perspective: 1000px;
      cursor: pointer;
    }

    .card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.6s;
      transform-style: preserve-3d;
    }

    .card:hover .card-inner {
      transform: rotateY(180deg);
    }

    .card-front,
    .card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 0.5rem;
    }

    .card-front {
      background: #ffffff;
      color: #414141;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card-back {
      background: #134321;
      color: #ffffff;
      display: flex;
      transform: rotateY(180deg);
      padding: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
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
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <h1 class="display-5 fw-bold">Hi there! We’re ReGenEarth</h1>
      <p class="lead">Acting Locally, Thinking Globally</p>
    </div>
  </section>
  <main>
    <!-- Team Photo -->
    <div class="container text-center">
      <img src="assets/images/ReGenEarth Team.png" alt="The ReGenEarth team posing together outdoors" class="team-photo"
        data-aos="fade-up">
    </div>

    <!-- Team Members Section (Dynamic) -->
    <!-- Swiper container -->
    <h2 class="section-title text-center w-full" data-aos="fade-up">Meet Our Team</h2>
    <div class="swiper mySwiper flex justify-center py-10">
      <div class="swiper-wrapper justify-center" id="team-wrapper">
        <!-- Slides injected by JS -->
      </div>
    </div>


    <!-- About Section -->
    <div class="container my-5">
      <h2 class="section-title text-center" data-aos="fade-up">About ReGenEarth</h2>
      <p class="section-paragraph" data-aos="fade-up" data-aos-delay="100">We’re a group of students who created a fun
        and
        easy-to-use online platform that combines social media with environmental action. Our goal is to help young
        people
        like us make a real difference for the planet—starting in our own schools and communities.</p>
    </div>

    <!-- What We Do Section -->
    <div class="container my-5">
      <h2 class="section-title text-center" data-aos="fade-up">What We Do</h2>
      <p class="section-paragraph" data-aos="fade-up" data-aos-delay="100">ReGenEarth supports green habits and
        eco-friendly actions using technology and teamwork. We started from Batangas State University - The National
        Engineering University Lipa Campus, and now help build greener cities by working together. Our work supports SDG
        11: Sustainable Cities and Communities.</p>
    </div>

    <!-- Our Story Section -->
    <div class="container my-5">
      <h2 class="section-title text-center" data-aos="fade-up">Our Story</h2>
      <p class="section-paragraph" data-aos="fade-up" data-aos-delay="100">ReGenEarth started as a school project. We
        believed that small eco-friendly actions, when shared, could inspire big change. From a classroom idea, we are
        now
        building a global community of young people passionate about the environment.</p>
    </div>

    <!-- Vision and Mission -->
    <div class="container my-5 vision-mission-section">
      <div class="row g-5">
        <div class="col-md-6" data-aos="fade-left">
          <h2 class="section-title">Our Mission</h2>
          <p>To provide a platform where innovators can engage in environmental action, amplify efforts, and create
            real-world impact through community and technology.</p>
        </div>
        <div class="col-md-6" data-aos="fade-right">
          <h2 class="section-title">Our Vision</h2>
          <p>To create a world where every innovator contributes to a sustainable future—one action at a time, starting
            with SDG 11: building sustainable cities and communities.</p>
        </div>
      </div>
    </div>


    <!-- Core Values Section (Dynamic) -->
    <div class="container my-5">
      <h2 class="section-title text-center mb-5" data-aos="fade-up">Core Values - REGEN</h2>
      <div class="row g-4 col g-4 justify-content-center" id="coreValues">
        <!-- Core values will be loaded here dynamically -->
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    <p class="text-center">&copy; 2025 ReGenEarth. All rights reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

  <!-- AOS Animation JS -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

  <!-- Dynamic Content Scripts -->
  <script>
    AOS.init({
      duration: 1000,
      once: true,
    });
    const imageBasePath = "assets/images/ReGenEarth_Members/";

    const teamMembers = [
      {
        name: "John Lorcan Paraiso",
        role: "Chief Technology Officer",
        image: "Lorcan.png",
        hoverImage: "Lorcan_Hover.png",
        delay: 100
      },
      {
        name: "Mark Daniel Castillo",
        role: "Chief Operating Officer",
        image: "Daniel.png",
        hoverImage: "Daniel_Hover.png",
        delay: 200
      },
      {
        name: "Noe Gonzales",
        role: "Chief Executive Officer",
        image: "Noe.png",
        hoverImage: "Noe_Hover.png",
        delay: 300
      },
      {
        name: "Jasmin Esperida",
        role: "Chief Product Officer",
        image: "Jasmin.png",
        hoverImage: "Jasmin_Hover.png",
        delay: 400
      },
      {
        name: "Graciella Mikaela Loyola",
        role: "Chief Financial Officer",
        image: "Graciella.png",
        hoverImage: "Graciella_Hover.png",
        delay: 500
      },
      {
        name: "Dianne Macalalad",
        role: "Chief Marketing Officer",
        image: "Dianne.png",
        hoverImage: "Dianne_Hover.png",
        delay: 600
      }
    ];

    const wrapper = document.getElementById("team-wrapper");

    teamMembers.forEach(member => {
      const slide = document.createElement("div");
      slide.className = "swiper-slide w-[211.5px] h-[280px] mr-6 flex flex-col";

      slide.innerHTML = `
        <div class="rounded-xl overflow-hidden shadow-md bg-white group transition-all duration-300 h-full flex flex-col justify-between">
          <div class="image-container">
            <img src="${imageBasePath + member.image}" alt="${member.name}" class="default-img" />
            <img src="${imageBasePath + member.hoverImage}" alt="${member.name} Hover" class="hover-img" />
          </div>
          <div class="px-3 py-2 text-center bg-white min-h-[80px] flex flex-col justify-center">
            <p class="text-sm font-bold text-black leading-tight">${member.name}</p>
            <p class="text-xs text-gray-600 mt-0.5">${member.role}</p>
          </div>
        </div>
      `;
      slide.setAttribute("data-aos", "fade-up");
      slide.setAttribute("data-aos-delay", member.delay);

      wrapper.appendChild(slide);
    });

    new Swiper(".mySwiper", {
      slidesPerView: "auto",
      spaceBetween: 24,
      grabCursor: true
    });

    const coreValues = [
      {
        icon: "bi-globe-americas",
        title: "RESPONSIBILITY",
        desc: "Taking ownership for protecting our planet and future.",
        delay: 100
      },
      {
        icon: "bi-lightning-charge-fill",
        title: "EMPOWERMENT",
        desc: "Turning ideas into impactful actions for change.",
        delay: 200
      },
      {
        icon: "bi-bar-chart-line-fill",
        title: "GROWTH",
        desc: "Learning and evolving to maximize our eco-impact.",
        delay: 300
      },
      {
        icon: "bi-people-fill",
        title: "ENGAGEMENT",
        desc: "Creating opportunities for everyone to take part.",
        delay: 400
      },
      {
        icon: "bi-share-fill",
        title: "NETWORKING",
        desc: "Connecting changemakers to amplify impact globally.",
        delay: 500
      }
    ];

    const coreContainer = document.getElementById('coreValues');
    let html = '';

    coreValues.forEach(value => {
      html += `
        <div class="col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="${value.delay}">
        <div class="card">
          <div class="card-inner">
            <div class="card-front">
              <div class="icon d-flex flex-column align-items-center justify-content-center">
                <i class="bi ${value.icon}" style="font-size: 3rem; color: #134321;"></i>
                <h5 class="title mt-3">${value.title}</h5>
              </div>
            </div>
            <div class="card-back">
              <div class="content px-3">
                <p class="small text-center">${value.desc}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
    });

    coreContainer.innerHTML = html;
  </script>

</body>

</html>