<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Sample</title>
        <link href="sam.css" rel="stylesheet"/>
    </head>
    <body>
        <div class = "container">
            <div class = "fill-up-card" id="signUp">
                <h3 class = "form-title">Sign Up</h3>
                <form method="post" action = "register.php">
                <div class = "input-group">
                    <input type = "text" name = "fname" id = "fname" placeholder="Enter First Name" required>
                    <label for = "fname">First Name</label>
                </div>
                <div class="input-group">
                    <input type = "text" name = "lname" id = "lname" placeholder = "Enter Last Name" required>
                    <label for = "lname">Last Name</label>
                </div>
                <div class="input-group">
                    <input type = "email" name = "gmail" id = "gmail" placeholder = "Email Address" required>
                    <label for = "gmail">Email Address</label>
                </div>
                <div class="input-group">
                    <input type = "password" name = "pass" id = "pass" placeholder = "Password" required>
                    <label for = "pass">Password</label>
                </div>
                <input type = "submit" class = "submit-btn" name = "signUp" value = "Sign Up">
                </form>
                <p class = "or"> - or - </p>
                <div class = "links">
                    <p> Already have an account?</p>
                    <button type="button" id = "loginBtn">Log In</button>
                </div>
            </div>

            <div class = "fill-up-card" id="logIn" style="display: none;">
                <h3 class = "form-title">Log In</h3>
                <form method="post" action = "register.php">
                <div class="input-group">
                    <input type = "email" name = "gmail" id = "lgmail" placeholder = "Email Address" required>
                    <label for = "gmail">Email Address</label>
                </div>
                <div class="input-group">
                    <input type = "password" name = "pass" id = "lpass" placeholder = "Password" required>
                    <label for = "pass">Password</label>
                </div>
                <p class = "recover">
                    <a href="#">Recover Account</a>
                </p>
                <input type = "submit" class = "logAcc" name = "login" value = "Login">
                </form>
                <p class = "or"> - or - </p>
                <div class = "links">
                    <p> Don't have an account yet?</p>
                    <button type="button" id="signupBtn">Sign In</button>
                </div>
            </div>
            <script src="ex.js"></script> 
        </div>
    </body>
</html>