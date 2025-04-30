<!-- Header -->
<header class="header">
    <nav class="nav">
        <div class="nav_top">
            <a href="#" class="nav_logo">
                <img src="uploads/logo.png" class="d-inline-block align-center logo-img" alt="" loading="lazy" />
                ReGenEarth
            </a>
            <button class="button" id="form-open">Login</button>
        </div>
        <ul class="nav_items">
            <li class="nav_item">
                <a href="landing_page.php" class="nav_link">Home</a>
                <a href="about_us.php" class="nav_link">About Us</a>
            </li>
        </ul>
    </nav>
</header>

<style>
    .header {
        width: 100%;
        background: rgba(0, 28, 46, 0.95);
    }

    .nav {
        width: 100%;
        padding: 0.5rem 2rem;
    }

    .nav_top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logo-img {
        width: 50px;
        height: 50px;
        object-fit: contain;
        margin-right: 20px;
    }

    .nav_logo {
        align-items: center;
        display: flex;
        color: white;
        text-decoration: none;
        font-size: 1.2rem;
    }

    .nav_items {
        list-style-type: none;
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin: 0;
        padding: 1rem 0;
        width: 100%;
    }

    .nav_item {
        list-style: none;
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
</style>