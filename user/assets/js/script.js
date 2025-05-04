// JavaScript code for the user dashboard
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