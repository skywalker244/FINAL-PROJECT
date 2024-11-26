<?php
session_start();
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Pastry Shop | Mainpage</title>
        <link href="styles.css" rel="stylesheet"/>

        <link rel="icon" href="resource/logo.ico" type="image/ico">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/9bd5c7f2ea.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
        
        <script>
            let errorText = "Error: Unable to process request.";

            window.onload = function() {
                loadingScreen();
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("selected=option-1");
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        notif(errorText);
                    } else {
                        searchForWord(xhr.responseText);
                    }
                };
                chBox = null;
                <?php
                    if(isset($_SESSION["username"])) {
                        echo "
                            document.getElementById('visitor').style.display = \"none\";
                            document.getElementById('user').style.display = \"flex\";
                        ";
                    } else {
                        echo "
                            document.getElementById('user').style.display = \"none\";
                            document.getElementById('visitor').style.display = \"flex\";
                        ";
                    }
                ?>
                maps();
            };

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

            function changeCategory(checkbox) {                
                var checkboxes = document.getElementsByName('option');

                checkboxes.forEach((item) => {
                    if (item !== checkbox) {
                        item.checked = false;
                    }
                });
                
                var chBox = document.querySelector('input[name="option"]:checked');

                if (chBox) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "getproduct.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("selected=" + chBox.value);
                }  else {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "getproduct.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("selected=option-1");
                }
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        notif(errorText);
                    } else {
                        searchForWord(xhr.responseText);
                    }
                };
                chBox = null;
            }

            function addQuantity(input) {
                
                var total = document.querySelector('.total-text');
                const price = document.getElementById('price');

                if (input.value !== "1") {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "getproduct.php", true);

                    var request = new FormData();
                    request.append('currQty', input.value);
                    request.append('price', price.innerHTML);

                    xhr.send(request);

                    xhr.onload = function() {
                        if (xhr.status !== 200) {
                            notif(errorText);
                        } else {
                            total.innerHTML = "₱" + xhr.responseText;
                        }
                    };
                } else {
                    total.innerHTML = "₱" + price.innerHTML;
                }
            }

            function signUp() {
                var email = document.getElementById('gmail').value;
                var fname = document.getElementById('fname').value;
                var lname = document.getElementById('lname').value;
                var pass = document.getElementById('conpass').value;

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "signup.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.send("email=" + encodeURIComponent(email) + "&fname=" + encodeURIComponent(fname) + "&lname=" + encodeURIComponent(lname) + "&password=" + encodeURIComponent(pass));
                
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if (xhr.responseText === "0") {
                            if (document.getElementById('signUpFinal').style.display === "none") {
                                document.getElementById('signUp').style.display = "none";
                                document.getElementById('signIn').style.display = "none";
                                document.getElementById('signUpFinal').style.display = "flex";
                            }
                        } else if (xhr.responseText === "1") {
                            if (document.getElementById('signIn').style.display === "none") {
                                document.getElementById('signUp').style.display = "none";
                                document.getElementById('signUpFinal').style.display = "none";
                                document.getElementById('signIn').style.display = "flex";
                            }
                            let successText = "Success: Account has been registered. Please log in.";
                            notif(successText);
                        } else if (xhr.responseText === "2") {
                            document.getElementById('gmail').value = "";
                            if (document.getElementById('signUp').style.display === "none") {
                                document.getElementById('signIn').style.display = "none";
                                document.getElementById('signUpFinal').style.display = "none";
                                document.getElementById('signUp').style.display = "flex";
                            }
                            let alertText = "Error: Email Address is already registered. Please Log In or create new account.";
                            notif(alertText);
                        } else if (xhr.responseText === "3") {
                            if (document.getElementById('signUpFinal').style.display === "none") {
                                document.getElementById('signUp').style.display = "none";
                                document.getElementById('signIn').style.display = "none";
                                document.getElementById('signUpFinal').style.display = "flex";
                            }
                            let errorText = "Password Required Length is 8 characters and above.";
                            notif(errorText);
                        }
                    } else if (this.readyState == 4) {
                        notif(errorText);
                    }
                };
            }

            function logIn() {
                var lgmail = document.getElementById('lgmail').value;
                var lpass = document.getElementById('lpass').value;

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "login.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("lgmail=" + encodeURIComponent(lgmail) + "&lpass=" + encodeURIComponent(lpass));

                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if (xhr.responseText === "0") {
                            let successText = "Logged In Successfully.";
                            notif(successText);
                            loadingScreen();
                            window.location.href = "userpage.php";
                        } else if (xhr.responseText === "1") {
                            document.getElementById('lpass').value = "";
                            let alertText = "Invalid Email/Username or Password.";
                            notif(alertText);
                        }
                    } else if (this.readyState == 4) {
                        notif(errorText);
                    }
                };
            }

            function buyItem() {
                var passID = document.getElementById('hideID').innerHTML;
                var bg = document.getElementById('hiddenMaxImg').innerHTML;
                var name = document.querySelector('.name').innerHTML;
                var qty = document.getElementById('qty').value;
                var price = document.getElementById('price').innerHTML;
                var total = document.querySelector('.total-text').innerHTML;

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("id=" + passID + "&qty=" + qty + "&bg=" + bg + "&name=" + name + "&price=" + price + "&total=" + total);
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        notif(errorText);
                    } else {
                        if (xhr.responseText == "0" || xhr.responseText == 0) {
                            window.location.href = "userpage.php";
                        } else {
                            let alertText = "You must log in first.";
                            notif(alertText);
                            document.getElementById('account').style.display = "flex";
                        }
                    }
                }; 
            }

            function addToCart() {
                var id = document.getElementById('hideID').innerHTML;
                var qty = document.getElementById('qty').value;
                var price = document.getElementById('price').innerHTML;

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("cartId=" + id + "&qty=" + qty + "&price=" + price);
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        notif(errorText); 
                    } else {
                        if (xhr.responseText == "0" || xhr.responseText == 0) {
                            let alertText = "You must log in first.";
                            notif(alertText);
                            document.getElementById('account').style.display = "flex";
                        } else{
                            notif(xhr.responseText);
                        }
                    }
                }; 
            }

            function showCart() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "getproduct.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("openCart=1");
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        notif(errorText);
                    } else {
                        if (xhr.responseText == "0" || xhr.responseText == 0) {
                            let loginAlert = "Alert: You must log in first.";
                            notif(loginAlert);
                            document.getElementById('account').style.display = "flex";
                        } else{
                            window.location.href = "userpage.php";
                        }
                    }
                }; 
            }

            function showIcon() {
                document.querySelectorAll('.getFav').forEach(fav => {
                    const icon1 = fav.getAttribute('data-target');
                    const icon2 = fav.getAttribute('data-target-1');
                    if (fav.value == 1 || fav.value == "1" || fav.value == '1') {
                        document.getElementById(icon1).style.display = "block";
                        document.getElementById(icon2).style.display = "none";
                    } else {
                        document.getElementById(icon2).style.display = "block";
                        document.getElementById(icon1).style.display = "none";
                    }
                });
            }

            function searchProduct(){
                var word = document.getElementById('searchText').value;
                if (word != "" || word != null) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "getproduct.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("searchWord=1&word=" + word);
                    xhr.onload = function() {
                        if (xhr.status !== 200) {
                            notif(errorText);
                        } else {
                            searchForWord(xhr.responseText);
                        }
                    }; 
                }
            }

            function searchForWord(text) {
                let getText = text;

                let word = ".00</p></div>";
                let positions = [];
                let pos = getText.indexOf(word);

                let pid = "name=\"getID\" value=\"";
                let pidValues = [];
                let pidval = getText.indexOf(pid);

                let desc = "getDesc\" value=\"";
                let detail = [];
                let info = getText.indexOf(desc);

                let endDesc = "\"><p><strong";
                let endDetail = [];
                let endInfo = getText.indexOf(endDesc);

                let startImg = "url(";
                let startPic = [];
                let start = getText.indexOf(startImg);

                let finImg = ") no-repeat";
                let finPic = [];
                let finish = getText.indexOf(finImg);

                let price = "₱";
                let amount = [];
                let prices = getText.indexOf(price);

                let nStart = "1rem;\">";
                let nameStart = [];
                let Sname = getText.indexOf(nStart);

                let nFin = "</strong>";
                let nameEnd = [];
                let Fname = getText.indexOf(nFin);

                while (pos !== -1) {
                    positions.push(pos + 13);
                    pos = text.indexOf(word, pos + 1);

                    pidValues.push(pidval + 20);
                    pidval = text.indexOf(pid, pidval + 1);

                    detail.push(info + 16);
                    info = text.indexOf(desc, info + 1);

                    endDetail.push(endInfo);
                    endInfo = text.indexOf(endDesc, endInfo + 1);

                    startPic.push(start + 4);
                    start = text.indexOf(startImg, start + 1);

                    finPic.push(finish);
                    finish = text.indexOf(finImg, finish + 1);

                    amount.push(prices + 1);
                    prices = text.indexOf(price, prices + 1);

                    nameStart.push(Sname + 7);
                    Sname = text.indexOf(nStart, Sname + 1);

                    nameEnd.push(Fname);
                    Fname = text.indexOf(nFin, Fname + 1);
                }
                appendButtons(getText, positions, pidValues, detail, endDetail, startPic, finPic, amount, nameStart, nameEnd);
            }

            function appendButtons(text, position, pidvalues, detail, endDetails, start, finish, amount, nameStart, nameFin) {
                document.getElementById('prodDisplay').innerHTML = "";
                const stayCard = document.getElementById('maxCard');
                const hideCard = document.getElementById('maxCont');
                const passID = document.getElementById('hideID');
                const hPassImg = document.getElementById('hiddenMaxImg');
                const passImg = document.querySelector('.max-img');
                const passName = document.querySelector('.name');
                const passDesc = document.querySelector('.prod-info');
                const passPrice = document.querySelector('.total-text');
                const storePrice = document.getElementById('price');

                let origText = text;
                let pos = position;
                let pidval = pidvalues;
                let det = detail;
                let endDet = endDetails;
                let st = start;
                let fin = finish;
                let p = amount;
                let sName = nameStart;
                let fName = nameFin;
                let i = 0;
                let count = 0;

                pos.forEach(function(item, index) { 
                    let card = document.createElement('div');
                    let hiddenDiv = document.createElement('div');
                    let hiddenImg = document.createElement('div');
                    let hiddenDesc = document.createElement('div');
                    let hiddenPrice = document.createElement('div');
                    let hiddenName = document.createElement('div');
                    let btnContainer = document.createElement('div');
                    let iconCard = document.createElement('div');
                    let icon1 = document.createElement('i');
                    let icon2 = document.createElement('i');
                    let buyBtn = document.createElement('div');
                    let cartBtn = document.createElement('div');
                    let icon3 = document.createElement('i');
                    let pid = pidval[index];
                    let sImg = st[index];
                    let fImg = fin[index];
                    let sDesc = det[index];
                    let fDesc = endDet[index];
                    let total = p[index];
                    let sn = sName[index];
                    let fn = fName[index];

                    card.setAttribute('class', 'prod-card');
                    hiddenDiv.setAttribute('id', 'hidden_id_' + count);
                    hiddenImg.setAttribute('id', 'hidden_img_' + count);
                    hiddenDesc.setAttribute('id', 'hidden_desc_' + count);
                    hiddenPrice.setAttribute('id', 'hidden_price_' + count);
                    hiddenName.setAttribute('id', 'hidden_name_' + count);
                    btnContainer.setAttribute('class', 'prod-icon');
                    iconCard.setAttribute('class', 'fav');
                    iconCard.setAttribute('id', 'favBtn');
                    icon1.setAttribute('class', 'fa-regular fa-heart');
                    icon1.setAttribute('id', 'notFav_' + count);
                    icon2.setAttribute('class', 'fa-solid fa-heart');
                    icon2.setAttribute('id', 'fav_' + count);
                    buyBtn.setAttribute('class', 'input');
                    buyBtn.innerHTML = "Buy Now";
                    buyBtn.setAttribute('data-target', 'hidden_id_' + count);
                    buyBtn.setAttribute('data-target-1', 'hidden_img_' + count);
                    buyBtn.setAttribute('data-target-2', 'hidden_desc_' + count);
                    buyBtn.setAttribute('data-target-3', 'hidden_name_' + count);
                    buyBtn.setAttribute('data-target-4', 'hidden_price_' + count);
                    cartBtn.setAttribute('class', 'addCart');
                    iconCard.setAttribute('data-target', 'hidden_id_' + count);
                    cartBtn.setAttribute('data-target', 'hidden_id_' + count);
                    cartBtn.setAttribute('data-target-1', 'hidden_img_' + count);
                    cartBtn.setAttribute('data-target-2', 'hidden_desc_' + count);
                    cartBtn.setAttribute('data-target-3', 'hidden_name_' + count);
                    cartBtn.setAttribute('data-target-4', 'hidden_price_' + count);
                    icon3.setAttribute('class', 'fa-solid fa-basket-shopping');

                    card.innerHTML = origText.substring(item, i);
                    hiddenDiv.innerHTML = origText.substring(pid + 3, pid);
                    hiddenImg.innerHTML = origText.substring(fImg, sImg);
                    hiddenDesc.innerHTML = origText.substring(fDesc, sDesc);
                    hiddenPrice.innerHTML = origText.substring(item - 10, total);
                    hiddenName.innerHTML = origText.substring(fn, sn);
                    card.appendChild(hiddenDiv);
                    card.appendChild(hiddenImg);
                    card.appendChild(hiddenDesc);
                    card.appendChild(hiddenPrice);
                    card.appendChild(hiddenName);
                    card.appendChild(btnContainer);
                    cartBtn.appendChild(icon3);
                    iconCard.appendChild(icon1);
                    iconCard.appendChild(icon2);
                    btnContainer.appendChild(iconCard);
                    btnContainer.appendChild(buyBtn);
                    btnContainer.appendChild(cartBtn);
            
                    document.getElementById('prodDisplay').appendChild(card);
                    hiddenDiv.style.display = "none";
                    hiddenImg.style.display = "none";
                    hiddenDesc.style.display = "none";
                    hiddenPrice.style.display = "none";
                    hiddenName.style.display = "none";
                    icon1.style.display = "block";
                    icon2.style.display = "none";

                    iconCard.addEventListener('click', function() {
                        if (icon1.style.display !== "none") {
                            const id = iconCard.getAttribute('data-target');
                            const passID = document.getElementById(id).innerHTML;

                            var xhr1 = new XMLHttpRequest();
                            xhr1.open("POST", "getproduct.php", true);
                            xhr1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr1.send("fav=" + passID);
                            xhr1.onload = function() {
                                if (xhr1.status !== 200) {
                                    notif(errorText);
                                } else {
                                    if (xhr1.responseText == "2" || xhr1.responseText == '2' || xhr1.responseText == 2){
                                        icon1.style.display = "block";
                                        icon2.style.display = "none";
                                        notif("You must log in first.");
                                        document.getElementById('account').style.display = "flex";
                                    } else {
                                        icon1.style.display = "none";
                                        icon2.style.display = "block";
                                        notif(xhr1.responseText);
                                    }
                                }
                            };
                        } else { 
                            icon2.style.display = "none";
                            icon1.style.display = "block";

                            const id = iconCard.getAttribute('data-target');
                            const passID = document.getElementById(id).innerHTML;

                            var xhr1 = new XMLHttpRequest();
                            xhr1.open("POST", "getproduct.php", true);
                            xhr1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr1.send("removeFav=" + passID);
                            xhr1.onload = function() {
                                if (xhr1.status !== 200) {
                                    notif(errorText);
                                } else {
                                    if (xhr1.responseText == "2" || xhr1.responseText == '2' || xhr1.responseText == 2) {
                                        let alertText = "You must log in first.";
                                        notif(alertText);
                                        document.getElementById('account').style.display = "flex";
                                    } else {
                                        notif(xhr1.responseText);
                                    }
                                }
                            };
                        }
                    });

                    buyBtn.addEventListener('click', function() {
                        hideCard.style.display = "flex";
                        const hID = this.getAttribute('data-target');
                        const hImg = this.getAttribute('data-target-1');
                        const hDesc = this.getAttribute('data-target-2');
                        const hName = this.getAttribute('data-target-3');
                        const hPrice = this.getAttribute('data-target-4');
                        const getQty = document.getElementById('qty');
                        
                        const thisID = document.getElementById(hID);
                        const thisImg = document.getElementById(hImg);
                        const thisDesc = document.getElementById(hDesc);
                        const thisName = document.getElementById(hName);
                        const thisPrice = document.getElementById(hPrice);
                        
                        passID.innerHTML = thisID.innerHTML;
                        hPassImg.innerHTML = thisImg.innerHTML;
                        passImg.style.background = "url(" + thisImg.innerHTML + ") no-repeat center";
                        passImg.style.backgroundSize = "cover";
                        passName.innerHTML = thisName.innerHTML;
                        passDesc.innerHTML = thisDesc.innerHTML;
                        passPrice.innerHTML = "₱" + thisPrice.innerHTML;
                        storePrice.innerHTML = thisPrice.innerHTML;
                        getQty.value = 1;
                    });

                    cartBtn.addEventListener('click', function() {
                        hideCard.style.display = "flex";
                        const hID = this.getAttribute('data-target');
                        const hImg = this.getAttribute('data-target-1');
                        const hDesc = this.getAttribute('data-target-2');
                        const hName = this.getAttribute('data-target-3');
                        const hPrice = this.getAttribute('data-target-4');
                        const getQty = document.getElementById('qty');
                        
                        const thisID = document.getElementById(hID);
                        const thisImg = document.getElementById(hImg);
                        const thisDesc = document.getElementById(hDesc);
                        const thisName = document.getElementById(hName);
                        const thisPrice = document.getElementById(hPrice);
                        
                        passID.innerHTML = thisID.innerHTML;
                        hPassImg.innerHTML = thisImg.innerHTML;
                        passImg.style.background = "url(" + thisImg.innerHTML + ") no-repeat center";
                        passImg.style.backgroundSize = "cover";
                        passName.innerHTML = thisName.innerHTML;
                        passDesc.innerHTML = thisDesc.innerHTML;
                        passPrice.innerHTML = "₱" + thisPrice.innerHTML;
                        storePrice.innerHTML = thisPrice.innerHTML;
                        getQty.value = 1;
                    });

                    i = item;
                    index = index + 1;
                    count = count + 1;
                });
                showIcon();
                origText = "";
                pos = [];
                i = 0;
            }

            function maps() {
                var map1 = L.map('map1').setView([14.593463, 120.978130], 18);
                var map2 = L.map('map2').setView([14.414728, 121.040046], 18);
                var map3 = L.map('map3').setView([14.377667, 121.044778], 17);
                var map4 = L.map('map4').setView([14.536190, 120.981268], 18);
                var map5 = L.map('map5').setView([14.298234, 121.054173], 18);
                var map6 = L.map('map6').setView([14.309145, 121.117889], 19);
                var prevmap = L.map('prevMap').setView([14.4533, 120.9863], 10);
                
                const icon = L.icon({
                    iconUrl: 'resource/logo.svg',
                    iconSize: [30,30],
                })
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map1);
                var marker1 = L.marker([14.593084, 120.978114], {title: 'Pastry Shop Manila', icon: icon,}).addTo(map1);
                marker1.bindPopup("<b>Pastry Shop Manila</b><br>2 Asean Garden, Bgy 654, <br>Zone 069 Intramuros, Manila").openPopup();

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map2);
                var marker2 = L.marker([14.414586, 121.040151], {title: 'Pastry Shop Alabang', icon: icon,}).addTo(map2);
                marker2.bindPopup("<b>Pastry Shop Alabang</b><br>The River Park, Festival Supermall, <br>Muntinlupa, Metro Manila").openPopup();

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map3);
                var marker3 = L.marker([14.377479, 121.044780], {title: 'Pastry Shop SM Muntinlupa', icon: icon,}).addTo(map3);
                marker3.bindPopup("<b>Pastry Shop SM Muntinlupa</b><br>SM Center, Muntinlupa, <br>Metro Manila").openPopup();

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map4);
                var marker4 = L.marker([14.535935, 120.981327], {title: 'Pastry Shop MOA', icon: icon,}).addTo(map4);
                marker4.bindPopup("<b>Pastry Shop MOA Seaside</b><br>SM Mall of Asia, Seaside Blvd, <br>Pasay, 1300 Metro Manila").openPopup();

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map5);
                var marker5 = L.marker([14.298053, 121.054187], {title: 'Pastry Shop Cavite', icon: icon,}).addTo(map5);
                marker5.bindPopup("<b>Pastry Shop Cavite</b><br>13123 Calumpang Road, <br>Carmona, Cavite").openPopup();

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map6);
                var marker6 = L.marker([14.308940, 121.117873], {title: 'Pastry Shop Laguna', icon: icon,}).addTo(map6);
                marker6.bindPopup("<b>Pastry Shop Laguna</b><br>Block 22 Lot 2 Phase 2 <br>Lotus corner Champaca Street <br>Garden Villas 3 Brgy, Santa Rosa, <br>4026 Laguna").openPopup();
            
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(prevmap);
                var prev1 = L.marker([14.593084, 120.978114], {title: "Pastry Shop Manila", icon: icon,}).addTo(prevmap);
                prev1.bindPopup("<b>Pastry Shop Manila</b><br>2 Asean Garden, Bgy 654, <br>Zone 069 Intramuros, Manila");
                var prev2 = L.marker([14.414586, 121.040151], {title: 'Pastry Shop Alabang', icon: icon,}).addTo(prevmap);
                prev2.bindPopup("<b>Pastry Shop Alabang</b><br>The River Park, Festival Supermall, <br>Muntinlupa, Metro Manila");
                var prev3 = L.marker([14.377479, 121.044780], {title: 'Pastry Shop SM Muntinlupa', icon: icon,}).addTo(prevmap);
                prev3.bindPopup("<b>Pastry Shop SM Muntinlupa</b><br>SM Center, Muntinlupa, <br>Metro Manila");
                var prev4 = L.marker([14.535935, 120.981327], {title: 'Pastry Shop MOA', icon: icon,}).addTo(prevmap);
                prev4.bindPopup("<b>Pastry Shop MOA Seaside</b><br>SM Mall of Asia, Seaside Blvd, <br>Pasay, 1300 Metro Manila");
                var prev5 = L.marker([14.298053, 121.054187], {title: 'Pastry Shop Cavite', icon: icon,}).addTo(prevmap);
                prev5.bindPopup("<b>Pastry Shop Cavite</b><br>13123 Calumpang Road, <br>Carmona, Cavite");
                var prev6 = L.marker([14.308940, 121.117873], {title: 'Pastry Shop Laguna', icon: icon,}).addTo(prevmap);
                prev6.bindPopup("<b>Pastry Shop Laguna</b><br>Block 22 Lot 2 Phase 2 <br>Lotus corner Champaca Street <br>Garden Villas 3 Brgy, Santa Rosa, <br>4026 Laguna");
            }

            function loadingScreen() {
                document.getElementById('loadingPage').style.display = "flex";
                setTimeout(() => {
                    document.getElementById('loadingPage').style.display = "none";
                }, 5000);
            }
        </script>
    </head>
    <body>
        <section id="loadingPage">
            <div class="loading-card">
                <div class="load">
                    <div class="tray"></div>
                    <div class="drink"></div>
                    <div class="plate">
                        <div class="donut"></div>
                        <div class="donut"></div>
                        <div class="donut"></div>
                        <div class="donut"></div>
                    </div>
                    <div class="plate">
                        <div class="croissant"></div>
                    </div>
                </div>
            </div>
        </section>
        <header>
            <a href="#home" class="logo"><h1>Connaisseur de <span>Pâtisserie</span></h1></a>
            <div class="navbar" id="nav">
                <div class="web-links">
                    <a href="#product" class="nav-link">Our Products</a>
                    <a href="#service" class="nav-link">Services</a>
                    <a href="#about" class="nav-link">About Us</a>
                </div>
                <div class="user" id="user" style="display: none;">
                    <a href="userpage.php"><i class="fa-solid fa-circle-user"></i></a>
                    <a onclick="showCart()"><i class="fa-solid fa-basket-shopping"></i></a>
                </div>
                <div class="visitor" id="visitor">
                    <button id="showLogin">Log in | Sign up</button>
                </div>
            </div>
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="close-btn" class="fa-solid fa-xmark"></div>
            <section id="account" style="display: none;"> 
                <div class="sign-card">
                    <div class="sign-up-card" id="signUp">
                     <h3 class="form-title">Create an Account</h3>
                        <form method="post">
                            <div class="input-group">
                                <input type = "email" name = "gmail" id = "gmail" placeholder = "Email Address" required>
                                <label for = "gmail">Email Address</label>
                            </div>
                            <div class="input-group">
                                <input type = "text" name = "fname" id = "fname" placeholder = "First Name" required style="text-transform: capitalize;">
                                <label for = "fname">First Name</label>
                            </div>
                            <div class="input-group">
                                <input type = "text" name = "lname" id = "lname" placeholder = "Last Name" required>
                                <label for = "lname">Last Name</label>
                            </div>
                            <button id="nextBtn" class="btn">Next</button>
                        </form>
                     <p class = "or"> — or — </p>
                     <div class = "links">
                         <p> Already have an account?</p>
                         <button class="loginBtn">Log In</button>
                     </div>
                    </div>
                    <div class="sign-up-card" id="signUpFinal" style="display: none;">
                        <h3 class="form-title">Create an Account</h3>
                        <form method="post">
                           <div class="input-group">
                               <input type = "password" name = "pass" id = "pass" autocomplete="off" required>
                               <label for = "pass">Password</label>
                           </div>
                           <div class="input-group">
                               <input type = "password" name = "conpass" id = "conpass" autocomplete="off" required>
                               <label for = "conpass">Confirm Password</label>
                           </div>
                           <button id="signUpNow" class = "btn">Sign Up</button>
                        </form>
                        <p class = "or"> — or — </p>
                        <div class = "links">
                            <p> Already have an account?</p>
                            <button id="signUpNow" class="loginBtn">Log In</button>
                        </div>
                    </div>
    
                    <div class="sign-in-card" id="signIn" style="display: none;">
                        <h3 class="form-title">Log In</h3>
                        <form method="post">
                           <div class="input-group">
                               <input type = "text" name = "lgmail" id = "lgmail" required style="text-transform: none;">
                               <label for = "gmail">Email Address/Username</label>
                           </div>
                           <div class="input-group">
                               <input type = "password" name = "lpass" id = "lpass" autocomplete="off" required>
                               <label for = "pass">Password</label>
                           </div>
                           <button id="logInNow" class = "btn">Log In</button>
                        </form>
                        <p class = "or"> — or — </p>
                        <div class = "links">
                            <p> Don't have an account yet?</p>
                            <button id = "signUpBtn">Sign Up</button>
                        </div>
                    </div>
                </div>
            </section>
        </header>
        <div id="notif-prompt" style="display: none;">
            <p id="notification"> this is sample text.</p>
        </div>
        <section class="home" id="home">
            <div class="home-container" id="homeCont">
                <div class="preview-page" id="prev1">
                    <h1>Check our available shops near you</h1>
                    <div class="prev-map" id="prevMap"></div>
                    <a class="btn" href="#store">Check our Stores</a>
                </div>
                <div class="preview-page" id="prev2">
                    <h1>Explore New Taste</h1>
                    <h2><span></span> Try our all time top-rated best combos</h2>
                    <div class="prod">
                        <div class="prev-prod">
                            <div class="donut-img"></div>
                            <div class="drink-img"></div>
                        </div>
                        <div class="prev-prod">
                            <div class="donut-img"></div>
                            <div class="drink-img"></div>
                        </div>
                        <div class="prev-prod">
                            <div class="donut-img"></div>
                            <div class="drink-img"></div>
                        </div>
                    </div>
                </div>
                <div class="preview-page" id="prev3">
                    <div class="prev-bg">
                        <a class="btn" href="#product">Order Now</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="product" id="product">
            <div class="max-container" id="maxCont" style="display: none;">
                <div id="hideID" style="display: none;"></div>
                <div class="max-card" id="maxCard">
                    <div id="hiddenMaxImg" style="display: none;"></div>
                    <div class="max-img" style="height: 60%; width: 100%;"></div>
                    <div class="max-desc">
                        <div class="max-info">
                            <p class="name">Product Name</p>
                            <p class="prod-info">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                        </div>
                        <form action="" method="post">
                            <p style="display: none;"><strong>Size/s</strong></p>
                            <div class="select-size" style="display: none;">
                                <input type="checkbox" id="size1" name="size">
                                <label for="size1">Small</label>
                        
                                <input type="checkbox" id="size2" name="size">
                                <label for="size2">Medium</label>
                        
                                <input type="checkbox" id="size3" name="size">
                                <label for="size3">Large</label>
                            </div>
                            <div class="select-qty">
                                <p><strong>Quantity</strong></p>
                                <input type="number" name="qty" id="qty" min="1" max="99" value="1" onchange = "addQuantity(this)" required>
                                <p class="total-text">₱ 0.00</p>
                                <div id="price" style="display: none;"></div>
                            </div>
                        </form>
                        <div class="max-btn">
                            <div id="cancelBtn"><i class="fa-solid fa-chevron-left"></i></div>
                            <button id="buyBtn" onclick="buyItem()">Purchase</button>
                            <button id="addtoCartBtn"><i class="fa-solid fa-basket-shopping"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="sec-title">Our Products</h3>
            <div class="prod-container">
                <div class="search">
                    <div class="search-form">
                        <input type="text" name="search-text" id="searchText" placeholder="Search">
                        <div class="search-btn" id="searchBtn" onclick="searchProduct();"><i class="fa-solid fa-magnifying-glass"></i></div>
                    </div>
                </div>
                <div class="cat-container">
                        <input type="checkbox" id="option1" name="option" value="option-1" checked="true" onchange="changeCategory(this)">
                        <label for="option1" >All</label>
                
                        <input type="checkbox" id="option2" name="option" value="option-2" onchange="changeCategory(this)">
                        <label for="option2" >Donut</label>
                
                        <input type="checkbox" id="option3" name="option" value="option-3" onchange="changeCategory(this)">
                        <label for="option3" >Pastry</label>
                
                        <input type="checkbox" id="option4" name="option" value="option-4" onchange="changeCategory(this)">
                        <label for="option4" >Beverage</label>
                </div>
                <div class="prod-display" id="prodDisplay">

                </div>
            </div>
        </section>
        <section id="service">
            <h3 class="sec-title">Our Services</h3>
            <div class="services">
                <div class="service-card">
                    <div class="service-img"><i class="fa-solid fa-route"></i></div>
                    <p class="desc">Use our interactive map to find the nearest pastry shop or check availability through popular services like Grab or Panda.</p>
                </div>

                <div class="service-card">
                    <div class="service-img"><i class="fa-solid fa-utensils"></i></div>
                    <p class="desc">Come and enjoy our cozy dine-in space! Savor the freshly baked pastries and relaxing atmosphere with your family and friends.</p>
                </div>

                <div class="service-card">
                    <div class="service-img"><i class="fa-solid fa-cake-candles"></i></div>
                    <p class="desc">Make your celebrations extra special and unforgettable by bringing our tasty pastries in your plates.</p>
                </div>

                <div class="service-card">
                    <div class="service-img"><i class="fa-solid fa-car-rear"></i></div>
                    <p class="desc">Choose the best way to enjoy our pastries! Either by picking up your order at one of our stores or having it delivered straight to your door.</p>
                </div>
            </div>
        </section>
        <section id="about">
            <h3 class="sec-title">About Us</h3>
            <div class="about">
                <div class="about-card">
                    <div class="about-img" style="background: url(resource/pexels-fotios-photos-3341067.jpg) no-repeat center; background-size: cover;"></div>
                    <div class="about-desc">
                        <h4 class="about-title">History</h4>
                        <p>
                        Began in 1997, with a passion for baking and a dream to share the joy of pastries with the world. What started as a small family venture in a modest kitchen has now grown into a beloved pastry shop known for its quality and innovation. From day one, we were committed to using the finest ingredients and traditional baking techniques, passed down through generations. Over the years, our dedication to excellence and our love for creating unique, flavorful pastries allowed us to win numerous awards and the hearts of our customers.
                        </p>
                        <p>As the business flourished, we expanded our offerings and stores, opening new locations and developing a loyal customer base who appreciate the handcrafted care that goes into every product.</p>
                    </div>
                </div>
            </div>
            <div class="about">
                <div class="about-card">
                    <div class="about-img" style="background: url(resource/pikaso_embed_A-young-Hispanic-woman-wearing-a-white-chefs-hat-a.jpeg) no-repeat center; background-size: cover;"></div>
                    <div class="about-desc">
                        <h4 class="about-title">Chefs & Staffs</h4>
                        <p>
                        At the heart of our pastry shop is a dedicated team of chefs and staff who share a passion for baking and serving with excellence. Our talented chefs are masters in creating a wide array of pastries, from traditional favorites to innovative new treats. Each pastry is made with love, care, and the finest ingredients, ensuring that every bite is a delightful experience.
                        </p>
                        <p>Behind the scenes, our heroes works tirelessly to make sure every customer feels welcome and leaves with a smile. From the moment you step into our shop to the moment you take your first bite, our team is here to provide you with the best pastry experience possible.</p>
                    </div>
                </div>
            </div>
            <div class="about">
                <div class="about-card">
                    <div class="about-img" style="background: url(resource/pikaso_embed_A-cozy-and-inviting-bakery-interior-with-wooden-sh.jpeg) no-repeat center; background-size: cover;"></div>
                    <div class="about-desc">
                        <h4 class="about-title">Stores</h4>
                        <p>
                        Step into any of our delightful pastry shops and experience the warm, inviting atmosphere that our customers have come to love. The moment you enter, you’ll be greeted by the comforting aroma of freshly baked pastries, breads, and desserts, all crafted with the finest ingredients. Each of our stores is designed to be a cozy retreat where you can relax with a cup of coffee or tea while savoring a selection from our mouth-watering menu.
                        </p>
                        <p>Our stores aren’t just places to buy pastries—they are gathering spots for friends, family, and colleagues to enjoy great conversations over delicious treats. Whether you're in the mood for a quick breakfast, need a delightful dessert for your next dinner party, or are looking for a personalized cake for a special occasion, we’re here to make every visit special.</p>
                    </div>
                </div>
            </div>
            <h3 class="award-title">Awards & Achievements</h3>
                <div class="awards">
                    <div class="awards-card">
                        <div class="award-inner">
                            <div class="award-front">
                                <div class="award-img"></div>
                                <div class="award-info">
                                    <h4>1997 Best Pastry Shop</h4>
                                    <p><em>- IFEX Philippines Awards</em></p>
                                </div>
                            </div>
                            <div class="award-back">
                                <p>
                                <b>"Best Pastry Shop" Award</b><br>
                                <em>February 11, 1997</em>
                                </p>
                                <p>
                                    A classic and general award, great for establishing a long history of excellence.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="awards-card">
                        <div class="award-inner">
                            <div class="award-front">
                                <div class="award-img"></div>
                                <div class="award-info">
                                    <h4>Golden Whisk Award</h4>
                                    <p><em>- 2004 National Baking Competition.</em></p>
                                </div>
                            </div>
                            <div class="award-back">
                                <p>
                                <b>"The Golden Whisk" Award</b><br>
                                <em>May 25, 2004</em>
                                </p>
                                <p>
                                    Received for excellence in baking techniques and presentation at the Nat'l Baking Competition.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="awards-card">
                        <div class="award-inner">
                            <div class="award-front">
                                <div class="award-img"></div>
                                <div class="award-info">
                                    <h4>Customer Choice Award (2007)</h4>
                                    <p><em>- Katha Awards for Food</em></p>
                                </div>
                            </div>
                            <div class="award-back">
                                <p>
                                <b>"Customer Choice" Award</b><br>
                                <em>January 31, 2007</em>
                                </p>
                                <p>
                                    Voted by patrons as the best dessert destination in the city, celebrating consistent quality and service.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="awards-card">
                        <div class="award-inner">
                            <div class="award-front">
                                <div class="award-img"></div>
                                <div class="award-info">
                                    <h4>Innovative Drink of the Year 2015</h4>
                                    <p><em>- Bakery Fair Philippines</em></p>
                                </div>
                            </div>
                            <div class="award-back">
                                <p>
                                <b>"Innovative Drink of the Year" Award</b><br>
                                <em>December 29, 2015</em>
                                </p>
                                <p>
                                    Awarded for the signature drink <b>"Caramel Frapuccino"</b> which features unique flavor pairings and artistic presentation.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="awards-card">
                        <div class="award-inner">
                            <div class="award-front">
                                <div class="award-img"></div>
                                <div class="award-info">
                                    <h4>Sustainability Recognition</h4>
                                    <p><em>- Coupe du Monde de la Pâtisserie (2023)</em></p>
                                </div>
                            </div>
                            <div class="award-back">
                                <p>
                                <b>"Sustainability Recognition" Award</b><br>
                                <em>October 25, 2023</em>
                                </p>
                                <p>
                                    Honored for eco-friendly practices, including sourcing of local ingredients and using sustainable packaging.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="store">
            <h2 class="sec-title">Our Stores</h2>
            <div class="store" style="height: 100%; width: 100%; display: flex;">
                <div class="dropdown" style="width: 30%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: right;">
                    <ul style="list-style: none; height: auto; width: auto;">
                        <li class="f-list">
                            <div class="fli" id="ncrBtn">
                                <p>
                                    <i class="fa-solid fa-square-caret-right" id="ffShow"></i>
                                    <i class="fa-regular fa-square-caret-down" id="ffHide" style="display: none;"></i>
                                    National Capital Region (NCR)
                                </p>
                            </div>
                            <div class="inner-menu" id="ffInnerMenu" style=" display: none;">
                                <ul>
                                    <li style="padding-left: 2.5rem; background-color: #FFD35A; margin-left: 0;"><a href="#manila"><p style="padding-left: 1.1rem;">Manila City</p></a></li>
                                    <li class="s-list" style="display: flex; width: 100%; background-color: #FFD35A; padding-left: 1.5rem; flex-direction: column; height: auto;">
                                        <div class="fli" id="muntiBtn"><p>
                                            <i class="fa-solid fa-square-caret-right" id="fsShow"></i>
                                            <i class="fa-regular solid fa-square-caret-down" id="fsHide" style="display: none;"></i>
                                            Muntinlupa City
                                        </p></div>
                                        <div class="inner-menu" style="margin-left: -15px; display: none;" id="fsInnerMenu">
                                            <ul>
                                                <li style="padding-left: 3.5rem; background-color: #FFB22C;"><a href="#alabang"><p style="padding-left: 1.1rem;">Alabang</p></a></li>
                                                <li style="padding-left: 3.5rem; background-color: #FFB22C;"><a href="#tunasan"><p style="padding-left: 1.1rem;">Tunasan</p></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li style="padding-left: 2.5rem; background-color: #FFD35A;"><a href="#pasay"><p style="padding-left: 1.1rem;">Pasay City</p></a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="f-list">
                            <div class="fli" id="IVABtn"><p>
                                <i class="fa-solid fa-square-caret-right" id="sShow"></i>
                                <i class="fa-regular fa-square-caret-down" id="sHide" style="display: none;"></i>
                                Region IV-A (CALABARZON)
                            </p></div>
                            <div class="inner-menu" id="sInnerMenu" style=" display: none;">
                                <ul>
                                    <li style="padding-left: 2.5rem; background-color: #FFD35A;"><a href="#cavite"><p style="padding-left: 1.1rem;">Cavite City</p></a></li>
                                    <li style="padding-left: 2.5rem; background-color: #FFD35A;"><a href="#laguna"><p style="padding-left: 1.1rem;">Laguna City</p></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="address-box">
                    <div class="add-container">
                        <div class="store-card" id="manila">
                            <h4 class="branch">Manila Branch</h4>
                            <div class="store-info">
                                <div class="store-img"></div>
                                <div class="map-location" id="map1"></div>
                            </div>
                            <p class="store-address"><i class="fa-solid fa-location-dot"></i>2 Asean Garden, Bgy 654, Zone 069 Intramuros Manila</p>
                        </div>
                        
                        <div class="store-card" id="alabang">
                            <h4 class="branch">Alabang Branch</h4>
                            <div class="store-info">
                                <div class="store-img"></div>
                                <div class="map-location" id="map2"></div>
                            </div>
                            <p class="store-address"><i class="fa-solid fa-location-dot"></i>The River Park, Festival Supermall, Muntinlupa, Kalakhang Maynila</p>
                        </div>
        
                        <div class="store-card" id="tunasan">
                            <h4 class="branch">SM Tunasan Branch</h4>
                            <div class="store-info">
                                <div class="store-img"></div>
                                <div class="map-location" id="map3"></div>
                            </div>
                            <p class="store-address"><i class="fa-solid fa-location-dot"></i>SM Center, Muntinlupa, 1774 Metro Manila</p>
                        </div>
        
                        <div class="store-card" id="pasay">
                            <h4 class="branch">Mall of Asia Branch</h4>
                            <div class="store-info">
                                <div class="store-img"></div>
                                <div class="map-location" id="map4"></div>
                            </div>
                            <p class="store-address"><i class="fa-solid fa-location-dot"></i>SM Mall of Asia, Seaside Blvd, Pasay, 1300 Metro Manila</p>
                        </div>
        
                        <div class="store-card" id="cavite">
                            <h4 class="branch">Cavite Branch</h4>
                            <div class="store-info">
                                <div class="store-img"></div>
                                <div class="map-location" id="map5"></div>
                            </div>
                            <p class="store-address"><i class="fa-solid fa-location-dot"></i>13123 Calumpang Road, Carmona, Cavite</p>
                        </div>
        
                        <div class="store-card" id="laguna">
                            <h4 class="branch">Sta Rosa Branch</h4>
                            <div class="store-info">
                                <div class="store-img"></div>
                                <div class="map-location" id="map6"></div>
                            </div>
                            <p class="store-address"><i class="fa-solid fa-location-dot"></i>Block 22 Lot 2 Phase 2 Lotus corner Champaca Street Garden Villas 3 Brgy, Santa Rosa, Laguna</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <div class="upper">
                <div class="contact-title">
                    <h2>Contact Us:</h2>
                    <div class="socials">
                        <a href="#"><i class="fa-brands fa-square-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-square-x-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-square-instagram"></i></a>
                    </div>
                </div>
                <div class="contact-links">
                    <div class="ordering">
                        <p>For ordering:</p>
                        <p class="number"><strong>+63 9123456789</strong></p>
                        <p class="number"><strong>+63 9876543210</strong></p>
                    </div>
                    <div class="inquiries">
                        <p>For inquiries:</p>
                        <p class="number"><strong>+63 9024681357</strong></p>
                        <p class="number"><strong>yourpastryhub@gmail.com</strong></p>
                    </div>
                    <div class="links">
                        <a href="#product">Our Products</a>
                        <a href="#service">Services</a>
                        <a href="#about">About Us</a>
                    </div>
                </div>
            </div>
            <div class="lower">
                <p>All Rights Reserved | Copyright 2024</p>
            </div>
        </footer>
        <script src="script.js"></script>
    </body>
</html>