<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dashboard</title>

        <link rel="icon" href="resource/logo.ico" type="image/ico">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/9bd5c7f2ea.js" crossorigin="anonymous"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
            :root{
                --sec-color: rgb(252,220, 115);
                --compli-color: rgb(37,37,37);
                --first-font: "Nunito", sans-serif;
                --second-font: "Figtree", sans-serif;
            }

            *{
                box-sizing: border-box;
                padding: 0;
                margin: 0;
                font-family: var(--second-font);
                transition: .1s linear;
            }

            body{
                height: 100vh;
                width: 100vw;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .adminpage{
                height: 100%;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
                padding: 1rem;
                box-shadow: 0 0 15px 5px #afafaf;
                gap: 1rem;
            }
            
            .adminpage h4{
                width: 85%;
            }

            .adminpage .btn-btn{
                padding: .5rem 1.5rem;
                background: white;
                color: black;
                border-radius: 5px;
                border: 1px solid var(--compli-color);
            }

            .adminpage .btn-btn:hover{
                background: var(--compli-color);
                color: white;
            }

            .adminpage form{
                height: 100%;
                width: 35%;
                display: flex;
                align-items: center;
                justify-content: right;
                flex-direction: column;
                padding: 1rem;
                border-radius: 15px;
                box-shadow: 0 0 15px 5px #afafaf;
            }

            .adminpage form h1{
                width: 100%;
                text-align: center;
            }

            .adminpage form .info-card{
                height: 100%;
                width: 100%;
                display: flex;
                flex-wrap: wrap;
                gap: 2rem;
            }

            .adminpage form .image-card{
                height: 100%;
                width: 100%;
                display: flex;
            }

            .adminpage form input[type='file']{
                width: 100%;
                height: auto;
            }

            .adminpage form .info-card input{
                color: inherit;
                width: 100%;
                background-color: transparent;
                border: none;
                border-bottom: 1px solid #757575;
                padding-left: 1.5rem;
                font-size: 15px;
            }

            .adminpage form .info-card .input-group{
                padding: 1% 0;
                width: 46%;
                position: relative;
                display: flex;
                flex-direction: column;
                margin: -20px 0;
            }

            .adminpage form .info-card .input-group:nth-child(1){
                width: 100%;
                margin: 0;
            }

            .adminpage form .info-card .input-group input:focus{
                background-color: transparent;
                outline: transparent;
                border-bottom: 2px solid blue;
            }

            .adminpage form .info-card .input-group input::placeholder{
                color: transparent;
            }

            .adminpage form .info-card .input-group label{
                color: #757575;
                height: 15px;
                width: 60%;
                position: relative;
                left: 0.7em;
                top: -1.5em;
                cursor: auto;
                transition: 0.3s ease all;
            }

            .adminpage form .info-card .input-group input:focus~label, .adminpage form .input-group input:not(:placeholder-shown)~label{
                top: -3em;
                color: blue;
                font-size: 15px;
            }

            .adminpage form .info-card .input-group-1{
                display: flex;
                flex-direction: column-reverse;
            }

            .adminpage form .info-card .input-group-1 label{
                color: blue;
            }

            textarea{
                padding: .5rem 1rem;
                width: 100%;
                max-height: 100px;
                min-height: 100px;
                height: 100px;
            }

            .adminpage form .image-card .input-group{
                height: 100%;
                width: 100%;
                display: flex;
                flex-direction: column-reverse;
                margin-top: -30px;
                align-items: center;
                padding: 0 5rem;
            }

            .adminpage form .image-card .input-group .inner{
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .adminpage form .image-card .input-group input{
                height: auto;
                margin-top: .5rem;
            }

            .adminpage form .image-card .input-group label{
                color: blue;
            }

            .adminpage form .image-card .show-img{
                height: 125px;
                width: 125px;
                background: #333333;
            }

            .adminpage form .submit-btn{
                height: 30%;
                width: 100%;
                display: flex;
                align-items: flex-end;
                justify-content: right;
            }

            .adminpage form input[type='submit']{
                padding: 1rem 2rem;
                border-radius: 5px;
                background: transparent;
                border: none;
                border: 1px solid var(--compli-color);
            }

            .adminpage form input[type='submit']:hover{
                box-shadow: 0 0 5px 1px #afafaf;
                background: var(--compli-color);
                color: white;
            }

            .adminpage .right-side{
                width: 63%;
                height: 100%;
                display: flex;
                row-gap: 1rem;
                flex-direction: column-reverse;
            }

            .adminpage .user-list, .order-list{
                height: 50%;
                border-radius: 15px;
                box-shadow: 0 0 15px 5px #afafaf;
                overflow: hidden;
                padding: 1rem;
                display: flex;
                flex-wrap: wrap;
            }
            
            .order-list .order-table{
                height: 90%;
                width: 100%;
                overflow-y: scroll;
            }
             
            .order-list .order-table .column-title{
                padding: .5rem .5rem 0;
                height: 45px;
                width: 100%;
                display: flex;
                border-bottom: 2px solid #dddddd;
                align-items: baseline;
            }

            .order-list .order-table .column-title p{
                width: 15%;
                height: 100%;
                display: flex;
                align-items: center;
            }

            .order-list .order-table .column-title p:nth-of-type(2) {
                width: 20%;
            }

            .order-list .order-table .column-title p:nth-of-type(3), .order-list .order-table .column-title p:nth-of-type(4) {
                width: 10%;
            }

            .order-list .order-table .column-title p:nth-of-type(5) {
                width: 20%;
            }

            .order-list .order-table .order-summary{
                width: 100%;
                height: 15%;
                display: flex;
                flex-direction: column;
                padding: .5rem;
            }

            .order-list .order-table .order-summary .summary{
                height: 40px;
                width: 100%;
                display: flex;
                align-items: center;
                position: sticky;
            }

            .order-list .order-table .order-summary .summary p{
                width: 20%;
                height: 100%;
                font-size: .9rem;
                display: flex;
                align-items: end;
            }

            .order-list .order-table .order-summary .summary p:nth-of-type(1){
                width: 15%;
            }

            .order-list .order-table .order-summary .summary p:nth-of-type(3), .order-list .order-table .order-summary .summary p:nth-of-type(4) {
                width: 10%;
                padding-left: .3rem;
            }
            
            .order-list .order-table .order-summary .summary p:nth-of-type(5){
                width: 20%;
                padding-left: .5rem;
            }

            .order-list .order-table .order-summary .summary .action-btn{
                width: 25%;
                height: 100%;
                display: flex;
                align-items: start;
                padding-left: .8rem;
                gap: .3rem;
            }

            .order-list .order-table .order-summary .summary .action-btn .btn{
                padding: .4rem .5rem;
                border-radius: 5px;
            }

            .order-list .order-table .order-summary .summary .action-btn .btn-primary{
                background: rgb(0, 0, 200);
            }

            .order-list .order-table .order-summary .summary .action-btn .btn-danger{
                background: rgb(200, 0, 0);
            }

            .order-list .order-table .order-summary .summary .action-btn .btn-primary:hover{
                background: rgb(0, 0, 255);
            }

            .order-list .order-table .order-summary .summary .action-btn .btn-danger:hover{
                background: rgb(255, 0, 0);
            }

            .order-list .order-table .order-summary .summary .action-btn button{
                padding: .4rem .5rem;
                border: none;
                background: transparent;
                border-radius: 5px;
            }

            .order-list .order-table .order-summary .summary .action-btn button:hover{
                background: #afafaf;
                color: white;
            }

            .order-list .order-table .order-summary .summary .action-btn .resize-btn .fa-chevron-up {
                display: none;
            }

            .order-list .order-table .order-summary .summary .action-btn .resize-btn .fa-chevron-down{
                display: block;
            }

            .order-list .order-table .order-summary .summary .action-btn .resize-btn.active .fa-chevron-up{
                display: block;
            }

            .order-list .order-table .order-summary .summary .action-btn .resize-btn.active .fa-chevron-down{
                display: none;
            }

            .order-list .order-table .order-summary .per-item{
                width: 100%;
                height: 100%;
                border: 1px solid #cccccc;
                overflow-y: scroll;
                display: none;
            }

            .order-list .order-table .order-summary .per-item table thead{
                width: 55.5%;
                background: #dedede;
            }

            .order-list .order-table .order-summary .per-item table thead tr{
                width: 100%;
            }

            .order-list .order-table .order-summary .per-item table thead tr th{
                font-size: .9rem;
                color: #555555;
                background: #dedede;
            }

            .order-list .order-table .order-summary .per-item table tbody tr td{
                font-size: .9rem;
                color: #333333;
                background: #fafafa;
            }
        </style>
    </head>
    <body>
        <div class="adminpage">
            <form action="submit.php" method="post" autocomplete="off" enctype="multipart/form-data">
                <h1>Add Product</h1>
                <div class="image-card">
                    <div class="input-group">
                        <div class="inner">
                            <input type = "file" name = "img" id = "img" accept=".jpg, .jpeg, .png" required>
                        </div>
                        <div class="show-img" id="showImg"></div>
                        <label for = "pass">Insert Image</label>
                    </div>
                </div>
                <div class="info-card">
                    <div class="input-group">
                        <input type = "text" name = "prodname" id = "prodName" placeholder = "Product Name" required>
                        <label for = "prodName">Product Name</label>
                    </div>
                    <div class="input-group">
                        <input type = "text" name = "prodtype" id = "prodType" placeholder = "Product Type" required>
                        <label for = "prodtype">Product Type</label>
                    </div>
                    <div class="input-group">
                        <input type = "number" name = "prodprice" id = "prodPrice" step=".01" placeholder = "0.00" required>
                        <label for = "pass">Product Price</label>
                    </div>
                    <div class="input-group-1">
                    <textarea id="prodDesc" name="proddesc" rows="5" cols="50" placeholder="Input Product Description"></textarea>
                        <label for = "prodDesc">Product Description</label>
                    </div>
                </div>
                <div class="submit-btn">
                    <input type = "submit" class = "add-prod" name = "addprod" value = "Add Product">
                </div>
            </form>
            <div class="right-side">
                <div class="user-list">
                    <h4>User Accounts</h4>
                    <button class="btn-btn" onclick="refreshpage()">Refresh</button>
                    <div class="table-responsive-xl" style="width: 100%; overflow-y: auto; overflow-x: hidden; height: 250px;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Contact Number</th>
                                    <th>Email Address</th>
                                </tr>
                            </thead>
                        
                            <tbody id="userContainer">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="order-list">
                    <h4>Pending Order</h4>
                    <button class="btn-btn" onclick="refreshOrder()">Refresh</button>
                    <div class="order-table">
                        

                    </div>
                            <?php /*
                            $sql = "SELECT * FROM login";
                            $result = $conn->query($sql);
                            if (!$result) {
                                die("Invalid Query: ".$conn->error);
                            }
                            while($row = $result->fetch_assoc())
                            {
                                echo "<tr>
                                <td>$row[userid]</td>
                                <td>$row[fname]</td>
                                <td>$row[lname]</td>
                                <td>$row[email]</td>
                                <td>
                                    <a class = 'btn btn-primary btn-sm' href = 'editUser.php?id=$row[userid]'>Verify Order</a>
                                </td>
                                </tr><!--";
                            }   */                                 
                            ?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>

        window.onload = function() {
            refreshpage();
            refreshOrder();
        }

        document.getElementById('img').addEventListener('change', function(event) {
            const file = event.target.files[0];
            var passImg = document.getElementById('showImg');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    passImg.style.background = "url(" + e.target.result + ") no-repeat center";
                    passImg.style.backgroundSize = "cover";
                };
                reader.readAsDataURL(file);
            }
        });

        document.querySelectorAll('.resize-btn').forEach(resize => {
            resize.addEventListener('click', function() {
                const getParent = this.getAttribute('data-target');
                const target = this.getAttribute('data-target-1');
                const showInfo = document.getElementById(target);
                const resizePage = document.getElementById(getParent);
                if (showInfo.style.display !== "block") {
                    showInfo.style.display = "block";
                    resizePage.style.height = "100%";
                    this.classList.toggle('active');
                    this.style.background = "#afafaf";
                    this.style.color = "white";
                } else {
                    showInfo.style.display = "none";
                    resizePage.style.height = "15%";
                    this.classList.remove('active');
                    this.style.background = "transparent";
                    this.style.color = "black";
                }
                document.querySelectorAll('.per-item').forEach(info => {
                    if (info.id !== target) {
                        info.style.display = "none";
                        resize.classList.remove('active');
                        resize.style.background = "transparent";
                        resize.style.color = "black";
                    }
                });
                document.querySelectorAll('.order-summary').forEach(drop => {
                    if (drop.id !== getParent) {
                        drop.style.height = "15%";
                    }
                });
            });
        });

        window.addEventListener('click', function(event){
            if (!event.target.closest('.resize-btn')) {
                document.querySelectorAll('.per-item').forEach(drop => {
                    drop.style.display = "none";
                });
                document.querySelectorAll('.resize-btn').forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.background = "transparent";
                    btn.style.color = "black";
                });
                document.querySelectorAll('.order-summary').forEach(parent => {
                    parent.style.height = "15%";
                });
            }
        });

        function refreshpage() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "getproduct.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("refreshPage=1");
            xhr.onload = function() {
                if (xhr.status !== 200) {
                    notif(errorText);
                } else {
                    document.getElementById('userContainer').innerHTML = xhr.responseText;
                }
            }; 
        }

        function refreshOrder() {
            document.querySelector('.order-table').innerHTML = "<div class=\"column-title\"><p><strong>Order Tag</strong></p><p><strong>Recipient ID</strong></p><p><strong>Items</strong></p><p><strong>Total</strong></p><p><strong>Status</strong></p><p><strong>Action</strong></p></div>";
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "getproduct.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("refreshOrder=1");
            xhr.onload = function() {
                if (xhr.status !== 200) {
                    notif(errorText);
                } else {
                    document.querySelector('.order-table').innerHTML += xhr.responseText;
                }
            }; 
        }
        
        function maximize(clicked){
            const getParent = clicked.getAttribute('data-target');
                const target = clicked.getAttribute('data-target-1');
                const showInfo = document.getElementById(target);
                const resizePage = document.getElementById(getParent);
                if (showInfo.style.display !== "block") {
                    showInfo.style.display = "block";
                    resizePage.style.height = "100%";
                    this.classList.toggle('active');
                    this.style.background = "#afafaf";
                    this.style.color = "white";
                } else {
                    showInfo.style.display = "none";
                    resizePage.style.height = "15%";
                    this.classList.remove('active');
                    this.style.background = "transparent";
                    this.style.color = "black";
                }
                document.querySelectorAll('.per-item').forEach(info => {
                    if (info.id !== target) {
                        info.style.display = "none";
                        resize.classList.remove('active');
                        resize.style.background = "transparent";
                        resize.style.color = "black";
                    }
                });
                document.querySelectorAll('.order-summary').forEach(drop => {
                    if (drop.id !== getParent) {
                        drop.style.height = "15%";
                    }
                });
        }

        function proceed(tag) {
            const ordertag = tag.getAttribute('data-target');
            const status = tag.getAttribute('data-target-1');
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "getproduct.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("proceed=1&tag=" + document.getElementById(ordertag).innerText + "&stats=" + document.getElementById(status).innerText);
            xhr.onload = function() {
                if (xhr.status !== 200) {
                    notif(errorText);
                } else {
                    refreshOrder();
                }
            }; 
        }

        function deleteOrder(tag) {
            const ordertag = tag.getAttribute('data-target');
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "getproduct.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("deleteOrder=1&tag=" + document.getElementById(ordertag).innerText);
            xhr.onload = function() {
                if (xhr.status !== 200) {
                    notif(errorText);
                } else {
                    refreshOrder();
                }
            }; 
        }
    </script>
    </body>
</html>