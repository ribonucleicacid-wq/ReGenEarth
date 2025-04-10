<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ReGenEarth</title>
    <link rel="shortcut icon" href="../uploads/logo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

    <style>
        :root {
            --moonstone: #57AFC3;
            --prussian-blue: #132F43;
            --silver: #CACFD3;
            --taupe-gray: #999A9C;
            --rich-black: #0B1A26;
        }

        .light-mode {
            --moonstone: #489fb5;
            --prussian-blue: #e9ecef;
            --silver: #212529;
            --taupe-gray: #6c757d;
            --rich-black: #ffffff;
        }

        body {
            background-color: var(--rich-black);
            color: var(--silver);
        }

        .navbar {
            background-color: var(--prussian-blue) !important;
            color: var(--silver);
        }

        .navbar a,
        .navbar-brand,
        .nav-link {
            color: var(--silver) !important;
        }

        .nav-link:hover,
        .navbar-brand:hover {
            color: var(--moonstone) !important;
        }

        .btn-outline-secondary {
            border-color: var(--taupe-gray);
            color: var(--taupe-gray);
        }

        .btn-outline-secondary:hover {
            background-color: var(--moonstone);
            border-color: var(--moonstone);
            color: white;
        }

        .dropdown-menu {
            background-color: var(--prussian-blue);
            border-color: var(--moonstone);
        }

        .dropdown-item {
            color: var(--silver);
        }

        .dropdown-item:hover {
            background-color: var(--moonstone);
            color: white;
        }

        .form-control {
            background-color: var(--rich-black);
            color: var(--silver);
            border: 1px solid var(--taupe-gray);
        }

        .form-control::placeholder {
            color: var(--taupe-gray);
        }

        .list-group-item {
            background-color: var(--rich-black);
            color: var(--silver);
            border-color: var(--taupe-gray);
        }

        .list-group-item:hover {
            background-color: var(--moonstone);
            color: white;
        }

        .logo-img,
        .user-img,
        .search-suggest-img {
            border: 1px solid var(--moonstone);
        }

        .search-suggest-img {
            background-color: var(--prussian-blue);
        }

        .badge-light {
            background-color: var(--moonstone);
            color: white;
        }

        .logo-img {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .user-img {
            position: absolute;
            height: 27px;
            width: 27px;
            object-fit: cover;
            left: -7%;
            top: -12%;
        }

        .search-suggest-img {
            width: 3em;
            height: 3em;
            object-fit: cover;
            object-position: center center;
        }

        #search-suggest {
            max-height: 20em;
            overflow: auto;
        }

        .request_count:empty {
            display: none !important
        }

        body,
        .navbar,
        .form-control,
        .list-group-item,
        .dropdown-menu {
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
            color: var(--silver) !important;
            padding-left: 4px;
            justify-content: space-evenly;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-img {
            width: 40px;
            height: auto;
            object-fit: contain;
            border: #ffffff 1px solid;
            margin: auto;
        }

        .btn-rounded {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            font-size: 1rem;
        }

        .user-img {
            width: 30px;
            height: auto;
            object-fit: contain;
            border-radius: 50%;
            margin-right: 10px;
        }

        .ml-3 {
            font-size: 0.8rem;
        }

        .d-flex.align-items-center .btn-group {
            margin-left: 15px;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>
    </button>
    <!-- Header -->
    <nav class="main-header navbar navbar-expand-lg navbar-light bg-gradient-light border-bottom border-4 shadow">
        <div class="container px-2 px-lg-3">
            <!-- Toggle button for small screens -->
            <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Logo and Brand Name -->
            <a class="navbar-brand" href="landing_page.php">
                <img src="../uploads/logo.png" class="d-inline-block align-center logo-img" alt=""
                    loading="lazy" />ReGenEarth
            </a>

            <!-- Search Form -->
            <div id="search-form-folder" class="w-25 position-relative">
                <form action="" id="search-form">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-sm rounded-0" name="search" id="search" type="search"
                            placeholder="Search...">
                        <button class="btn btn-outline-secondary btn-sm rounded-0"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <div class="list-group position-absolute w-100 rounded-0" id="search-suggest"></div>
            </div>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="./">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="post.php"><i
                                class="far fa-plus-square mr-2"></i>Post</a></li>
                    <li class="nav-item"><a class="nav-link" href="follows.php">Follows</a></li>
                    <li class="nav-item"><a class="nav-link" href="notifications.php">Notifications</a></li>
                    <li class="nav-item"><a class="nav-link" href="awareness.php">Awareness</a></li>
                </ul>

                <!-- User Dropdown -->
                <div class="d-flex align-items-center">
                    <!-- User Dropdown + Mode Toggle -->
                    <div class="btn-group nav-link text-reset">
                        <button type="button"
                            class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon text-reset"
                            data-toggle="dropdown">
                            <span><img src="../uploads/members/sample profile.png"
                                    class="img-circle elevation-2 user-img" alt="User Image"></span>
                            <span class="ml-3">Juan Dela Cruz</span>
                            <span class="sr-only"></span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="profile.php"><span class="fa fa-user"></span> My Account</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="confirmLogout()"><span
                                    class="fas fa-sign-out-alt"></span> Logout</a>
                        </div>
                    </div>
                    <!-- Toggle Button -->
                    <button class="btn btn-sm btn-outline-secondary ml-2" id="modeToggle">
                        <i class="fas fa-moon" id="modeIcon"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Suggestion Item Template (Hidden) -->
    <noscript id="search-suggest-item-clone">
        <a href="" class="list-group-item list-group-item-action text-reset">
            <div class="d-flex w-100 align-items-center">
                <div class="col-auto text-center">
                    <img src="" alt="" class="rounded-circle border border-dark search-suggest-img">
                </div>
                <div class="col-auto flex-shrink-1 flex-grow-1">
                    <div style="line-height:1.1em">
                        <div class="fw-bolder username">Test</div>
                        <div class="fw-light email">test@sample.com</div>
                    </div>
                </div>
            </div>
        </a>
    </noscript>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        var process_ajax = false;
        $(function () {
            $('#search').on('input change', function () {
                var kw = $(this).val();
                if (kw == '') {
                    $('#search-suggest').html('');
                } else {
                    if (!!process_ajax)
                        process_ajax.abort();
                    process_ajax = $.ajax({
                        url: "search_user.php", // Add the correct URL to handle the search
                        method: 'POST',
                        data: { search: kw },
                        dataType: 'json',
                        error: function (err) {
                            console.log(err);
                            alert("Fetching Search Suggestion Failed due to unknown reason.");
                            process_ajax.abort();
                            process_ajax = false;
                        },
                        success: function (resp) {
                            $('#search-suggest').html('');
                            if (resp.status == 'success') {
                                if (Object.keys(resp.data).length > 0) {
                                    Object.keys(resp.data).map(k => {
                                        var user = resp.data[k];
                                        var anchor = $($('noscript#search-suggest-item-clone').html()).clone();
                                        anchor.find('.search-suggest-img').attr('src', user.avatar);
                                        anchor.find('.username').text(user.name);
                                        anchor.find('.email').text(user.email);
                                        anchor.attr('href', "profile.php?user_id=" + user.id);
                                        $('#search-suggest').append(anchor);
                                    });
                                }
                            } else {
                                alert("Fetching Search Suggestion Failed due to unknown reason.");
                                process_ajax.abort();
                                process_ajax = false;
                            }
                        }
                    });
                }
            });
        });

        function confirmLogout() {
            var confirmed = confirm("Are you sure you want to log out?");
            if (confirmed) {
                window.location.href = '../config.php?action=logout';
            } else {
                return false;
            }
        }

        // Dark/Light Mode Toggle
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById('modeToggle');
            const modeIcon = document.getElementById('modeIcon');
            const body = document.body;

            // Load saved mode
            if (localStorage.getItem('mode') === 'light') {
                body.classList.add('light-mode');
                modeIcon.classList.remove('fa-moon');
                modeIcon.classList.add('fa-sun');
            }

            toggleBtn.addEventListener('click', function () {
                body.classList.toggle('light-mode');
                const isLight = body.classList.contains('light-mode');

                modeIcon.classList.toggle('fa-moon', !isLight);
                modeIcon.classList.toggle('fa-sun', isLight);

                localStorage.setItem('mode', isLight ? 'light' : 'dark');
            });
        });

    </script>
</body>

</html>