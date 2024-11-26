<?php
include("connect.php");
session_start();

if (isset($_POST['addprod'])) {

    $PNAME = $_POST['prodname'];
    $PTYPE = $_POST['prodtype'];
    $PPRICE = $_POST['prodprice'];
    $PDESC = $_POST['proddesc'];
    $PIMG = $_FILES['img']['name'];
    $TMPNAME = $_FILES['img']['tmp_name'];
    $LOC = 'product/'.$PIMG;

    $ifUnique = "SELECT * FROM prodinfo WHERE name = '$PNAME';";
    $res = $connect->query($ifUnique);
    if ($res->num_rows > 0) {
        echo "<script> alert('This Product already exists'); </script>";
    } else {
        $addProduct = "INSERT INTO prodinfo(name, type, price, detail, prodImage)
        VALUES('$PNAME', '$PTYPE', '$PPRICE', '$PDESC', '$LOC');";

        if (move_uploaded_file($TMPNAME, $LOC)) {
            if ($connect->query($addProduct) == TRUE) {
                echo "<script> alert('Product is successfully added.'); </script>";
            } else {
                echo "Error: ".$connect->error;
            }
        } else {
            echo "<script> alert('Unsuccessful image upload.'); </script>";
        }
    }
    header("location: adminpage.php");
}

class Product {
    private function getData($sqlQ) {
        include("connect.php");
        $result = $connect ->query($sqlQ);
		if(!$result) {
            die("Invalid Query: " . $connect->error);
        }
		$data= array();
        while ($row = $result->fetch_assoc()) {
			$data[]=$row;            
		}
		return $data;
    }

    public function getProducts($passReq) {
        $select = "";
        $sql = "SELECT * FROM prodinfo;";

        if(isset($passReq)){
            $select = $passReq;
            switch($select) {
                case "option-1":
                    $sql = "SELECT * FROM prodinfo;";
                    break;
                case "option-2":
                    $sql = "SELECT * FROM prodinfo WHERE type LIKE 'Donut';";
                    break;
                case "option-3":
                    $sql = "SELECT * FROM prodinfo WHERE type LIKE 'Pastry';";
                    break;
                default:
                    $sql = "SELECT * FROM prodinfo WHERE type LIKE 'Beverage';";
                    break;
            }
        }
            $product = $this->getData($sql);
            $productInnerHtml = "";
            foreach($product as $key => $prod) {
                $productInnerHtml .= "<div class=\"prod-img\" style=\"background: url($prod[prodImage]) no-repeat center; background-size: cover;\"></div>";
                $productInnerHtml .= "<div class=\"prod-info\">";
                $productInnerHtml .= "<div class=\"prod-name\">";
                $productInnerHtml .= "<input type=\"hidden\" class=\"getFav\" name=\"getFav\" value=\"0\">";
                $productInnerHtml .= "<input type=\"hidden\" name=\"getID\" value=\"$prod[PIID]\">";
                $productInnerHtml .= "<input type=\"hidden\" name=\"getDesc\" value=\"$prod[detail]\">";
                $productInnerHtml .= "<p><strong style=\"font-size: 1rem;\">$prod[name]</strong></p>";
                $productInnerHtml .= "<p class=\"prod-price\">₱$prod[price]</p>";
                $productInnerHtml .= "</div>";
                $productInnerHtml .= "</div>";
            }
        return $productInnerHtml;
    }

    public function getUserProducts($passCat) {
        $userid = $_SESSION["userid"];
        $select = "";
        $sql = "SELECT prodinfo.*, favinfo.flag FROM prodinfo INNER JOIN favinfo ON prodinfo.PIID = favinfo.PIID INNER JOIN userinfo ON favinfo.UIID = userinfo.UIID WHERE userinfo.UIID = '$userid' ORDER BY favinfo.flag DESC, prodinfo.PIID ASC;";

        if(isset($passCat)){
            $select = $passCat;
            switch($select) {
                case "option-1":
                    $sql = "SELECT prodinfo.*, favinfo.flag FROM prodinfo INNER JOIN favinfo ON prodinfo.PIID = favinfo.PIID INNER JOIN userinfo ON favinfo.UIID = userinfo.UIID WHERE userinfo.UIID = '$userid' ORDER BY favinfo.flag DESC, prodinfo.PIID ASC;";
                    break;
                case "option-2":
                    $sql = "SELECT prodinfo.*, favinfo.flag FROM prodinfo INNER JOIN favinfo ON prodinfo.PIID = favinfo.PIID INNER JOIN userinfo ON favinfo.UIID = userinfo.UIID WHERE userinfo.UIID = '$userid' AND prodinfo.type LIKE 'Donut' ORDER BY favinfo.flag DESC, prodinfo.PIID ASC;";
                    break;
                case "option-3":
                    $sql = "SELECT prodinfo.*, favinfo.flag FROM prodinfo INNER JOIN favinfo ON prodinfo.PIID = favinfo.PIID INNER JOIN userinfo ON favinfo.UIID = userinfo.UIID WHERE userinfo.UIID = '$userid' AND prodinfo.type LIKE 'Pastry' ORDER BY favinfo.flag DESC, prodinfo.PIID ASC;";
                    break;
                default:
                    $sql = "SELECT prodinfo.*, favinfo.flag FROM prodinfo INNER JOIN favinfo ON prodinfo.PIID = favinfo.PIID INNER JOIN userinfo ON favinfo.UIID = userinfo.UIID WHERE userinfo.UIID = '$userid' AND prodinfo.type LIKE 'Beverage' ORDER BY favinfo.flag DESC, prodinfo.PIID ASC;";
                    break;
            }
        }
            $product = $this->getData($sql);
            $productInnerHtml = "";
            $flag = 0;
            $token = 0;
            foreach($product as $key => $prod) {
                if (intval($prod["flag"]) == 1) {
                    $flag = 1;
                } else { $flag = 0; }

                $productInnerHtml .= "<div class=\"prod-img\" style=\"background: url($prod[prodImage]) no-repeat center; background-size: cover;\"></div>";
                $productInnerHtml .= "<div class=\"prod-info\">";
                $productInnerHtml .= "<div class=\"prod-name\">";
                $productInnerHtml .= "<input type=\"hidden\" class=\"getFav\" data-target=\"fav_$token\" data-target-1=\"notFav_$token\" name=\"getFav\" value=\"$flag\">";
                $productInnerHtml .= "<input type=\"hidden\" name=\"getID\" value=\"$prod[PIID]\">";
                $productInnerHtml .= "<input type=\"hidden\" name=\"getDesc\" value=\"$prod[detail]\">";
                $productInnerHtml .= "<p><strong style=\"font-size: 1rem;\">$prod[name]</strong></p>";
                $productInnerHtml .= "<p class=\"prod-price\">₱$prod[price]</p>";
                $productInnerHtml .= "</div>";
                $productInnerHtml .= "</div>";
                $token++;
            }
        return $productInnerHtml;
    }

    public function searchWord($word) {
        if (isset($_SESSION["userid"])) {
            $userid = $_SESSION["userid"];
            $sql = "SELECT prodinfo.*, favinfo.flag FROM prodinfo INNER JOIN favinfo ON prodinfo.PIID = favinfo.PIID INNER JOIN userinfo ON favinfo.UIID = userinfo.UIID WHERE userinfo.UIID = '$userid' AND prodinfo.name LIKE '%$word%' ORDER BY favinfo.flag DESC, prodinfo.PIID ASC;";
            $product = $this->getData($sql);
            $productInnerHtml = "";
            $flag = 0;
            $token = 0;
            foreach($product as $key => $prod) {
                if (intval($prod["flag"]) == 1) {
                    $flag = 1;
                } else { $flag = 0; }

                $productInnerHtml .= "<div class=\"prod-img\" style=\"background: url($prod[prodImage]) no-repeat center; background-size: cover;\"></div>";
                $productInnerHtml .= "<div class=\"prod-info\">";
                $productInnerHtml .= "<div class=\"prod-name\">";
                $productInnerHtml .= "<input type=\"hidden\" class=\"getFav\" data-target=\"fav_$token\" data-target-1=\"notFav_$token\" name=\"getFav\" value=\"$flag\">";
                $productInnerHtml .= "<input type=\"hidden\" name=\"getID\" value=\"$prod[PIID]\">";
                $productInnerHtml .= "<input type=\"hidden\" name=\"getDesc\" value=\"$prod[detail]\">";
                $productInnerHtml .= "<p><strong style=\"font-size: 1rem;\">$prod[name]</strong></p>";
                $productInnerHtml .= "<p class=\"prod-price\">₱$prod[price]</p>";
                $productInnerHtml .= "</div>";
                $productInnerHtml .= "</div>";
                $token++;
            }
        } else {
            $sql = "SELECT * FROM prodinfo WHERE name LIKE '%$word%';";
            $product = $this->getData($sql);
            $productInnerHtml = "";
            foreach($product as $key => $prod) {
                $productInnerHtml .= "<div class=\"prod-img\" style=\"background: url($prod[prodImage]) no-repeat center; background-size: cover;\"></div>";
                $productInnerHtml .= "<div class=\"prod-info\">";
                $productInnerHtml .= "<div class=\"prod-name\">";
                $productInnerHtml .= "<input type=\"hidden\" class=\"getFav\" name=\"getFav\" value=\"0\">";
                $productInnerHtml .= "<input type=\"hidden\" name=\"getID\" value=\"$prod[PIID]\">";
                $productInnerHtml .= "<input type=\"hidden\" name=\"getDesc\" value=\"$prod[detail]\">";
                $productInnerHtml .= "<p><strong style=\"font-size: 1rem;\">$prod[name]</strong></p>";
                $productInnerHtml .= "<p class=\"prod-price\">₱$prod[price]</p>";
                $productInnerHtml .= "</div>";
                $productInnerHtml .= "</div>";
            }
        }
        return $productInnerHtml;
    }

    public function getTotal($qty, $price) {
        $total = 0;
        if ($qty !== "1") {
            $total = $qty * $price;
        } else {
            $total = 1 * $price;
        }
        $total .= ".00";
        return $total;
    }

    public function addFav($fav) {
        include("connect.php");
        if (isset($fav) && isset($_SESSION["userid"])) {
            $favProd = $fav;
            $userid = $_SESSION["userid"];
            $tag = 1;

            $sql = "SELECT * FROM favinfo WHERE UIID = '$userid' AND PIID = '$favProd';";
            $output = $this->getData($sql);
            if(count($output) == 0) {
                $add = "INSERT INTO favinfo(UIID, PIID, flag) VALUES('$userid', '$favProd', '$tag');";
                if ($connect->query($add)) {
                    $comment = "Successfully Added to Favorites";
                } else {
                    $comment = "Error: " . $connect->connect_error;
                }
            } else { 
                foreach($output as $prod => $out) {
                    $add = "UPDATE favinfo SET flag = 1 WHERE FIID = '$out[FIID]';";
                    if ($connect->query($add)) {
                        $comment = "Successfully Added to Favorites";
                    } else {
                        $comment = "Error: " . $connect->connect_error;
                    }
                }
            }
        }
        return $comment;
    }

    public function remFav($removeFav) {
        include("connect.php");
        if (isset($removeFav) && isset($_SESSION["userid"])) {
            $remProd = $removeFav;
            $userid = $_SESSION["userid"];

            $sql = "SELECT * FROM favinfo WHERE UIID = '$userid' AND PIID = '$remProd';";
            $output = $this->getData($sql);
            if(count($output) > 0) {
                foreach($output as $prod => $out) {
                    $add = "UPDATE favinfo SET flag = 0 WHERE FIID = '$out[FIID]';";
                    if($connect->query($add)) {
                        $comment = "This product has been removed from Favorites";
                    } else {
                        $comment = "Error: " . $connect->connect_error;
                    }
                }
            } else {
                $comment = "This product is not yet added to Favorites.";
            }
        }
        return $comment;
    }

    public function addToCart($id, $qty, $price) {
        include("connect.php");
        $userid = $_SESSION["userid"];
        $cID = $id;
        $cQTY = $qty;
        $cPRICE = $price;

        $cTOTAL = $this->getTotal($cQTY, $cPRICE);
        $sql = "SELECT * FROM basketinfo WHERE UIID = '$userid' AND PIID = '$cID';";
        $getResult = $this->getData($sql);
        if (count($getResult) > 0) {
            $sql = "UPDATE basketinfo SET qty = '$cQTY', price = '$cTOTAL' WHERE UIID = '$userid' AND PIID = '$cID';";
            if ($connect->query($sql)) {
                $comment = "Successfully added to Basket.";
            } else {
                $comment = "Error: " . $connect->connect_error;
            }
        } else {
            $input = "INSERT INTO basketinfo(UIID, PIID, qty, price) VALUES('$userid', '$cID', '$cQTY', '$cTOTAL');";
            if ($connect->query($input)) {
                $comment = "Successfully added to Basket.";
            } else {
                $comment = "Error: " . $connect->connect_error;
            }
        }
        return $comment;
    }
}
?>