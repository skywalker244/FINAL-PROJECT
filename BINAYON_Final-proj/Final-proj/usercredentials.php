<?php
class User {
    private function getData($sql) {
        include("connect.php");
        $result = $connect ->query($sql);
		if(!$result) {
            die("Invalid Query: " . $connect->error);
        }
		$data= array();
        while ($row = $result->fetch_assoc()) {
			$data[]=$row;            
		}
		return $data;
    }

    private function inputData($sql) {
        include("connect.php");
        if ($connect->query($sql)) {
            $notif = "0";
        } else {
            $notif = "1";
        }
        return $notif;
    }

    public function displayUserData($mode) {
        $userid = $_SESSION["userid"];
        $sql = "SELECT * FROM userinfo WHERE UIID = '$userid'";
        $data = $this->getData($sql);
        $userdata = "";

        if(isset($mode) && $mode == "0") {
            foreach($data as $udata => $info) {
                $address = $info["blk"] . " " . $info["street"] . " " . $info["brgy"] . " " . $info["city"] . " " . $info["province"] . " " . $info["zipCode"];

                $userdata .= "
                    <div class=\"info-card\">
                        <form action=\"#\" method=\"post\" >
                ";
                $userdata .= "
                    <div class=\"input-group\">
                        <label for=\"fname\">Full Name</label> 
                        <div id=\"h-name\" style=\"display: none;\">$info[fname] "." $info[mname] "." $info[lname]</div>
                        <div class=\"edit-btn\" data-target=\"fname\" data-target-1=\"h-name\" onclick=\"editInfo()\">
                            <i class=\"fa-solid fa-pen\"></i>
                        </div>
                        <input type=\"text\" name=\"fname\" id=\"fname\" class=\"inputs\" data-target=\"h-name\" disabled=\"true\" value=\"$info[fname] "."$info[lname]\" required>
                    </div>
                ";
                $userdata .= "
                    <div class=\"input-group\">
                        <label for=\"sex\">Sex</label>
                        <div id=\"h-sex\" style=\"display: none;\">$info[sex]</div>
                        <div class=\"edit-btn\" id=\"editSex\" data-target=\"sex\" data-target-1=\"h-sex\" onclick=\"inputClick()\">
                            <i class=\"fa-solid fa-pen\"></i>
                        </div>
                        <input name=\"sex\" id=\"sex\" placeholder=\"set\" class=\"inputs\" data-target=\"h-sex\" value=\"$info[sex]\" disabled=\"true\">
                        <div class=\"select-sex\" style=\"display: none;\">
                            <div id=\"male\" onclick=\"sexSelect(this)\">Male</div>
                            <div id=\"female\" onclick=\"sexSelect(this)\">Female</div>
                            <div id=\"other\" onclick=\"sexSelect(this)\">Other</div>
                        </div>
                    </div>
                ";
                $userdata .= "
                    <div class=\"input-group\">
                        <label for=\"age\">Age</label>
                        <div id=\"h-age\" style=\"display: none;\">$info[age]</div>
                        <div class=\"edit-btn\" data-target=\"age\" data-target-1=\"h-age\" onclick=\"editInput(this)\">
                            <i class=\"fa-solid fa-pen\"></i>
                        </div>
                        <input type=\"number\" name=\"age\" id=\"age\" class=\"inputs\" data-target=\"h-age\" min=\"1\" max=\"99\" placeholder=\"set\" value=\"$info[age]\" disabled=\"true\">
                    </div>
                ";
                $userdata .= "
                    <div class=\"input-group\">
                        <label for=\"bday\">Birthday</label>
                        <div id=\"h-bday\" style=\"display: none;\">$info[bday]</div>
                        <div class=\"edit-btn\" data-target=\"bday\" data-target-1=\"h-bday\" onclick=\"editInput(this)\">
                            <i class=\"fa-solid fa-pen\"></i>
                        </div>
                        <input type=\"date\" name=\"bday\" id=\"bday\" class=\"inputs\" data-target=\"h-bday\" value=\"$info[bday]\" disabled=\"true\" data-target-1=\"age\" onchange=\"changeAge(this)\">
                    </div>
                ";
                $userdata .= "
                    <div class=\"input-group\">
                        <label for=\"contact\">Contact Number</label>
                        <div id=\"h-contact\" style=\"display: none;\">$info[contact]</div>
                        <div class=\"edit-btn\" data-target=\"contact\" data-target-1=\"h-contact\" onclick=\"editInput(this)\">
                            <i class=\"fa-solid fa-pen\"></i>
                        </div>
                        <input type=\"text\" name=\"contact\" id=\"contact\" class=\"inputs\" maxlength=\"11\" data-target=\"h-contact\" value=\"$info[contact]\" disabled=\"true\">
                    </div>
                ";
                $userdata .= "
                    <div class=\"input-group\">
                        <label for=\"address\">Address</label>
                        <div id=\"h-address\" style=\"display: none;\"></div>
                        <div class=\"edit-btn\" data-target=\"address\" data-target-1=\"h-address\" value=\"$address\" onclick=\"editInfo()\">
                            change address
                            <i class=\"fa-solid fa-pen\"></i>
                        </div>
                        <textarea name=\"address\" id=\"address\" class=\"inputs\" data-target=\"h-address\" disabled=\"true\">$address</textarea>
                    </div>
                    <div class=\"btn-holder\">
                        <button class=\"btn-btn\" id=\"cancelChanges\" disabled=\"true\">Cancel</button>
                        <button class=\"btn-btn\" id=\"saveChanges\" disabled=\"true\" onclick=\"saveInfo()\">Save</button>
                    </div>
                ";

                $userdata .= "
                        </form>
                    </div>
                ";
            }
        } else {
            foreach($data as $udata => $info) {
                $home = "";
                $office = "";
                $male = "";
                $female = "";
                $other = "";

                if (isset($info["addressType"])) {
                    if ($info["addressType"] == "Home") {
                        $home = "checked";
                        $office = "";
                    } elseif($info["addressType"] == "Office") {
                        $home = "";
                        $office = "checked";
                    }
                }
                if (isset($info["sex"])) {
                    if($info["sex"] == "Male") {
                        $male = "checked";
                        $female = "";
                        $other = "";
                    } elseif ($info["sex"] == "Female") {
                        $female = "checked";
                        $male = "";
                        $other = "";
                    } elseif ($info["sex"] == "Other") {
                        $other = "checked";
                        $female = "";
                        $male = "";
                    }
                }

                $userdata .= "
                    <form action=\"#\" method=\"post\" id=\"editInfoForm\">
                        <div class=\"name-info\">
                            <h4>Name</h4>
                            <div class=\"group-input\">
                                <label for=\"ln\">Last Name</label>
                                <input type=\"text\" name=\"ln\" id=\"ln\" placeholder=\"Last Name\" value=\"$info[lname]\" required>
                            </div>
                            <div class=\"group-input fn\">
                                <label for=\"fn\">First Name</label>
                                <input type=\"text\" name=\"fn\" id=\"fn\" placeholder=\"First Name\" value=\"$info[fname]\" required>
                            </div>
                            <div class=\"group-input mn\">
                                <label for=\"mn\">Middle Name</label>
                                <input type=\"text\" name=\"mn\" id=\"mn\" placeholder=\"set\" value=\"$info[mname]\">
                            </div>
                        </div>
                ";
                $userdata .= "
                    <div class=\"left-box\">
                        <div class=\"sex-box\">
                            <h4>Sex</h4>
                            <div class=\"group-input\">
                                <div id=\"hideSex\" style=\"display: none\"></div>
                                <label for=\"uM\">Male</label>
                                <input type=\"radio\" name=\"uSex\" id=\"uM\" value=\"Male\" $male onchange=\"checkedSex(this)\">
                            </div>
                            <div class=\"group-input\">
                                <label for=\"uFM\">Female</label>
                                <input type=\"radio\" name=\"uSex\" id=\"uFM\" value=\"Female\" $female onchange=\"checkedSex(this)\">
                            </div>
                            <div class=\"group-input\">
                                <label for=\"uO\">Other</label>
                                <input type=\"radio\" name=\"uSex\" id=\"uO\" value=\"Other\" $other onchange=\"checkedSex(this)\"> 
                            </div>
                        </div>
                        <div class=\"group-input age\">
                            <label for=\"uAge\">Age</label>
                            <input type=\"number\" name=\"uAge\" id=\"uAge\" min=\"1\" max=\"99\" placeholder=\"set\" value=\"$info[age]\">
                        </div>
                        <div class=\"group-input bday\">
                            <label for=\"uBday\">Birthday</label>
                            <input type=\"date\" name=\"uBday\" id=\"uBday\" data-target-1=\"uAge\" value=\"$info[bday]\" onclick=\"changeAge(this)\">
                        </div>
                        <div class=\"group-input con\">
                            <label for=\"uCon\">Contact Number</label>
                            <input type=\"text\" name=\"uCon\" id=\"uCon\" maxlength=\"11\" placeholder=\"+63\" value=\"$info[contact]\">
                        </div>
                    </div>
                ";
                $userdata .= "
                        <div class=\"address-box\">
                            <h4>Address</h4>
                            <div class=\"for\">
                                <h5>Address for: </h5>
                                <div id=\"hideLoc\" style=\"display: none\"></div>
                                <div class=\"group-input\">
                                    <label for=\"home\">Home</label>
                                    <input type=\"radio\" name=\"place\" id=\"home\" value=\"Home\" $home>
                                </div>
                                <div class=\"group-input\">
                                    <label for=\"office\">Office</label>
                                    <input type=\"radio\" name=\"place\" id=\"office\" value=\"Office\" $office>
                                </div>
                            </div>
                            <div class=\"group-input lot\">
                                <label for=\"houseNo\">Blk/Lot</label>
                                <input type=\"text\" name=\"houseNo\" id=\"uhouseNo\" placeholder=\"set\" value=\"$info[blk]\">
                            </div>
                            <div class=\"group-input str\">
                                <label for=\"street\">Street</label>
                                <input type=\"text\" name=\"street\" id=\"ustreet\" placeholder=\"set\" value=\"$info[street]\">
                            </div>
                            <div class=\"group-input brgy\">
                                <label for=\"brgy\">Baranggay</label>
                                <input type=\"text\" name=\"brgy\" id=\"ubrgy\" placeholder=\"set\" value=\"$info[brgy]\">
                            </div>
                            <div class=\"group-input city\">
                                <label for=\"city\">City</label>
                                <input type=\"text\" name=\"city\" id=\"ucity\" placeholder=\"set\" value=\"$info[city]\">
                            </div>
                            <div class=\"group-input prov\">
                                <label for=\"prov\">Province</label>
                                <input type=\"text\" name=\"prov\" id=\"uprov\" placeholder=\"set\" value=\"$info[province]\">
                            </div>
                            <div class=\"group-input zip\">
                                <label for=\"zip\">ZIP Code</label>
                                <input type=\"number\" name=\"zip\" id=\"zip\" min=\"1111\" max=\"9999\" value=\"$info[zipCode]\">
                            </div>
                            <div class=\"group-input btn\">
                                <div id=\"cancelInput\" onclick=\"cancelInput()\">Cancel</div>
                                <div id=\"confChange\" onclick=\"confirmChanges()\">Confirm Changes</div>
                            </div>
                        </div>
                    </form>
                ";
            }
        }
        return $userdata;
    }

    public function insertData($fn, $ln, $mn, $age, $sex, $bday, $contact, $loc, $blk, $str, $brgy, $city, $prov, $zip) {
        $userid = $_SESSION["userid"];
        $date = date("Y-m-d");
        $sql = "UPDATE userinfo SET fname = '$fn', lname = '$ln', mname = '$mn', sex = '$sex', age = '$age', bday = '$bday', contact = '$contact', addressType = '$loc', blk = '$blk', street = '$str', brgy = '$brgy', city = '$city', province = '$prov', zipCode = '$zip', dateModify = '$date' WHERE UIID = '$userid';";
        $res = $this->inputData($sql);
        return $res;
    }

    public function saveInfo($sex, $age, $bday, $contact) {
        $userid = $_SESSION["userid"];
        $date = date("Y-m-d");
        $sql = "UPDATE userinfo SET sex = '$sex', age = '$age', bday = '$bday', contact = '$contact', dateModify = '$date' WHERE UIID = '$userid';";
        $res = $this->inputData($sql);
        return $res;
    }

    public function getFav() {
        $userid = $_SESSION["userid"];
        $sql = "SELECT prodinfo.* FROM favinfo INNER JOIN prodinfo ON favinfo.PIID = prodinfo.PIID INNER JOIN userinfo ON userinfo.UIID = favinfo.UIID WHERE userinfo.UIID = '$userid' AND favinfo.flag = 1;";
        $fav = $this->getData($sql);
        $userfav = "";
        foreach($fav as $ufav => $favs) {
            $userfav .= "
                <div class=\"fav-card\">
                    <div id=\"fav_$favs[PIID]\" style=\"display: none;\">$favs[PIID]</div>
                    <div class=\"fav-img\" style=\"height: 200px; width: 100%; border-radius: 10px; background: url($favs[prodImage]) no-repeat center; background-size: cover;\">
                        <div class=\"btn\">
                            <button id=\"removetofav\" data-target=\"fav_$favs[PIID]\" onclick=\"eraseFav(this)\"><i class=\"fa-solid fa-heart\"></i><i class=\"fa-regular fa-heart\"></i></button>
                        </div>
                    </div>
                    <div class=\"fav-info\">
                        <p>$favs[name]<em>₱$favs[price]</em></p>
                        <a href=\"index.php#product\"><i class=\"fa-solid fa-basket-shopping\"></i></a>
                    </div>
                </div>
            ";
        }
        return $userfav;
    }

    public function removeprod($thisid) {
        $userid = $_SESSION["userid"];
        $sql = "UPDATE favinfo SET flag = 0 WHERE UIID = '$userid' AND PIID = '$thisid';";
        $res = $this->inputData($sql);
        return $res;
    }

    public function checkPass($pass) {
        $userid = $_SESSION["userid"];
        $sql = "SELECT pass FROM userinfo WHERE UIID = '$userid';";
        $check = $this->getData($sql);
        foreach($check as $ch => $checkPass) {
            if (password_verify($pass, $checkPass['pass'])) {
                $match = "0";
            } else { $match = "1"; }
        }
        return $match;
    }

    public function changePass($uname, $newpass) {
        $userid = $_SESSION["userid"];
        $password = password_hash($newpass, PASSWORD_DEFAULT);
        $sql = "UPDATE userinfo SET username = '$uname', pass = '$password' WHERE UIID = '$userid';";
        $comment = $this->inputData($sql);
        if ($comment == "0" || $comment == 0 || $comment == '0') {
            return "0";
        } else { return "1"; }
    }

    public function changeUsername($uname) {
        $userid = $_SESSION["userid"];
        $sql = "SELECT * FROM userinfo WHERE username = '$uname';";
        $ret = $this->getData($sql);
        $token = 0;
        foreach($ret as $r => $rt) {
            $token++;
        }
        if ($token > 0) {
            return "2";
        } else {
            $sql = "UPDATE userinfo SET username = '$uname' WHERE UIID = '$userid';";
            $comment = $this->inputData($sql);
            if ($comment == "0" || $comment == 0 || $comment == '0') {
                return "0";
            } else { return "1"; }
        }
    }

    public function getUsername() {
        $userid = $_SESSION["userid"];
        $sql = "SELECT username FROM userinfo WHERE UIID = '$userid';";
        $ret = $this->getData($sql);
        foreach($ret as $r => $rt) {
            return $rt["username"];
        }
    }

    public function getCart() {
        $userid = $_SESSION["userid"];
        $sql = "SELECT prodinfo.*, basketinfo.qty as qty, basketinfo.price as total FROM prodinfo INNER JOIN basketinfo ON prodinfo.PIID = basketinfo.PIID WHERE basketinfo.UIID = '$userid';";
        $basket = $this->getData($sql);
        $itemlist = "";
        $token = 0;
        foreach($basket as $c => $cart) {
            $itemlist .= "
                <div class=\"cart-list\">
                    <div id=\"hcID_$token\" style=\"display: none;\">$cart[PIID]</div>
                    <div id=\"price_$token\" style=\"display: none;\">$cart[price]</div>
                    <div class=\"cart-img\" style=\"height: 100%; width: 30%; background: url($cart[prodImage]) no-repeat center; background-size: cover; border-radius: 5px;\"></div>
                    <div class=\"cart-info\">
                        <div class=\"opt\">
                            <input type=\"checkbox\" class=\"checkBox\" data-target=\"hcID_$token\" data-target-1=\"label_$token\" data-target-2=\"$cart[prodImage]\" data-target-3=\"title_$token\" data-target-4=\"selectQty_$token\" data-target-5=\"itemPrice_$token\" data-target-6=\"price_$token\" name=\"select-item\" onchange=\"selectItem(this)\" id=\"selectItem_$token\">
                            <label for=\"selectItem_$token\" id=\"label_$token\" class=\"chLabel\"><i class=\"fa-solid fa-check\"></i></label>
                            <div id=\"removeItem\" data-target=\"hcID_$token\" onclick=\"removeItem(this)\">Remove</div>
                        </div>
                        <p class=\"prod-title\" id=\"title_$token\">$cart[name]</p>
                        <div class=\"tag\">
                            <p class=\"qty\" style=\"font-size: 0.9rem; font-weight: 450;\">Quantity: <strong><input type=\"number\" min=\"1\" max=\"99\" name=\"qty\" id=\"selectQty_$token\" data-target=\"itemPrice_$token\" data-target-1=\"price_$token\" onclick=\"addQuantity(this)\" value=\"$cart[qty]\"></strong></p>
                            <p class=\"item-price\" style=\"font-weight: 450;\">Price: <strong style=\"font-size: 1rem; font-weight: bold;\">₱$cart[total]</strong></p>
                            <div id=\"itemPrice_$token\" style=\"display: none;\">$cart[total]</div>
                        </div>
                    </div>
                </div>
            ";
            $token++;
        }
        return $itemlist;
    }

    public function remCart($id) {
        $userid = $_SESSION["userid"];
        $sql = "DELETE FROM basketinfo WHERE PIID = '$id' AND UIID = '$userid';";
        $this->inputData($sql);
    }

    public function showInfo() {
        $userid = $_SESSION["userid"];
        $sql = "SELECT * FROM userinfo WHERE UIID = '$userid';";
        $info = $this->getData($sql);
        $userinfo = "";
        foreach($info as $i => $infos) {
            $userinfo .= "
                <div class=\"group-info\">
                    <label for=\"userName\">Full Name</label>
                    <input type=\"text\" name=\"username\" disabled id=\"userName\" value=\"$infos[fname]"." $infos[mname]"." $infos[lname]\">
                </div>
                <div class=\"group-info\">
                    <label for=\"number\">Contact Number</label>
                    <input type=\"text\" name=\"number\" disabled id=\"number\" value=\"$infos[contact]\">
                </div>
                <div class=\"address-box\">
                    <h5>Address</h5>
                    <button id=\"changeAddBtn\"><i class=\"fa-solid fa-pen-to-square\"></i>Change Address</button>
                    <div class=\"group-info\" style=\"width: 20%;\">
                        <label for=\"blkLot\">Blk/Lot</label>
                        <input type=\"text\" name=\"blklot\" disabled id=\"blkLot\" value=\"$infos[blk]\">
                    </div>
                        <div class=\"group-info\" style=\"width: 74%;\">
                        <label for=\"street\">Street</label>
                        <input type=\"text\" name=\"street\" disabled id=\"street\" value=\"$infos[street]\">
                    </div>
                    <div class=\"group-info\">
                        <label for=\"brgy\">Baranggay</label>
                        <input type=\"text\" name=\"brgy\" disabled id=\"brgy\" value=\"$infos[brgy]\">
                    </div>
                    <div class=\"group-info\">
                        <label for=\"city\">Municipality</label>
                        <input type=\"text\" name=\"city\" disabled id=\"city\" value=\"$infos[city]\">
                    </div>
                    <div class=\"group-info\" style=\"width: 74%\">
                        <label for=\"province\">Province</label>
                        <input type=\"text\" name=\"province\" disabled id=\"province\" value=\"$infos[province]\">
                    </div>
                    <div class=\"group-info\" style=\"width: 20%\">
                        <label for=\"zipCode\">Zip Code</label>
                        <input type=\"text\" name=\"zipcode\" disabled id=\"zipCode\" value=\"$infos[zipCode]\">
                    </div>
            </div>
            ";
        }
        return $userinfo;
    }

    public function passOrder($cid, $cqty, $ctotal) {
        include("connect.php");
        $dateToday = date("Y-m-d H:i");
        $dates = date("Y-m-d");
        $userid = $_SESSION["userid"];
        $total = $_SESSION["totalAmount"];
        
        $tag = "";
        if (isset($_SESSION["count"]) || $_SESSION["count"] == 1) {
            $tag = date("Y") . date("m") . date("d") . $userid . $_SESSION["tagNumber"];
        } else {
            $sqlcount = "SELECT * FROM orderinfo WHERE dateOrdered LIKE '%$dates%';";
            $count = $connect->query($sqlcount);
            if ($count) {
                if ($count->num_rows > 0) {
                    $tag = date("Y") . date("m") . date("d") . $userid . $count->num_rows;
                    $_SESSION["tagNumber"] = $count->num_rows;
                } else {
                    $tag = date("Y") . date("m") . date("d") . $userid . "1";
                    $_SESSION["tagNumber"] = "1";
                }
            }
            $_SESSION["count"] = 1;
        }
        $_SESSION["ordertag"] = $tag;
        $sql = "INSERT INTO orderinfo(UIID, PIID, qty, subtotal, total, dateOrdered, ordertag, status) VALUES('$userid', '$cid', '$cqty', '$ctotal', '$total', '$dateToday', '$tag', 'Verifying Order')";
        $this->inputData($sql);
        $this->remCart($cid);
    }

    public function orderDetails() {
        $_SESSION["count"] = null;
        $userid = $_SESSION["userid"];
        $oTag = "";
        $allInfo = "";
        $orderdata = "";
        $sql = "SELECT orderinfo.*, userinfo.* FROM orderinfo INNER JOIN userinfo ON orderinfo.UIID = userinfo.UIID WHERE orderinfo.UIID = '$userid' AND orderinfo.status != 'Cancelled Order' AND orderinfo.status != 'Delivered';";
        $sqlResult = $this->getData($sql);
        foreach($sqlResult as $res => $sqlres) {
            if ($sqlres["ordertag"] !== $oTag) {
                $orderdata = "
                    <div class=\"order-card-card\">
                        <div class=\"order-status\">
                            <div class=\"status-tag\">
                                <p>$sqlres[status]</p>
                            </div>
                            <div class=\"order-code\">
                                <p>Transaction No. <strong>$sqlres[ordertag]</strong></p>
                            </div>
                        </div>
                        <div class=\"order-display\">
                            <div class=\"order-container\">
                                <div class=\"order-list\">
                ";
                $sql = "SELECT prodinfo.prodImage as image, prodinfo.name as name, orderinfo.* FROM orderinfo INNER JOIN prodinfo ON orderinfo.PIID = prodinfo.PIID WHERE orderinfo.UIID = '$userid' AND orderinfo.ordertag = '$sqlres[ordertag]';";
                $output = $this->getData($sql);
                foreach($output as $out => $getRes) {
                    $orderdata .= "
                        <div class=\"order-card\">
                            <div class=\"left-card\">
                                <div class=\"order-img\" style=\"height: 100%; width: 100%; border-radius: 5px; background: url($getRes[image]) no-repeat center; background-size: cover;\"></div>
                            </div>
                            <div class=\"right-card\">
                                <p>$getRes[name]</p>
                                <div class=\"price\">
                                    <p>Quantity: <strong>$getRes[qty]</strong></p>
                                    <p>Price: <strong>$getRes[subtotal]</strong></p>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $orderdata .= "
                                </div>
                            </div>
                            <div class=\"total\">
                                <div class=\"user-credentials\">
                ";
                $sqlcount = "SELECT COUNT(TRID) as count FROM orderinfo WHERE ordertag = '$sqlres[ordertag]';";
                $getcount = $this->getData($sqlcount);
                foreach($getcount as $gc => $getc) {
                    $number = $getc["count"];
                }
                $orderdata .= "
                                    <div class=\"info-holder\">
                                        <p class=\"label\" style=\"font-size: .9rem;\">Name: </p>
                                        <p><strong style=\"font-size: .9rem; padding-left: 1rem;\">$sqlres[fname]"." $sqlres[lname]</strong></p>
                                    </div>
                                    <div class=\"info-holder\">
                                        <p class=\"label\" style=\"font-size: .9rem;\">Contact Number: </p>
                                        <p><strong style=\"font-size: .9rem; padding-left: 1rem;\">$sqlres[contact]</strong></p>
                                    </div>
                                    <div class=\"info-holder\">
                                        <p class=\"label\" style=\"font-size: .9rem;\">Address: </p>
                                        <p style=\"font-size: .9rem; padding-left: 1rem;\"><strong>$sqlres[blk]"." $sqlres[street]"." $sqlres[brgy]"." $sqlres[city]"." $sqlres[province]"." $sqlres[zipCode]</strong></p>
                                    </div>
                                    <div class=\"order-code\">
                                        <p style=\"font-size: .7rem; font-weight: bold; color: #333333;\">NO. OF ITEMS: $number</p>
                                        <p><strong style=\"font-size: 1rem; color: var(--sec-color);\">TOTAL: ₱$sqlres[total]</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
                $allInfo .= $orderdata;
                $oTag = $sqlres["ordertag"]; 
            }
        }
        return $allInfo;
    }

    public function showTransac() {
        $userid = $_SESSION["userid"];
        $sql = "SELECT orderinfo.*, userinfo.*, prodinfo.* FROM orderinfo INNER JOIN userinfo ON orderinfo.UIID = userinfo.UIID INNER JOIN prodinfo ON prodinfo.PIID = orderinfo.PIID WHERE orderinfo.UIID = '$userid' AND orderinfo.status = 'Delivered' AND orderinfo.dateDelivered IS NOT NULL;";
        $transac = $this->getData($sql);
        $getTrans = "";
        $infolist = "";
        $oTag = "";
        $token = 0;
        foreach($transac as $t => $trans) {
            if ($trans["ordertag"] !== $oTag) {
                $oTag = $trans["ordertag"];
                $getTrans = "
                    <div class=\"date-card\" id=\"dateCard_$token\" style=\"height: 50px;\">
                        <div class=\"minimize-card\">
                            <button class=\"resizeBtn\" data-target=\"dateCard_$token\" onclick=\"max(this)\">
                                <i class=\"max-icon fa-solid fa-up-right-and-down-left-from-center\"></i>
                                <i class=\"min-icon fa-solid fa-down-left-and-up-right-to-center\"></i>
                            </button>
                            <p class=\"labels\">Date Delivered: <strong>$trans[dateDelivered]</strong></p>
                            <p class=\"labels\">Transaction No: <strong>$trans[ordertag]</strong></p>
                        </div>
                        <div class=\"date-order\">
                            <div class=\"item-view\">
                                <h5>Purchased Items</h5>
                ";

                $countSql = "SELECT COUNT(TRID) as count FROM orderinfo WHERE UIID = '$userid' AND ordertag = '$trans[ordertag]';";
                $count = $this->getData($countSql);
                foreach ($count as $co => $prod) {
                    $getTrans .= "  <p>No. of Items: <strong>$prod[count]</strong></p> ";
                }

                $getTrans .= "  <p>Total Amount: <strong>₱$trans[total]</strong></p>
                                <div class=\"item-holder\">
                ";

                $prodSql = "SELECT prodinfo.*, orderinfo.* FROM orderinfo INNER JOIN prodinfo ON orderinfo.PIID = prodinfo.PIID WHERE orderinfo.UIID = '$userid' AND orderinfo.ordertag = '$trans[ordertag]';";
                $prodinfo = $this->getData($prodSql);
                foreach($prodinfo as $p => $pInfo) {
                    $getTrans .= "      <div class=\"item-info\">
                                            <p>$pInfo[name]</p>
                                            <p>Quantity: $pInfo[qty]</p>
                                            <p>Price: ₱$pInfo[price]</p>
                                            <p>Subtotal: ₱$pInfo[subtotal]</p>
                                        </div>
                            ";
                }

                $getTrans .= "  </div>
                            </div>
                            <div class=\"receiver-info\">
                                <h5>Recipient's Information</h5>
                                <p><strong>Recipient's Name: </strong> $trans[lname], "."$trans[fname] "."$trans[mname]</p>
                                <p><strong>Contact Number:</strong> +63 $trans[contact]</p>
                                <p><strong>Address:</strong></p> 
                                <p><strong>$trans[addressType]</strong> | "."$trans[blk] "."$trans[street], "."$trans[brgy], "."$trans[city], "."$trans[province], "."$trans[zipCode]</p>
                                <p><strong>Date Ordered:</strong> $trans[dateOrdered]</p>
                            </div>
                        </div>
                    </div>
                ";
                $token++;
                $infolist .= $getTrans;
            }
        }
        return $infolist;
    }

    public function deleteAcc() {
        $userid = $_SESSION["userid"];
        $date = date("Y-m-d");
        $sql = "UPDATE userinfo SET dateRemoved='$date', flag=1 WHERE UIID='$userid';";
        $del = $this->inputData($sql);
        if ($del) { return 0; }
        else { return 1; }
    }
}

?>