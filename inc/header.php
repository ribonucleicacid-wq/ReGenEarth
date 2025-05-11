<!-- Header -->
<header class="header">
    <nav class="nav">
        <div class="nav_left">
            <a href="#" class="nav_logo">
                <img src="uploads/logo.png" class="logo-img" alt="" loading="lazy" />
                ReGenEarth
            </a>
        </div>
        <div class="nav_right">
            <ul class="nav_items">
                <li><a href="landing_page.php" class="nav_link">Home</a></li>
                <li><a href="about_us.php" class="nav_link">About Us</a></li>
            </ul>
            <button class="button" id="form-open">Login</button>
        </div>
    </nav>
</header>

<style>
    .header {
        width: 100%;
        background: rgba(0, 28, 46, 0.95);
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0.5rem 2rem;
    }

    .nav_left {
        display: flex;
        align-items: center;
    }

    .logo-img {
        width: 50px;
        height: 50px;
        object-fit: contain;
        margin-right: 10px;
    }

    .nav_logo {
        display: flex;
        align-items: center;
        color: white;
        text-decoration: none;
        font-size: 1.2rem;
    }

    .nav_right {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .nav_items {
        display: flex;
        list-style: none;
        gap: 1.5rem;
        margin: 0;
        padding: 0;
    }

    .nav_link {
        color: white;
        text-decoration: none;
        padding: 0.5rem 1rem;
        transition: color 0.3s ease;
    }

    .nav_link:hover {
        color: #00a2ff;
    }

    .button {
        padding: 0.5rem 1.5rem;
        border: none;
        border-radius: 4px;
        background: #00a2ff;
        color: white;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .button:hover {
        background: #0088d6;
    }

    .anim-button button:hover {
        background-color: #2d6a4f;
    }

    .anim-wrapper-2 h5 {
        font-size: 2.5rem;
        color: #fff;
    }

    .anim-wrapper-2 p {
        font-size: 1.2rem;
        color: #fff;
    }
</style>