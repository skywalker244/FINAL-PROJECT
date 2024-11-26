<?php
session_start();
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Pastry Shop | Userpage</title>
        <link href="styles.css" rel="stylesheet"/>
        <link href="user.css" rel="stylesheet"/>

        <link rel="icon" href="resource/logo.ico" type="image/ico">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/9bd5c7f2ea.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <section id="noEntry">
            <div class="icon">
                <i class="fa-solid fa-person-through-window"></i>
            </div>
            <p>Oops! You must <a href="index.php">log in</a> first to access this.</p>
        </section>
        <header id="userNav" style="position: relative;">
            <a href="#home" class="logo"><div class="logo-icon"></div></a>
            <div class="navbar" id="nav">
                <div class="web-links">
                    <a href="index.php#product" class="nav-link">Our Products</a>
                    <a href="index.php#service" class="nav-link">Services</a>
                    <a href="index.php#about" class="nav-link">About Us</a>
                </div>
            </div>
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="close-btn" class="fa-solid fa-xmark"></div>
        </header>
        <section id="user">
            <div id="notif-prompt" style="display: none;">
                <p id="notification"> this is sample text.</p>
            </div>
            <div class="user-header">
                <div style="text-transform:capitalize;"><?php echo $_SESSION["username"];?></div>
                <div class="user-info">
                    <button id="profile"><i class="fa-solid fa-circle-user"></i>Profile</button>
                    <button id="logOut" onclick="logOut()"><i class="fa-solid fa-right-from-bracket"></i>Log Out</button>
                </div>
            </div>
            <div class="link-container">
                <div class="nav-container">
                    <div class="side-nav">
                        <div id="orderBtn" onclick="showOrder()">Order</div>
                        <div id="cartBtn" onclick="showCart()">Basket</div>
                        <div id="transactionBtn" onclick="showTransac()">Transactions</div>
                    </div>
                </div>
                <div class="function-container">
                    <div class="order-page" id="orderPage" style="display: none;">
                        <h3 class="opt-title">Orders</h3>
                        <div class="no-order" style="display: none;">
                            <div class="no-order-img"></div>
                            <div class="no-order-text">
                                <p>You have not made any orders yet. To order <button onclick="orderProd()">CLICK HERE</button></p>
                            </div>
                        </div>
                        <div class="order-made">
                            <div class="order-collection">

                            </div>
                        </div>
                    </div>
                    <div class="cart-page" id="cartPage" style="display: none;">
                        <h3 class="opt-title" id="secTitle">Basket</h3>
                        <div class="no-order" id="noOrder" style="display: none;">
                            <div class="no-order-img"></div>
                            <div class="no-order-text">
                                <p>You have not made any orders yet. To order <button onclick="orderProd()">CLICK HERE</button></p>
                            </div>
                        </div>
                        <div class="checkout-container" id="checkoutContainer">
                            <div class="buttons">
                                <button id="selectAll" onclick="selectAll(this)">Select All</button>
                                <button id="deleteSelected" onclick="deleteSelected()">Delete</button>
                            </div>
                            <div class="cart-display">
                                <form action="" method="post" id="cartContainer">
                                    
                                </form>
                                <div class="checkout" >
                                    <button id="checkoutBtn" onclick="checkSelected()">Check Out</button>
                                </div>
                            </div>
                        </div>
                        <h3 class="opt-title" id="optTitle" style="display: none;">Order Confirmation</h3>
                        <div class="confirm-order" id="confirmOrder" style="display: none;">
                            <div class="info">
                                <h5>Personal Information</h5>
                                <button id="editNameBtn" onclick="gotoEditInfo()"><i class="fa-solid fa-pen-to-square"></i></button>
                                <form action="" method="post" id="infoContainer">
                                    
                                </form>
                                <p id="displayText" style="opacity: 0;">*Contact Number and Address must not be empty.</p>
                                <div class="con-button">
                                    <button id="conBtn" onclick="confirmAction()">Confirm</button>
                                </div>
                            </div>
                            <div class="order-info">
                                <h5>Order List</h5>
                                <div class="order-box">
                                    <div class="order-box-box">

                                    </div>
                                </div>
                                <div class="price-detail">
                                    <p><strong id="orderTotal"> </strong></p>
                                </div>
                                <div class="checkout-order">
                                    <button id="confirmOrderBtn" onclick="uploadOrder()">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="transac-page" id="transacPage" style="display: none;">
                        <h3 class="opt-title">Transaction History</h3>
                        <div class="no-order" id="noTransac" style="display: none;">
                            <div class="no-order-img"></div>
                            <div class="no-order-text">
                                <p>You have not made any orders yet. To order <button onclick="orderProd()">CLICK HERE</button></p>
                            </div>
                        </div>
                        <div class="transac-container">
                            <div class="transac-card" id="transacCard">

                            </div>
                        </div>
                    </div>
                    <div class="profile-page" id="profilePage">
                        <h3 class="opt-title">Profile</h3>
                        <div class="profile-container">
                            <div class="user-nav">
                                <button class="profile-nav-btn" id="generalBtn">General</button>
                                <button class="profile-nav-btn" id="securityBtn">Settings</button>
                            </div>
                            <div class="prof-card">
                                <div class="display-page" id="genPage" style="display: none;">
                                    <div class="gen-card">
                                        <div class="gen-info" id="profileForm">
                                            
                                        </div>
                                        <div class="gen-fav">
                                            <h4>Favorites</h4>
                                            <div id="noFav" style="display: none;">
                                                <div class="no-fav"></div>
                                                <p>You have no item in your favorites.</p>
                                            </div>
                                            <div class="fav-container">

                                            </div>
                                        </div>
                                        <div class="edit-info" id="editInfoForm" style="display: none;">
                                                
                                        </div>
                                    </div>
                                </div>
                                <div class="display-page" id="secPage" style="display: none;">
                                    <h4>Security</h4>
                                    <div class="sec-container">
                                        <div>
                                            <div class="left-card">
                                                <div class="input-group">
                                                    <div id="h-username" style="display: none;"></div>
                                                    <label for="userName">Username</label>
                                                    <button id="clickUser" data-target="uName" data-target-1="h-username" onclick="editInput(this)">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <input type="text" name="uname" id="uName" placeholder="set" disabled="true" onclick="changeUser()">
                                                </div>
                                                <div class="input-group">
                                                    <label for="currPass">Current Password</label>
                                                    <button id="clickCurrPass" data-target="currPass" onclick="editInput(this)">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <input type="password" name="currpass" id="currPass" autocomplete="off" disabled="true" onclick="changeUser()">
                                                </div>  
                                            </div>
                                            <div class="right-card">
                                                <div class="input-group">
                                                    <label for="newPass">New Password</label>
                                                    <input type="password" name="newpass" id="newPass" autocomplete="off" disabled="true">
                                                </div>
                                                <div class="input-group">
                                                    <label for="conPass">Confirm Password</label>
                                                    <input type="password" name="conpass" id="conPass" autocomplete="off" disabled="true" onclick="submitPass()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="acc-management">
                                        <button id="delAcc" onclick="delAcc()">Delete Account</button>
                                        <div class="r-btn">
                                            <button id="undoChanges">Cancel</button>
                                            <button id="confirmPass" onclick="inputNewPass()" style="display: none;">Confirm</button>
                                            <button id="savePass" disabled="true" onclick="finalPass()">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="script.js"></script>
        <script>
            var checkBoxes = document.querySelectorAll('.checkBox');
            var selectBtn = document.getElementById('selectAll');
            var deleteBtn = document.getElementById('deleteSelected');
            var checkoutBtn = document.getElementById('checkoutBtn');
            var displayOrder = document.getElementById('confirmOrder');
            var checkOutContainer = document.getElementById('checkoutContainer');
            var optTitle = document.getElementById('optTitle');
            var secTitle = document.getElementById('secTitle');
            var displayText = document.getElementById('displayText');
            var confirmBtn = document.getElementById('conBtn');
            var confirmOrder = document.getElementById('confirmOrderBtn');
            var orderBtn = document.getElementById('orderBtn');
            var cartBtn = document.getElementById('cartBtn');
            var transactionBtn = document.getElementById('transactionBtn');
            var orderPage = document.getElementById('orderPage');
            var cartPage = document.getElementById('cartPage');
            var transacPage = document.getElementById('transacPage');
            var profileBtn = document.getElementById('profile');
            var profilePage = document.getElementById('profilePage');

            var genBtn = document.getElementById('generalBtn');
            var secBtn = document.getElementById('securityBtn');
            var genPage = document.getElementById('genPage');
            var secPage = document.getElementById('secPage');

            confirmOrder.disabled = true;

            window.onload = function() {
                var xar = new XMLHttpRequest();
                xar.open("POST", "getproduct.php", true);
                xar.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xar.send("user=1");
                xar.onload = function() {
                    if (xar.status === 200) {
                        if (parseInt(xar.responseText, 10) === 0) {
                            let errorMessage = "Error: Unable to process request.";
                            notif(errorMessage);
                            document.getElementById('userNav').style.display = "none";
                            document.getElementById('user').style.display = "none";
                            document.getElementById('noEntry').style.display = "flex";
                        } else {
                            document.getElementById('userNav').style.display = "flex";
                            document.getElementById('user').style.display = "block";
                            document.getElementById('noEntry').style.display = "none";
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "getproduct.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.send("confirmCart=1");
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    if (xhr.responseText == "0" || xhr.responseText == 0) {
                                        checkPurchase();
                                    } else {
                                        var xhr1 = new XMLHttpRequest();
                                        xhr1.open("POST", "getproduct.php", true);
                                        xhr1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr1.send("getCart=1");
                                        xhr1.onload = function() {
                                            if (xhr1.status === 200) {
                                                if (xhr1.responseText == "0" || xhr1.responseText == 0) {
                                                    defaultPage();
                                                    getData();
                                                    getFav();
                                                    getUname();
                                                } else {
                                                    cartClicked();
                                                }
                                            }
                                        };
                                    }
                                }
                            };
                        }
                    }
                }
            };

            function checkPurchase() {
                var xhr1 = new XMLHttpRequest();
                xhr1.open("POST", "getproduct.php", true);
                xhr1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr1.send("getter=1");
                xhr1.onload = function() {
                    if (xhr1.status === 200) {
                        if (xhr1.responseText == "0" || xhr1.responseText == 0) {
                            defaultPage();
                            getData();
                            getFav();
                            getUname();
                        } else {
                            document.getElementById('profilePage').style.display = "none";
                            document.getElementById('cartPage').style.display = "flex";
                            document.getElementById('secTitle').style.display = "none";
                            document.getElementById('checkoutContainer').style.display = "none";
                            document.getElementById('optTitle').style.display = "block";
                            displayOrder.style.display = "flex";
                            document.querySelector('.order-box-box').innerHTML = xhr1.responseText;
                            displayDetails();
                        }
                    }
                };
            };

            orderBtn.addEventListener('click', function(){
                orderBtn.style.background = "#FFB22C";
                transactionBtn.style.background = "var(--sec-color)";
                cartBtn.style.background = "var(--sec-color)";
                orderBtn.style.background = "#FFB22C";
                cartPage.style.display = "none";
                transacPage.style.display = "none";
                profilePage.style.display = "none";
                orderPage.style.display = "flex";
            });

            cartBtn.addEventListener('click', function(){
                orderBtn.style.background = "var(--sec-color)";
                transactionBtn.style.background = "var(--sec-color)";
                cartBtn.style.background = "#FFB22C";
                transacPage.style.display = "none";
                profilePage.style.display = "none";
                orderPage.style.display = "none";
                cartPage.style.display = "flex";
                checkOutContainer.style.display = "block";
                secTitle.style.display = "flex";
                optTitle.style.display = "none";
                displayOrder.style.display = "none";
                document.querySelector('.order-box-box').innerHTML = "";
            });

            transactionBtn.addEventListener('click', function(){
                orderBtn.style.background = "var(--sec-color)";
                cartBtn.style.background = "var(--sec-color)";
                transactionBtn.style.background = "#FFB22C";
                profilePage.style.display = "none";
                orderPage.style.display = "none";
                cartPage.style.display = "none";
                transacPage.style.display = "flex";
            });

            profileBtn.addEventListener('click', function(){
                profilePage.style.display = "flex";
                orderPage.style.display = "none";
                cartPage.style.display = "none";
                transacPage.style.display = "none";
                defaultPage();
                getData();
                getFav();
                getUname();
            });

            document.querySelectorAll('.resizeBtn').forEach(button => {
                button.addEventListener('click', function(){
                    const targetId = this.getAttribute('data-target');
                    const showAll = document.getElementById(targetId);

                    if (showAll.style.height === "50px"){
                        showAll.style.height = "350px";
                        showAll.style.background = "var(--compli-color)";
                        showAll.style.borderBottom = "none";
                        this.classList.toggle('active');
                    } else {
                        showAll.style.height = "50px";
                        showAll.style.background = "transparent";
                        showAll.style.borderBottom = "1px solid #afafaf";
                        this.classList.remove('active');
                    }
                    document.querySelectorAll('.date-card').forEach(drop => {
                        if (drop.id !== targetId){
                            drop.style.height = "50px";
                            drop.style.background = "transparent";
                            drop.style.borderBottom = "1px solid #afafaf";
                        }
                    });
                    document.querySelectorAll('.resizeBtn').forEach(btn => {
                        if (btn !== this){
                            btn.classList.remove('active');
                        }
                    });
                });
            });
            window.addEventListener('click', function(event){
                if (!event.target.closest('.resizeBtn')) {
                    document.querySelectorAll('.date-card').forEach(drop => {
                        drop.style.height = "50px";
                        drop.style.background = "transparent";
                        drop.style.borderBottom = "1px solid #afafaf";
                    });
                    document.querySelectorAll('.resizeBtn').forEach(btn => {
                        btn.classList.remove('active');
                    });
                }
            });

            genBtn.addEventListener('click', function() {
                if (genPage.style.display === "none") {
                    genPage.style.display = "block";
                    secPage.style.display = "none";
                    genBtn.style.background = "var(--compli-color)";
                    genBtn.style.color = "var(--sec-color)";
                    genBtn.style.borderRight = "1px solid var(--sec-color)";
                    secBtn.style.background = "transparent";
                    secBtn.style.color = "var(--compli-color)";
                    secBtn.style.borderRight = "1px solid #999999";
                }
            });

            secBtn.addEventListener('click', function() {
                if (secPage.style.display === "none") {
                    secPage.style.display = "block";
                    genPage.style.display = "none";
                    secBtn.style.background = "var(--compli-color)";
                    secBtn.style.color = "var(--sec-color)";
                    secBtn.style.borderRight = "1px solid var(--sec-color)";
                    genBtn.style.background = "transparent";
                    genBtn.style.color = "var(--compli-color)";
                    genBtn.style.borderRight = "1px solid #999999";
                }
            });
            
            ///////////////      FUNCTIONS     ///////////////////

            function notif(text) {
                const showPrompt = document.getElementById('notif-prompt');
                showPrompt.style.display = "flex";
                if (showPrompt.style.display === "flex") {            
                    document.getElementById('notification').innerHTML = text;
                    
                    setTimeout(function() {
                        showPrompt.style.display = "none";
                    }, 3000); 
                }
            }

            function getData() {
                var profile = new XMLHttpRequest();
                profile.open("POST", "getproduct.php", true);
                profile.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                profile.send("getUserInfo=1&mode=0");
                profile.onload = function() {
                    if (profile.status === 200) {
                        document.getElementById('profileForm').innerHTML = profile.responseText;
                    } else {
                        notif(profile.responseText);
                    }
                };
            }

            function getFav() {
                var fav = new XMLHttpRequest();
                fav.open("POST", "getproduct.php", true);
                fav.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                fav.send("getFavs=1");
                fav.onload = function() {
                    if (fav.status === 200) {
                        document.querySelector('.fav-container').innerHTML = fav.responseText;
                        if(document.querySelector('.fav-card')) {
                            document.getElementById('noFav').style.display = "none";
                            document.getElementById('genPage').style.overflowY = "scroll";
                        } else {
                            document.getElementById('noFav').style.display = "flex";
                            document.getElementById('genPage').style.overflowY = "hidden";
                        }
                    } else {
                        notif(fav.responseText);
                    }
                };
                if(document.querySelector('.fav-card')) {
                    document.getElementById('noFav').style.display = "none";
                    document.getElementById('genPage').style.overflowY = "scroll";
                } else {
                    document.getElementById('noFav').style.display = "flex";
                    document.getElementById('genPage').style.overflowY = "hidden";
                }
            }
            
            function defaultPage() {
                document.getElementById('cartPage').style.display = "none";
                document.getElementById('secTitle').style.display = "none";
                document.getElementById('checkoutContainer').style.display = "none";
                document.getElementById('optTitle').style.display = "none";
                displayOrder.style.display = "none";
                document.querySelector('.order-box-box').innerHTML = "";
                document.getElementById('profilePage').style.display = "flex";
                document.getElementById('genPage').style.display = "flex";
            }

            function cartClicked() {
                orderBtn.style.background = "var(--sec-color)";
                transactionBtn.style.background = "var(--sec-color)";
                cartBtn.style.background = "#FFB22C";
                transacPage.style.display = "none";
                profilePage.style.display = "none";
                orderPage.style.display = "none";
                cartPage.style.display = "flex";
                checkOutContainer.style.display = "block";
                secTitle.style.display = "flex";
                optTitle.style.display = "none";
                displayOrder.style.display = "none";
                document.querySelector('.order-box-box').innerHTML = "";
                showCart();
            }

            function orderProd() {
                window.location.href = "index.php#product";
            }

            function logOut() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("logOut=1");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        window.location.href = "index.php";
                    }
                }
            }

            function editInput(btn){
                let id = btn.getAttribute('data-target');
                let values = btn.getAttribute('data-target-1');

                if(document.getElementById(id).disabled !== false) {
                    document.getElementById(id).disabled = false;
                } else {
                    document.getElementById(id).disabled = true;
                }

                diff();
            }

            function diff() {
                let token = 0;

                document.querySelectorAll('.inputs').forEach(ins => {
                    let hval = ins.getAttribute('data-target');
                    if(ins.value !== document.getElementById(hval).innerText) {
                        token += 1;
                    }
                });

                if (token > 0) {
                    document.getElementById('cancelChanges').disabled = false;
                    document.getElementById('saveChanges').disabled = false;
                } else {
                    document.getElementById('cancelChanges').disabled = true;
                    document.getElementById('saveChanges').disabled = true;
                }
            }

            function editInfo() {
                if (document.querySelector('.edit-info').style.display !== "flex") {
                    document.querySelector('.edit-info').style.display = "flex";
                    document.querySelector('.gen-info').style.display = "none";
                    document.querySelector('.gen-fav').style.display = "none";
                    modifData();
                }
            }

            function inputClick() {
                if (document.querySelector('.select-sex').style.display !== "flex"){
                    document.querySelector('.select-sex').style.display = "flex";
                } else {
                    document.querySelector('.select-sex').style.display = "none";
                }

                if(document.getElementById('sex').value === document.getElementById('h-sex').innerText) {
                    document.getElementById('cancelChanges').disabled = true;
                    document.getElementById('saveChanges').disabled = true;
                } else {
                    document.getElementById('cancelChanges').disabled = false;
                    document.getElementById('saveChanges').disabled = false;
                }
            }

            function sexSelect(sex) {
                document.getElementById('sex').value = sex.innerText;
                document.querySelector('.select-sex').style.display = "none";
            }

            function cancelInput(){
                if (document.querySelector('.gen-info').style.display !== "flex") {
                    document.querySelector('.gen-info').style.display = "flex";
                    document.querySelector('.gen-fav').style.display = "block";
                    document.querySelector('.edit-info').style.display = "none";
                }
            }

            function searchKey(obj, key) {
                return obj.hasOwnProperty(key) ? obj[key] : null;
            }

            function modifData(){
                document.getElementById('editInfoForm').innerHTML = "";
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("editInfo=1&mode=1");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('editInfoForm').innerHTML = xhr.responseText;
                    }
                }
            }

            function checkedSex(sex) {
                document.getElementById('hideSex').innerText = sex.value;
            }

            function checkedLoc(loc) {
                document.getElementById('hideLoc').innerText = loc.value;
            }

            function changeAge(bday) {
                if (bday.value !== "0000-00-00") {
                    let age = bday.getAttribute('data-target-1');
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "getproduct.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("changeAge=1&bday=" + bday.value);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            document.getElementById(age).value = parseInt(xhr.responseText, 10);
                        }
                    }
                }
            }

            function confirmChanges(){
                var contact = document.getElementById('uCon').value;
                var ln = document.getElementById('ln').value;
                var fn = document.getElementById('fn').value;
                var mn = document.getElementById('mn').value;
                var age = document.getElementById('uAge').value;
                var bday = document.getElementById('uBday').value;
                var blk = document.getElementById('uhouseNo').value;
                var street = document.getElementById('ustreet').value + ",";
                var brgy = document.getElementById('ubrgy').value + ",";
                var city = document.getElementById('ucity').value + ",";
                var prov = document.getElementById('uprov').value + ",";
                var zip = document.getElementById('zip').value;
                var sex = document.getElementById('hideSex').innerText;
                var loc = document.getElementById('hideLoc').innerText;

                if (contact.length > 10) {
                    var number = "+63" + contact;
                    var xhrv = new XMLHttpRequest();
                    var url = 'https://api.api-ninjas.com/v1/validatephone?number=' + encodeURIComponent(number);

                    xhrv.open('GET', url, true);
                    xhrv.setRequestHeader('X-Api-Key', 'r7U8jbnuIOr0hKNsG1hcxw==i84bLHduoszuG0OV');
                    xhrv.setRequestHeader('Content-Type', 'application/json');
                    xhrv.send();
                    xhrv.onreadystatechange = function () {
                        if (xhrv.readyState === 4) {
                            if (xhrv.status === 200) {
                                var valid = searchKey(JSON.parse(xhrv.responseText), "is_valid");
                                if (valid !== true) {
                                    let errorMessage = "Invalid Contact Number Format.";
                                    notif(errorMessage);
                                    contact = "";
                                }
                            } else {
                                let errorMessage = xhrv.responseText;
                                notif(errorMessage);
                            }
                        }
                    };
                } else {
                    contact = "";
                }

                if (document.getElementById('uM').checked) { sex = "Male";
                } else if (document.getElementById('uFM').checked) { sex = "Female";
                } else if (document.getElementById('uO').checked){ sex = "Other"; }

                if (document.getElementById('home').checked) { loc = "Home";
                } else if (document.getElementById('office').checked) { loc = "Office"; }

                if (ln.value === "" || fn.value === "") {
                    let alertMessage = "User Name must not be empty.";
                    notif(alertMessage);
                } else {
                    if (loc === "" && (blk !== "" || street !== "" || brgy !== "" || city !== "" || prov !== "" || zip !== "")) {
                        let alertMessage = "Address Type must not be empty.";
                        notif(alertMessage);
                    } else {
                        var xhr = new XMLHttpRequest();

                        xhr.open("POST", "getproduct.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("confirmChanges=1&fn=" + fn + "&ln=" + ln + "&mn=" + mn + "&age=" + age + "&sex=" + sex + "&bday=" + bday + "&contact=" + contact + "&loc=" + loc + "&blk=" + blk + "&street=" + street + "&brgy=" + brgy + "&city=" + city + "&prov=" + prov + "&zip=" + zip);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                if (xhr.responseText === "1") {
                                    let errorMessage = "Error: Unable to process request.";
                                    notif(errorMessage);
                                } else {
                                    let successMessage = "Changes has been made successfully.";
                                    notif(successMessage);
                                    document.getElementById('profileForm').innerHTML = "";
                                    var profile = new XMLHttpRequest();
                                    profile.open("POST", "getproduct.php", true);
                                    profile.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                    profile.send("getUserInfo=1&mode=0");
                                    profile.onload = function() {
                                        if (profile.status === 200) {
                                            document.getElementById('profileForm').innerHTML = profile.responseText;
                                            document.querySelector('.gen-info').style.display = "flex";
                                            document.querySelector('.gen-fav').style.display = "block";
                                            document.querySelector('.edit-info').style.display = "none";
                                            modifData();
                                        } else {
                                            notif(profile.responseText);
                                        }
                                    };

                                }
                            }
                        }
                    }
                }
            }

            function saveInfo(){
                var xhr = new XMLHttpRequest();
                var sex = document.getElementById('sex').value;
                var age = document.getElementById('age').value;
                var bday = document.getElementById('bday').value;
                var contact = document.getElementById('contact').value;

                if (contact.length > 10) {
                    var number = "+63" + contact;
                    var xhrv = new XMLHttpRequest();
                    var url = 'https://api.api-ninjas.com/v1/validatephone?number=' + encodeURIComponent(number);

                    xhrv.open('GET', url, true);
                    xhrv.setRequestHeader('X-Api-Key', 'r7U8jbnuIOr0hKNsG1hcxw==i84bLHduoszuG0OV');
                    xhrv.setRequestHeader('Content-Type', 'application/json');
                    xhrv.send();
                    xhrv.onreadystatechange = function () {
                        if (xhrv.readyState === 4) {
                            if (xhrv.status === 200) {
                                var valid = searchKey(JSON.parse(xhrv.responseText), "is_valid");

                                if (valid !== true) {
                                    let errorMessage = "Invalid Contact Number Format.";
                                    notif(errorMessage);
                                    contact = "";
                                }
                            } else {
                                let errorMessage = xhrv.responseText;
                                notif(errorMessage);
                            }
                        }
                    };
                } else {
                    contact = "";
                }

                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("saveInfo=1&sex=" + sex + "&age=" + age + "&bday=" + bday + "&contact=" + contact);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        let successMessage = "Changes has been made successfully.";
                        notif(successMessage);
                        document.getElementById('profileForm').innerHTML = "";
                        var profile = new XMLHttpRequest();
                        profile.open("POST", "getproduct.php", true);
                        profile.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        profile.send("getUserInfo=1&mode=0");
                        profile.onload = function() {
                            if (profile.status === 200) {
                                document.getElementById('profileForm').innerHTML = profile.responseText;
                                modifData();
                            } else {
                                notif(profile.responseText);
                            }
                        };
                    }
                }
            }

            function eraseFav(remfav) {
                var favID = remfav.getAttribute('data-target');
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("remProd=1&pid=" + document.getElementById(favID).innerText);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        if (xhr.responseText === "0" || xhr.responseText === '0') {
                            let errorMessage = "Error: Unable to process request.";
                            notif(errorMessage);
                        } else {
                            let successMessage = "Product is removed from favorites.";
                            notif(successMessage);
                            getFav();
                        }
                    }
                }
            }

            function getUname(){
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("getUname=1");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('h-username').innerText = xhr.responseText;
                        document.getElementById('uName').value = xhr.responseText;
                    }
                }
            }

            function changeUser() {
                if (document.getElementById('uName').value !== document.getElementById('h-username').innerText) {
                    document.getElementById('savePass').disabled = false;
                } else { document.getElementById('savePass').disabled = true; }
                if (document.getElementById('currPass').value.length >= 8) {
                    document.getElementById('confirmPass').style.display = "flex";
                    document.getElementById('savePass').style.display = "none"; 
                } else {
                    document.getElementById('confirmPass').style.display = "none";
                    document.getElementById('savePass').style.display = "flex"; 
                }
            }

            function inputNewPass() {
                if (document.getElementById('currPass').value !== "" && document.getElementById('currPass').value.length >= 8) {
                    var curr = document.getElementById('currPass').value;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "getproduct.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("checkPass=1&pass=" + curr);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            if (xhr.responseText == "0" || xhr.responseText == '0' || xhr.responseText == 0) {
                                document.getElementById('newPass').disabled = false;
                                document.getElementById('conPass').disabled = false;
                                document.getElementById('currPass').disabled = true;
                            } else {
                                let errorMessage = "Error: Incorrect Password.";
                                notif(errorMessage);
                                document.getElementById('newPass').disabled = true;
                                document.getElementById('conPass').disabled = true;
                                document.getElementById('currPass').disabled = false;
                            }
                        }
                    }
                }
            }

            function submitPass() {
                if (document.getElementById('newPass').value == document.getElementById('conPass').value) {
                    document.getElementById('confirmPass').style.display = "none";
                    document.getElementById('savePass').style.display = "flex";
                    document.getElementById('savePass').disabled = false;
                }
            }

            function finalPass() {
                if (document.getElementById('uName').value !== "" || (document.getElementById('newPass').value !== "" && document.getElementById('conPass').value !== "" && document.getElementById('currPass').value !== "")) {
                    var uname = document.getElementById('uName').value;
                    var pass = document.getElementById('currPass').value;
                    var conpass = document.getElementById('conPass').value;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "getproduct.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("updateInfo=1&uname=" + uname + "&pass=" + pass + "&newpass=" + conpass);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            if (xhr.responseText == "0" || xhr.responseText == '0' || xhr.responseText == 0) {
                                let successMessage = "Credential has been successfully changed.";
                                notif(successMessage);
                                window.location.href = "index.php";
                            } else if (xhr.responseText == "1" || xhr.responseText == '1' || xhr.responseText == 1) {
                                let errorMessage = "Incorrect Password.";
                                notif(errorMessage);
                            } else if (xhr.responseText == "2" || xhr.responseText == '2' || xhr.responseText == 2) {
                                let errorMessage = "This username is already taken.";
                                notif(errorMessage);
                            }
                        } else {
                            let errorMessage = "Error: Unable to process request.";
                            notif(errorMessage);
                        }
                    }
                } else {
                    let errorMessage = "Please Fill all the necessary fields.";
                    notif(errorMessage);
                }
            }

            function delAcc() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("delAcc=1");
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        let errorMessage = "Error: Unable to process request.";
                        notif(errorMessage);
                    } else {
                        if (parseInt(xhr.responseText, 10) == 0) {
                            let infoMessage = "Account has been removed.";
                            notif(infoMessage);
                            window.location.href = "index.php";
                        } else {
                            let errorMessage = "Error: Unable to process request.";
                            notif(errorMessage);
                        }
                    }
                }
            }

            function showOrder(){
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("showOrder=1");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.querySelector('.order-collection').innerHTML = xhr.responseText;
                        if (document.querySelectorAll('.order-card-card').length == 0) {
                            document.querySelector('.order-made').style.display = "none";
                            document.querySelector('.no-order').style.display = "flex";
                        } else if (document.querySelectorAll('.order-card-card').length == 1) {
                            document.querySelectorAll('.total').forEach(totes => {
                                totes.style.width = "70%";
                            });
                            document.querySelectorAll('.info-holder').forEach(info => {
                                info.style.gap = "1.5rem";
                            });
                        } else if (document.querySelectorAll('.order-card-card').length > 1) {
                            document.querySelectorAll('.total').forEach(totes => {
                                totes.style.width = "100%";
                            });
                            document.querySelectorAll('.info-holder').forEach(info => {
                                info.style.gap = "0";
                                info.style.width = "100%";
                            });
                        }
                    }
                }
            }

            function showCart() {
                var xhr = new XMLHttpRequest();
                let word_1 = "order-holder";
                let word_2 = "cart-list";

                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("cart=1");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        if (xhr.responseText.includes(word_1)) {
                            document.getElementById('profilePage').style.display = "none";
                            document.getElementById('cartPage').style.display = "flex";
                            document.getElementById('secTitle').style.display = "none";
                            document.getElementById('checkoutContainer').style.display = "none";
                            document.getElementById('optTitle').style.display = "block";
                            displayOrder.style.display = "flex";
                            document.querySelector('.order-box-box').innerHTML = xhr.responseText;
                            displayDetails();
                        }
                        else if (xhr.responseText == "" || xhr.responseText == null || xhr.responseText.length < 5) {
                            document.getElementById('noOrder').style.display = "flex";
                            document.getElementById('checkoutContainer').style.display = "none";
                            document.getElementById('confirmOrder').style.display = "none";
                            document.getElementById('optTitle').style.display = "none";
                        } else if (xhr.responseText.includes(word_2)){
                            document.getElementById('noOrder').style.display = "none";
                            document.getElementById('cartContainer').innerHTML = xhr.responseText;
                            document.getElementById('confirmOrder').style.display = "none";
                            document.getElementById('orderTotal').innerHTML = "";
                        }
                    }
                }
            }

            function addQuantity(input) {
                var total = input.getAttribute('data-target');
                const price = input.getAttribute('data-target-1');

                if (input.value !== "1") {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "getproduct.php", true);

                    var request = new FormData();
                    request.append('currQty', input.value);
                    request.append('price', document.getElementById(price).innerText);

                    xhr.send(request);

                    xhr.onload = function() {
                        if (xhr.status !== 200) {
                            notif(errorText);
                        } else {
                            document.getElementById(total).innerHTML = "₱" + xhr.responseText;
                        }
                    };
                } else {
                    document.getElementById(total).innerHTML = "₱" + document.getElementById(price).innerHTML;
                }
            }

            selectBtn.disabled = true;
            deleteBtn.disabled = true;
            checkoutBtn.disabled = true;

            function selectItem(chbox) {
                var check = chbox.getAttribute('data-target-1');
                var label = document.getElementById(check);

                if (label.classList.contains('checked')) {
                    chbox.checked = false;
                    label.classList.remove('checked');
                } else {
                    chbox.checked = true;
                    label.classList.toggle('checked');
                }

                btnAbled();
            }

            function btnAbled() {
                const cbox = document.querySelectorAll('.checkBox');
                var token = 0;
                cbox.forEach(chb => {
                    var label = chb.getAttribute('data-target-1');
                    var id = chb.getAttribute('data-target');
                    if (document.getElementById(label).classList.contains('checked')) {
                        token++;
                    }
                });
                if (token > 0) {
                    selectBtn.disabled = false;
                    deleteBtn.disabled = false;
                    checkoutBtn.disabled = false;
                } else {
                    selectBtn.disabled = true;
                    deleteBtn.disabled = true;
                    checkoutBtn.disabled = true;
                }
            }

            function checkSelected() {
                document.querySelector('.order-box-box').innerHTML = "";
                document.getElementById('checkoutContainer').style.display = "none";
                document.getElementById('secTitle').style.display = "none";
                document.getElementById('optTitle').style.display = "flex";
                document.getElementById('confirmOrder').style.display = "flex";
                displayDetails();

                var checkbox = document.querySelectorAll('.checkBox');
                var token = 0;

                checkbox.forEach(chb => {
                    var label = chb.getAttribute('data-target-1');
                    var image = chb.getAttribute('data-target-2');
                    var id = chb.getAttribute('data-target');
                    var name = chb.getAttribute('data-target-3');
                    var qty = chb.getAttribute('data-target-4');
                    var total = chb.getAttribute('data-target-5');
                    var price = chb.getAttribute('data-target-6');

                    if (document.getElementById(label).classList.contains('checked')) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "getproduct.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("passItem=1&pID=" + document.getElementById(id).innerText + "&image=" + image + "&name=" + document.getElementById(name).innerText + "&qty=" + document.getElementById(qty).value + "&price=" + document.getElementById(price).innerText + "&total=" + document.getElementById(total).innerText + "&count=" + token);
                        xhr.onload = function() {
                            if (xhr.status !== 200) {
                                let errorMessage = "Error: Unable to process request.";
                                notif(errorMessage);
                            } else {
                                document.querySelector('.order-box-box').innerHTML += xhr.responseText;
                                getTotal();
                            }
                        }
                    }
                    token++;
                });
            }

            function removeItem(rem) {
                var remItem = rem.getAttribute('data-target');
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("rem=1&rID=" + document.getElementById(remItem).innerText);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        let errorMessage = "Item has been removed from the cart.";
                        notif(errorMessage);
                        showCart();
                        selectBtn.disabled = true;
                        deleteBtn.disabled = true;
                        checkoutBtn.disabled = true;
                    }
                }
            }

            function selectAll(btn) {
                const cbox = document.querySelectorAll('.checkBox');

                if (btn.innerText == "Select All") {
                    cbox.forEach(chb => {
                        var label = chb.getAttribute('data-target-1')
                        if (!document.getElementById(label).classList.contains('checked')) {
                            chb.checked = true;
                            document.getElementById(label).classList.toggle('checked');
                        }
                    });
                    btn.innerText = "Unselect All";
                } else {
                    cbox.forEach(chb => {
                        var label = chb.getAttribute('data-target-1')
                        if (document.getElementById(label).classList.contains('checked')) {
                            chb.checked = false;
                            document.getElementById(label).classList.remove('checked');
                            selectBtn.disabled = true;
                            deleteBtn.disabled = true;
                            checkoutBtn.disabled = true;
                        }
                    });
                    btn.innerText = "Select All";
                }
            }

            function deleteSelected() {
                var checkbox = document.querySelectorAll('.checkBox');
                checkbox.forEach(chb => {
                    var label = chb.getAttribute('data-target-1');
                    var id = chb.getAttribute('data-target');
                    if (document.getElementById(label).classList.contains('checked')) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "getproduct.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("delItem=1&dID=" + document.getElementById(id).innerText);
                        xhr.onload = function() {
                            if (xhr.status !== 200) {
                                let errorMessage = "Error: Unable to process request.";
                                notif(errorMessage);
                            } else {
                                let errorMessage = "Selected item/s has been removed from the cart.";
                                notif(errorMessage);
                                showCart();
                                selectBtn.disabled = true;
                                deleteBtn.disabled = true;
                                checkoutBtn.disabled = true;
                            }
                        }
                    }
                });
            }

            function displayDetails() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("showInfo=1");
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        let errorMessage = "Error: Unable to process request.";
                        notif(errorMessage);
                    } else {
                        document.getElementById('infoContainer').innerHTML = xhr.responseText;
                    }
                }
            }

            function gotoEditInfo() {
                document.getElementById('cartPage').style.display = "none";
                document.getElementById('genPage').style.display = "flex";
                document.getElementById('profilePage').style.display = "flex";
                document.querySelector('.gen-fav').style.display = "none";
                document.getElementById('profileForm').style.display = "none";
                document.getElementById('editInfoForm').style.display = "flex";
                modifData();
            }

            function getTotal() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("gettotal=1");
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        let errorMessage = "Error: Unable to process request.";
                        notif(errorMessage);
                    } else {
                        document.getElementById('orderTotal').innerText = "TOTAL: ₱" + xhr.responseText;
                    }
                }
            }

            function confirmAction() {
                if (document.getElementById('number').value == "" || document.getElementById('blkLot').value == "" || document.getElementById('street').value == "" || document.getElementById('brgy').value == "" || document.getElementById('city').value == "" || document.getElementById('city').value == "" || document.getElementById('province').value == "" || document.getElementById('zipCode').value == "") {
                    displayText.style.opacity = 1;
                } else {
                    if(displayText.innerText == "*Contact Number and Address must not be empty."){
                        displayText.style.opacity = 1;
                        displayText.innerText = "*Please verify the displayed information above";
                    } else {
                        confirmOrder.disabled = false;
                    }
                }
            }

            function uploadOrder() {
                var card = document.querySelectorAll('.order-holder');
                var token = 0;
                card.forEach(prod => {
                    var cID = prod.getAttribute('data-target');
                    var cQty = prod.getAttribute('data-target-1');
                    var cTotal = prod.getAttribute('data-target-2');

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "getproduct.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("passOrder=1&cID=" + document.getElementById(cID).innerText + "&cQty=" + document.getElementById(cQty).innerText + "&cTotal=" + document.getElementById(cTotal).innerText);
                    xhr.onload = function() {
                        if (xhr.status !== 200) {
                            let errorMessage = "Error: Unable to process request.";
                            notif(errorMessage);
                        } else {
                            token++;
                            if (token == 1) {
                                let infoMessage = "Order has been placed.";
                                notif(infoMessage);
                                document.getElementById('cartPage').style.display = "none";
                                document.getElementById('orderPage').style.display = "flex";
                                showOrder();
                            }
                        }
                    }
                });
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("endTag=1");
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        let errorMessage = "Error: Unable to process request.";
                        notif(errorMessage);
                    }
                }
            }

            function showTransac() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("showtransac=1");
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        let errorMessage = "Error: Unable to process request.";
                        notif(errorMessage);
                    } else {
                        if (xhr.responseText.length > 5) {
                            document.querySelector('.transac-container').style.display = "flex";
                            document.getElementById('transacCard').innerHTML = xhr.responseText;
                            document.getElementById('noTransac').style.display = "none";
                        } else {
                            document.getElementById('noTransac').style.display = "flex";
                            document.querySelector('.transac-container').style.display = "none";
                        }
                    }
                }
            }

            function max(resize) {
                const targetId = resize.getAttribute('data-target');
                const showAll = document.getElementById(targetId);

                if (showAll.style.height === "50px"){
                    showAll.style.height = "350px";
                    showAll.style.background = "var(--compli-color)";
                    showAll.style.borderBottom = "none";
                    resize.classList.toggle('active');
                } else {
                    showAll.style.height = "50px";
                    showAll.style.background = "transparent";
                    showAll.style.borderBottom = "1px solid #afafaf";
                    resize.classList.remove('active');
                }
                document.querySelectorAll('.date-card').forEach(drop => {
                    if (drop.id !== targetId){
                        drop.style.height = "50px";
                        drop.style.background = "transparent";
                        drop.style.borderBottom = "1px solid #afafaf";
                    }
                });
                document.querySelectorAll('.resizeBtn').forEach(btn => {
                    if (btn !== resize){
                        btn.classList.remove('active');
                    }
                });
            }
        </script>
    </body> 
</html>