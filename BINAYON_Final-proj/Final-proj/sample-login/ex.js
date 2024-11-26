document.addEventListener('DOMContentLoaded', function() {
    const signUpButton = document.getElementById('signupBtn');
    const loginButton = document.getElementById('loginBtn');
    const signinForm = document.getElementById('signUp');
    const loginForm = document.getElementById('logIn');

    loginButton.onclick = function(){
        signinForm.style.display = "none";
        loginForm.style.display = "block";
    }

    signUpButton.onclick = function(){
        signinForm.style.display = "block";
        loginForm.style.display = "none";
    }
});