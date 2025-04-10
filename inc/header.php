<!-- Header -->
<header class="header">
    <nav class="nav">
        <a href="#" class="nav_logo">
            <img src="uploads/logo.png" class="d-inline-block align-center logo-img" alt="" loading="lazy" />
            ReGenEarth
        </a>
        <ul class="nav_items">
            <li class="nav_item">
                <a href="landing_page.php" class="nav_link">Home</a>
                <a href="about_us.php" class="nav_link">About Us</a>
            </li>
        </ul>
        <button class="button" id="form-open">Login</button>
    </nav>
</header>

<style>
    .logo-img {
        width: 50px;
        height: 50px;
        object-fit: contain;
        margin-right: 20px;
    }

    .nav_logo {
        align-items: center;
        display: flex;

    }

    .nav_items {
        list-style-type: none;
        display: flex;
        gap: 2rem;
        margin-left: auto;
        margin-right: 2rem;
    }

    .nav_item {
        list-style: none;
    }
</style>