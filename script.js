// Perform form validation
function validateForm() {
  var username = document.forms["registrationForm"]["username"].value;
  var email = document.forms["registrationForm"]["email"].value;
  var password = document.forms["registrationForm"]["password"].value;

  if (username == "" || email == "" || password == "") {
    alert("All fields must be filled out");
    return false;
  }
  // Add additional validation rules if needed
}

// Attach form validation to the form submission event
var form = document.getElementById("registrationForm");
form.addEventListener("submit", function(event) {
  if (!validateForm()) {
    event.preventDefault();
  }
});

// Perform form validation
function validateForm() {
  var email = document.forms["loginForm"]["email"].value;
  var password = document.forms["loginForm"]["password"].value;

  if (email == "" || password == "") {
    alert("All fields must be filled out");
    return false;
  }
  // Add additional validation rules if needed
}

// Attach form validation to the form submission event
var form = document.getElementById("loginForm");
form.addEventListener("submit", function(event) {
  if (!validateForm()) {
    event.preventDefault();
  }
});


window.addEventListener('DOMContentLoaded', function() {
  var loginLink = document.querySelector('.login-link');
  loginLink.addEventListener('click', function(event) {
    event.preventDefault();
    window.location.href = 'login.php';
  });
});
