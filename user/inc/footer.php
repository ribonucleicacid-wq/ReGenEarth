    </div>
    <!-- End of page content -->

    <footer class="main-footer py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-uppercase mb-4">ReGenEarth</h5>
                    <p class="mb-4">Working together for a sustainable future through community-driven environmental initiatives.</p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="home.php">Home</a></li>
                        <li class="mb-2"><a href="awareness.php">Awareness</a></li>
                        <li class="mb-2"><a href="profile.php">Profile</a></li>
                        <li class="mb-2"><a href="#">About Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Resources</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="#">SDGs</a></li>
                        <li class="mb-2"><a href="#">Blog</a></li>
                        <li class="mb-2"><a href="#">Events</a></li>
                        <li class="mb-2"><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5 class="text-uppercase mb-4">Stay Updated</h5>
                    <p class="mb-3">Subscribe to our newsletter for the latest updates and eco-tips.</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your email" aria-label="Your email">
                        <button class="btn" type="button" id="subscribe-btn">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <div class="copyright py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <?php echo date('Y'); ?> ReGenEarth. All rights reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>

<style>
    .main-footer {
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.95), rgba(35, 79, 56, 0.95));
        color: var(--silver);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .main-footer h5 {
        color: var(--moonstone);
        font-weight: 600;
        position: relative;
        padding-bottom: 10px;
    }
    
    .main-footer h5:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 2px;
        background-color: var(--moonstone);
    }
    
    .main-footer a {
        color: var(--silver);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .main-footer a:hover {
        color: var(--moonstone);
        text-decoration: none;
    }
    
    .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .social-links a:hover {
        background: var(--moonstone);
        color: white;
        transform: translateY(-3px);
    }
    
    #subscribe-btn {
        background-color: var(--moonstone);
        color: white;
        border: none;
    }
    
    #subscribe-btn:hover {
        background-color: #4698AB;
    }
    
    .copyright {
        background: rgba(11, 26, 38, 0.9);
        color: var(--silver);
        font-size: 0.9rem;
    }
    
    .copyright a {
        color: var(--silver);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .copyright a:hover {
        color: var(--moonstone);
    }
    
    @media (max-width: 767px) {
        .main-footer h5:after {
            left: 50%;
            transform: translateX(-50%);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subscribeBtn = document.getElementById('subscribe-btn');
        
        if (subscribeBtn) {
            subscribeBtn.addEventListener('click', function() {
                const emailInput = this.previousElementSibling;
                const email = emailInput.value.trim();
                
                if (email && validateEmail(email)) {
                    // Show success message with SweetAlert2 if available
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Thank You!',
                            text: 'You have successfully subscribed to our newsletter.',
                            icon: 'success',
                            confirmButtonColor: '#57AFC3'
                        });
                    } else {
                        alert('Thank you for subscribing!');
                    }
                    emailInput.value = '';
                } else {
                    // Show error message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Invalid Email',
                            text: 'Please enter a valid email address.',
                            icon: 'error',
                            confirmButtonColor: '#57AFC3'
                        });
                    } else {
                        alert('Please enter a valid email address.');
                    }
                }
            });
        }
        
        function validateEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email.toLowerCase());
        }
    });
</script>
</body>
</html> 