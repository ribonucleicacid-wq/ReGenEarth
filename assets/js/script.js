document.addEventListener("DOMContentLoaded", function () {
  const formOpenBtn = document.querySelector("#form-open"),
      home = document.querySelector(".home"),
      formContainer = document.querySelector(".form_container"),
      formCloseBtn = document.querySelector(".form_close"),
      signupBtn = document.querySelector("#signup"),
      loginBtn = document.querySelector("#login"),
      pwShowHide = document.querySelectorAll(".pw_hide"),
      resendLink = document.querySelector("#resend_code"),
      progressBar = document.querySelector("#progressBar"),
      progressLabel = document.querySelector("#progressLabel"),
      errorMessage = document.querySelector(".error-message"),
      successMessage = document.querySelector(".success-message"),
      signupForm = document.getElementById('signupForm');

  // Open and close form logic
  formOpenBtn.addEventListener("click", () => home.classList.add("show"));
  formCloseBtn.addEventListener("click", () => home.classList.remove("show"));

  // Password show/hide functionality
  pwShowHide.forEach(icon => {
      icon.addEventListener("click", () => {
          let pwInputs = icon.closest('form').querySelectorAll(".password-field");
          let icons = icon.closest('form').querySelectorAll(".pw_hide");

          pwInputs.forEach(pwInput => {
              pwInput.type = (pwInput.type === "password") ? "text" : "password";
          });

          icons.forEach(icon => {
              icon.classList.toggle("uil-eye-slash");
              icon.classList.toggle("uil-eye");
          });
      });
  });

  // Signup and Login form switching
  signupBtn.addEventListener("click", e => {
      e.preventDefault();
      formContainer.classList.add("active");
      progressBar.style.width = '50%'; // Step 1: Signup
      progressLabel.textContent = 'Step 1 of 2: Signup';
  });
  loginBtn.addEventListener("click", e => {
      e.preventDefault();
      formContainer.classList.remove("active");
  });

  // Resend verification code
  if (resendLink) {
      resendLink.addEventListener("click", function (e) {
          e.preventDefault();
          // Logic for resending verification code
          alert("Verification code resent.");
      });
  }

  // Verification form step
  if (document.querySelector('.verification_form')) {
      progressBar.style.width = '100%'; // Step 2: Verify
      progressLabel.textContent = 'Step 2 of 2: Verify Email';
  }

  // Handle form submit with AJAX
  // if (signupForm) {
  //     signupForm.addEventListener('submit', function (event) {
  //         event.preventDefault(); // Prevent default form submission

  //         const formData = new FormData(signupForm);

  //         fetch('landing_page.php', {
  //             method: 'POST',
  //             body: formData
  //         })
  //         .then(response => response.text())
  //         .then(data => {
  //             // Directly proceed without success or error messages
  //             signupForm.reset();
  //         })
  //         .catch(error => {
  //             console.error('Error:', error);
  //         });
  //     });
  // }

  // Prevent form from closing if there is an error message
  if (errorMessage) {
      formCloseBtn.style.display = 'none'; // Optionally hide or disable close button if there's an error
  }

  formCloseBtn.addEventListener('click', function () {
      if (!errorMessage) {
          formContainer.style.display = 'none'; // Only close if there's no error message
      }
  });

  // Hide error and success messages after 5 seconds
  if (errorMessage || successMessage) {
      setTimeout(() => {
          if (errorMessage) errorMessage.style.display = 'none';
          if (successMessage) successMessage.style.display = 'none';
      }, 5000); // 5000ms = 5 seconds
  }
});
