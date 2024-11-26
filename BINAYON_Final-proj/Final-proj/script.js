document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menu-btn');
    const closeBtn = document.getElementById('close-btn');
    const navBar = document.getElementById('nav');
    const hideCard = document.getElementById('maxCont');
    const stayCard = document.getElementById('maxCard');
    const click1 = document.getElementById('ncrBtn');
    const click2 = document.getElementById('muntiBtn');
    const click3 = document.getElementById('IVABtn');
    const icon1 = document.getElementById('ffShow');
    const icon2 = document.getElementById('ffHide');
    const icon3 = document.getElementById('fsShow');
    const icon4 = document.getElementById('fsHide');
    const icon5 = document.getElementById('sShow');
    const icon6 = document.getElementById('sHide');
    const menu1 = document.getElementById('ffInnerMenu');
    const menu2 = document.getElementById('fsInnerMenu');
    const menu3 = document.getElementById('sInnerMenu');
    const showLogin = document.getElementById('showLogin');
    const displayLogin = document.getElementById('account');
    const signUpPanel = document.getElementById('signUp');
    const signUpFinal = document.getElementById('signUpFinal');
    const signIn = document.getElementById('signIn');
    const signInPanel = document.getElementById('signUpBtn');
    const nextBtn = document.getElementById('nextBtn');
    const signUpNow = document.getElementById('signUpNow');
    const logInNow = document.getElementById('logInNow');
    const cancel = document.getElementById('cancelBtn');
    const buy = document.getElementById('buyBtn');
    const addCart = document.getElementById('addtoCartBtn');

    /****USERPAGE SCRIPT****/

    document.getElementById('notif-prompt').addEventListener('click', function() {
        document.getElementById('notif-prompt').style.display = "none";
    });

    menuBtn.addEventListener('click', function(){
        menuBtn.style.display = "none";
        closeBtn.style.display = "flex";
        navBar.style.display = "flex";
    });

    closeBtn.addEventListener('click', function(){
        closeBtn.style.display = "none";
        menuBtn.style.display = "flex";
        navBar.style.display = "none";
    });

    showLogin.addEventListener('click',function(){
        if (displayLogin.style.display === "block"){
            displayLogin.style.display = "none";
            signIn.style.display = "none";
            signUpPanel.style.display = "flex";
            signUpFinal.style.display = "flex";
        } else { displayLogin.style.display = "block";}
    });

    document.querySelectorAll('.loginBtn').forEach(log => {
        log.addEventListener('click', function() {
            signUpPanel.style.display = "none";
            signUpFinal.style.display = "none";
            signIn.style.display = "flex";
        });
    });

    signInPanel.addEventListener('click', function(){
        signIn.style.display = "none";
        signUpPanel.style.display = "flex";
        signUpFinal.style.display = "flex";
    });

    nextBtn.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        if ((document.getElementById('gmail').value !== "") || (document.getElementById('fname').value !== "") || (document.getElementById('lname').value !== "")) {
            signIn.style.display = "none";
            signUpFinal.style.display = "none";
            signUpPanel.style.display = "flex";
            signUp();
        } else {
            alert("Please Fill all the fields");
        }
    });

    signUpNow.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        if ((document.getElementById('pass').value !== "") || (document.getElementById('conpass').value !== "")) {
            if(document.getElementById('pass').value === document.getElementById('conpass').value) { signUp(); }
            else { 
                alert("Password does not match");
                document.getElementById('pass').value = "";
                document.getElementById('conpass').value = "";
            }
        } else {
            alert("Please Fill all the fields");
        }
    });

    logInNow.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        if ((document.getElementById('lgmail').value !== "") || (document.getElementById('lpass').value !== "")) {
            logIn();
        } else {
            alert("Please Fill all the fields");
        }
    });

    window.addEventListener('click', function(event){
        if ((!event.target.closest(' #showLogin')) && !event.target.closest(' #account')) {
            displayLogin.style.display = "none";
        }
    });

    hideCard.addEventListener('click', function(){
        hideCard.style.display = "none";
    });

    stayCard.addEventListener('click', function(event){
        event.stopPropagation();
        hideCard.style.display = "flex";
    })

    cancel.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        hideCard.style.display = "none";
    });

    buy.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        buyItem();
    });

    addCart.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        addToCart();
    });

    click1.addEventListener('click', function(event){
        event.preventDefault();
        menu1.style.display = menu1.style.display === "block" ? "none" : "block";
        menu2.style.display = "none";
        icon3.style.display = "block";
        icon4.style.display = "none";
        if(icon2.style.display === "none"){
            icon2.style.display = "block";
            icon1.style.display = "none";
        } else {
            icon1.style.display = "block";
            icon2.style.display = "none";
        }
    });

    click2.addEventListener('click', function(event){
        event.preventDefault();
        event.stopPropagation();
        menu2.style.display = menu2.style.display === "block" ? "none" : "block";
        if(icon4.style.display === "none"){
            icon4.style.display = "block";
            icon3.style.display = "none";
        } else {
            icon3.style.display = "block";
            icon4.style.display = "none";
        }
    });

    click3.addEventListener('click', function(event){
        event.preventDefault();
        event.stopPropagation();
        menu3.style.display = menu3.style.display === "block" ? "none" : "block";
        if(icon6.style.display === "none"){
            icon6.style.display = "block";
            icon5.style.display = "none";
        } else {
            icon5.style.display = "block";
            icon6.style.display = "none";
        }
    });

let timeout;

document.addEventListener('click', function() {
    document.getElementById('homeCont').classList.remove('slide-page');
    clearTimeout(timeout);
    resetTimer();
});
document.getElementById('prevMap').addEventListener('click', function() {
    document.getElementById('homeCont').classList.remove('slide-page');
    clearTimeout(timeout);
    resetTimer();
});
document.getElementById('prevMap').addEventListener('mouseenter', function() {
    document.getElementById('homeCont').classList.remove('slide-page');
    clearTimeout(timeout);
    resetTimer();
});

function resetTimer() {
    timeout = setTimeout(function() {
        document.getElementById('homeCont').classList.add('slide-page');
        // Insert your code to handle inactivity here
    }, 3000);
}

resetTimer();
});