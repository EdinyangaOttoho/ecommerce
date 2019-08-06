<?php
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Credentials:true');
?>
<?php
	include 'requests.php';
    class SignIn {
    	public $email = '';
        public $pass = '';
        public function __construct($em,$pass) {
            $this->email = $em;
            $this->pass = $pass;
            $host = 'localhost';
            $user = 'naijafo7_root';
            $dbpassword = 'danielpatrick';
            $database = 'naijafo7_dstore';
            $db = mysqli_connect($host,$user,$dbpassword,$database);
            $password = hexdec(stripslashes(htmlspecialchars(trim(mysqli_real_escape_string($db,$this->pass)))));
            $emailaddress = stripslashes(htmlspecialchars(trim(mysqli_real_escape_string($db,$this->email))));
            $query = "SELECT * FROM customer WHERE email = '$emailaddress' AND password = '$password'";
            $q = mysqli_query($db,$query);
            if (mysqli_num_rows($q) == 0) {
                echo 'error';
            }
            else {
                @session_start();
                $_SESSION['account_email'] = $emailaddress;
                while ($rr = mysqli_fetch_array($q)) {
                    $_SESSION['user_name'] = $rr['name'];
                }
            }
        }
    }
    class SignUp {
    	public $email = '';
		public $password = 'danielpatrick';
		public $firstname = '';
		public $lastname = '';
		public function __construct($em,$pass,$firstname,$lastname) {
			$this->email = $em;
    		$this->password = $pass;
    		$this->firstname = $firstname;
    		$this->lastname = $lastname;
    		$host = 'localhost';
			$user = 'naijafo7_root';
			$dbpassword = 'danielpatrick';
			$database = 'naijafo7_dstore';
			$db = mysqli_connect($host,$user,$dbpassword,$database);
    		$password = hexdec(stripslashes(htmlspecialchars(trim(mysqli_real_escape_string($db,$this->password)))));
    		$emailaddress = stripslashes(htmlspecialchars(trim(mysqli_real_escape_string($db,$this->email))));
    		$firstname = stripslashes(htmlspecialchars(trim(mysqli_real_escape_string($db,$this->firstname))));
    		$lastname = stripslashes(htmlspecialchars(trim(mysqli_real_escape_string($db,$this->lastname))));
    		$name = $firstname." ".$lastname;
    		$query = "SELECT * FROM customer WHERE email = '$emailaddress'";
    		$q = mysqli_query($db,$query);
            $cnt = mysqli_num_rows($q) + 1 + mt_rand(0,65535);
    	    if (mysqli_num_rows($q) >= 1) {
    	    	echo 'error';
    	    }
     	    else {
                mysqli_query($db,"INSERT INTO customer (name,email,password,credit_card,address_1,address_2,city,region,postal_code,country,shipping_region_id,day_phone,eve_phone,mob_phone) VALUES ('$name','$emailaddress','$password','','','','','','','','$cnt','','','')");
                @session_start();
                $_SESSION['account_email'] = $emailaddress;
                $_SESSION['user_name'] = $name;
    	    }
    	}
    }
    class FetchSales {
        public $off = '';
        public function __construct($off,$cat,$dep) {
            $this->off =$off;
            $this->cat = $cat;
            $this->dep = $dep;
            if ($this->dep != 'default' && $this->cat == 'default') {
                $host = 'localhost';
                $user = 'naijafo7_root';
                $dbpassword = 'danielpatrick';
                $database = 'naijafo7_dstore';    
                $db = mysqli_connect($host,$user,$dbpassword,$database);
                $q = mysqli_query($db,"SELECT *  FROM category WHERE department_id = '$this->dep'");
                while ($r = mysqli_fetch_array($q)) {
                    $pid = $r['category_id'];
                    $qs = mysqli_query($db, "SELECT * FROM product_category WHERE category_id = '$pid'");
                    $cid = '';
                    while ($rq = mysqli_fetch_array($qs)) {
                        $cid = $rq['product_id'];
                        $qq = mysqli_query($db,"SELECT * FROM product WHERE product_id = '$cid'");
                        while ($rr = mysqli_fetch_array($qq)) {
                            $img = $rr['image'];
                            ?>
                            <div class="product-tile">
                                <img src="<?php echo $img; ?>" class="fill">
                                <br/>
                                <br/>
                                <center>
                                    <label class="name"><?php echo $rr['name']; ?></label>
                                    <br/>
                                    <br/>
                                    <?php
                                        if ($rr['discounted_price'] == '0.00') {?>
                                            <label style="font-family:'GothamRounded';color:hotpink">FREE</label>
                                            <br/>
                                            <br/>
                                        <?php
                                        }
                                        else { ?>
                                             <label class="price">$<?php echo $rr['discounted_price']; ?></label>
                                             <br/>
                                             <strike><label class="price"><?php echo $rr['price']; ?></label></strike>
                                             <br/>
                                             <br/>
                                        <?php
                                        }
                                        @session_start();
                                        if (isset($_SESSION['account_email'])) { ?>
                                            <center><button class="buy-now" id="<?php echo $rq['product_id']; ?>" onclick="buynow(this.id)">Buy Now</button></center>
                                            <p align="right">
                                                <label class="little cart" id="<?php echo $rq['product_id']; ?>" onclick="addcart(this.id)"><i class="fas fa-shopping-cart"></i> Add to Cart</label>
                                            </p>
                                        <?php
                                        }
                                    ?>
                                </center>
                                </center>
                            </div>
                    <?php
                            }
                    }
                } 
            }
            elseif ($this->cat != 'default' && $this->dep == 'default') {
                $host = 'localhost';
                $user = 'naijafo7_root';
                $dbpassword = 'danielpatrick';
                $database = 'naijafo7_dstore';    
                $db = mysqli_connect($host,$user,$dbpassword,$database);
                $qs = mysqli_query($db, "SELECT * FROM product_category WHERE category_id = '$this->cat' ORDER BY category_id");
                    while ($rq = mysqli_fetch_array($qs)) {
                        $cid = $rq['product_id'];
                        $qq = mysqli_query($db,"SELECT * FROM product WHERE product_id = '$cid'");
                        while ($rr = mysqli_fetch_array($qq)) {
                            $img = $rr['image'];
                            ?>
                            <div class="product-tile">
                                <img src="<?php echo $img; ?>" class="fill">
                                <br/>
                                <br/>
                                <center>
                                    <label class="name"><?php echo $rr['name']; ?></label>
                                    <br/>
                                    <br/>
                                    <?php
                                        if ($rr['discounted_price'] == '0.00') {?>
                                            <label style="font-family:'GothamRounded';color:hotpink">FREE</label>
                                            <br/>
                                            <br/>
                                        <?php
                                        }
                                        else { ?>
                                             <label class="price">$<?php echo $rr['discounted_price']; ?></label>
                                             <br/>
                                             <strike><label class="price"><?php echo $rr['price']; ?></label></strike>
                                             <br/>
                                             <br/>
                                        <?php
                                        }
                                        @session_start();
                                        if (isset($_SESSION['account_email'])) { ?>
                                            <center><button class="buy-now" id="<?php echo $rq['product_id']; ?>" onclick="buynow(this.id)">Buy Now</button></center>
                                            <p align="right">
                                                <label class="little cart" id="<?php echo $rq['product_id']; ?>" onclick="addcart(this.id)"><i class="fas fa-shopping-cart"></i> Add to Cart</label>
                                            </p>
                                        <?php
                                        }
                                    ?>
                                </center>
                                </center>
                            </div>
                    <?php
                            }
                    }
            }
            else {
                $host = 'localhost';
                $user = 'naijafo7_root';
                $dbpassword = 'danielpatrick';
                $database = 'naijafo7_dstore';
                $db = mysqli_connect($host,$user,$dbpassword,$database);
                $q = mysqli_query($db,"SELECT * FROM product ORDER BY product_id DESC LIMIT $this->off,9");
                while ($r = mysqli_fetch_array($q)) {
                    $img = $r['image'];
                ?>
                <div class="product-tile">
                    <img src="<?php echo $img; ?>" class="fill">
                    <br/>
                    <br/>
                    <center>
                        <label class="name"><?php echo $r['name']; ?></label>
                        <br/>
                        <br/>
                        <?php
                            if ($r['discounted_price'] == '0.00') {?>
                                <label style="font-family:'GothamRounded';color:hotpink">FREE</label>
                                <br/>
                                <br/>
                            <?php
                            }
                            else { ?>
                                 <label class="price">$<?php echo $r['discounted_price']; ?></label>
                                 <br/>
                                 <strike><label class="price"><?php echo $r['price']; ?></label></strike>
                                 <br/>
                                 <br/>
                            <?php
                            }
                            @session_start();
                            if (isset($_SESSION['account_email'])) { ?>
                                <center><button class="buy-now" id="<?php echo $r['product_id']; ?>" onclick="buynow(this.id)">Buy Now</button></center>
                                <p align="right">
                                    <label class="little cart" id="<?php echo $r['product_id']; ?>" onclick="addcart(this.id)"><i class="fas fa-shopping-cart"></i> Add to Cart</label>
                                </p>
                            <?php
                            }
                        ?>
                    </center>
                    </center>
                </div>
                <?php
                }
            }
        }
    }
    class AddToCart {
        public $id = '';
        public function __construct($id) {
            $this->id = $id;
            $id =$this->id;
            $host = 'localhost';
            $user = 'naijafo7_root';
            $password = 'danielpatrick';
            $database = 'naijafo7_dstore';
            $id = $this->id;
            $db = mysqli_connect($host,$user,$password,$database);
            @session_start();
            $em = $_SESSION['account_email'];
            $y = date('Y');
            $m = date('M');
            $d = date('d');
            $h = date('h');
            $m = date('i');
            $s = date('s');
            $a = date('A');
            $dt = $d.', '.$m.', '.$y. '  '.$h.':'.$m.':'.$s.' '.$a. ' WAT';
            $qq = mysqli_query($db,"SELECT * FROM shopping_cart WHERE product_id = '$id' AND cart_id = '$em' ORDER BY product_id");
            if (mysqli_num_rows($qq) >= 1) {
                echo 'error';
            }
            else {
                $q = mysqli_query($db,"INSERT INTO shopping_cart (cart_id,product_id,attributes,added_on) VALUES ('$em','$id','0','$dt')");
                $qr = mysqli_query($db,"SELECT * FROM shopping_cart WHERE cart_id = '$em'");
                $cnt = mysqli_num_rows($qr);?>
                <script>
                    var cartnum = <?php echo $cnt; ?>;
                </script>
                <?php
                if ($cnt >= 0) { ?>
                <?php
                }
                while ($r = mysqli_fetch_array($qr)) { ?>
                    <div class="cart-text">
                        <table style="width:100%">
                            <tr>
                                <td style="width:70%">
                                    <?php 
                                        $id = $r['product_id'];
                                        $q2 = mysqli_query($db, "SELECT * FROM product WHERE product_id = '$id'");
                                        $name = '';
                                        $price = '';
                                        while ($r2 = mysqli_fetch_array($q2)) {
                                            $name = $r2['name'];
                                            $price = $r2['discounted_price'];
                                        }?>
                                        <center style="text-align:left;font-family:'GothamRounded'"><?php echo $name; ?></center>
                                    <?php
                                    ?>
                                </td>
                                <td>
                                    <center style="font-family:'Roboto'" class="tag"><?php
                                                    if ($price == '0.00') {
                                                        echo 'FREE';
                                                    }
                                                    else {
                                                        echo '$'.$price;    
                                                    }
                                                     ?></center>
                                    </td>
                                        <td style="width:14px">
                                            <button class="close ids" onclick="remelem(this.id)" id="<?php echo $id; ?>">&times;</button>
                                    </td>
                            </tr>
                        </table>
                    </div>
                <?php
                }
                $cn = mysqli_num_rows($qr);
                if ($cn == 0) {
                    echo '<center style="font-family:\'GothamRounded\'">Nothing to display here</center>||||0';
                }
                else {
                    echo '<br/>
                <br/>
                        <center><button class="buy-now" onclick="checkbuy()">View Details</button></center>||||'.mysqli_num_rows($qr);
                }
            }
       }
    }
     class RemoveFromCart {
        public $id = '';
        public function __construct($id) {
            $this->id = $id;
            $id =$this->id;
            $host = 'localhost';
            $user = 'naijafo7_root';
            $password = 'danielpatrick';
            $database = 'naijafo7_dstore';
            $id = $this->id;
            $db = mysqli_connect($host,$user,$password,$database);
            @session_start();
            $em = $_SESSION['account_email'];
            $y = date('Y');
            $m = date('M');
            $d = date('d');
            $h = date('h');
            $m = date('i');
            $s = date('s');
            $a = date('A');
            $dt = $d.', '.$m.', '.$y. '  '.$h.':'.$m.':'.$s.' '.$a;
            $q = mysqli_query($db,"DELETE FROM shopping_cart WHERE product_id = '$id' AND cart_id='$em'");
            $qr = mysqli_query($db,"SELECT * FROM shopping_cart WHERE cart_id = '$em'");
            $cnt = mysqli_num_rows($qr);?>
            <script>
                var cartnum = <?php echo $cnt; ?>;
            </script>
            <?php
            if ($cnt >= 0) { ?>
            <?php
            }
            while ($r = mysqli_fetch_array($qr)) { ?>
                <div class="cart-text">
                    <table style="width:100%">
                        <tr>
                            <td style="width:80%">
                                <?php 
                                    $id = $r['product_id'];
                                    $q2 = mysqli_query($db, "SELECT * FROM product WHERE product_id = '$id'");
                                    $name = '';
                                    $price = '';
                                    while ($r2 = mysqli_fetch_array($q2)) {
                                        $name = $r2['name'];
                                        $price = $r2['discounted_price'];
                                    }?>
                                    <center style="text-align:left;font-family:'GothamRounded'"><?php echo $name; ?></center>
                                <?php
                                ?>
                            </td>
                            <td>
                                <center style="font-family:'Roboto'" class="tag"><?php
                                                    if ($price == '0.00') {
                                                        echo 'FREE';
                                                    }
                                                    else {
                                                        echo '$'.$price;    
                                                    }
                                                     ?></center>
                                </td>
                                    <td style="width:14px">
                                        <button class="close ids" onclick="remelem(this.id)" id="<?php echo $id; ?>">&times;</button>
                                </td>
                        </tr>
                    </table>
                </div>
            <?php
            }
            $cn = mysqli_num_rows($qr);
            if ($cn == 0) {
                echo '<center style="font-family:\'GothamRounded\'">Nothing to display here</center>||||0';
            }
            else {
                echo '<br/>
            <br/>
                    <center><button class="buy-now" onclick="checkbuy()">View Details</button></center>||||'.mysqli_num_rows($qr);
            }
       }
    }
    class PrintArray {
        public $arr = '';
        function __construct($arr) {
            $this->arr =  $arr;
            $spl = explode(',',$this->arr);
            $cnt = 0;
            $total = 0;
            ?>
            <p align="right">
                <button class="close" onclick="_('view-details').style.display = 'none';">&times;</button>
            </p>
            <?php
            foreach ($spl as $i) {
                $cnt++;
                $host = 'localhost';
                $user = 'naijafo7_root';
                $password = 'danielpatrick';
                $database = 'naijafo7_dstore';
                $db = mysqli_connect($host,$user,$password,$database);
                $q = mysqli_query($db, "SELECT * FROM product WHERE product_id = '$i'");
                $bigimage = '';
                $name = '';
                $description = '';
                $price = '';
                while ($r = mysqli_fetch_array($q)) {
                    $bigimage = $r['image'];
                    $price = $r['discounted_price'];
                    $name = $r['name'];
                    $smallimage = $r['image_2'];
                    $description = $r['description'];
                    $total = $total + floatval($r['discounted_price']);
                }
                ?>
                <table style="width:100%">
                    <tr>
                        <td class="img-holder">
                            <div style="width:100%">
                                <img src="<?php echo $bigimage; ?>" class="pics" style="height:300px" alt="<?php echo $smallimage; ?>" onmouseover="this.src=this.alt" onmouseout="this.src='<?php echo $bigimage; ?>'">
                            </div>
                        </td>
                         <td>
                            <div class="innertext">
                                <label class="title-top"><?php echo $name; ?></label>
                                <br/>
                                <br/>
                                <div class="desc"><?php echo $description; ?></div>
                                <h3>
                                    <div id="xx<?php echo $cnt; ?>" class="price-tags">
                                        <?php
                                            if ($price == '0.00') {
                                                echo 'FREE';
                                            }
                                            else {
                                                echo '$'.$price;
                                            }
                                        ?>
                                    </div>
                                </h3>
                                    <label class="quant">Quantity</label>
                                    <br/>
                                    <div >
                                          <select id="yy<?php echo $cnt; ?>" class="sele" onchange="upprice(this.id)">
                                              <option>1</option>
                                              <option>2</option>
                                              <option>3</option>
                                              <option>4</option>
                                              <option>5</option>
                                              <option>6</option>
                                              <option>7</option>
                                              <option>8</option>
                                              <option>9</option>
                                              <option>10</option>
                                              <option>11</option>
                                              <option>12</option>
                                              <option>13</option>
                                              <option>14</option>
                                              <option>15</option>
                                              <option>16</option>
                                              <option>17</option>
                                              <option>18</option>
                                              <option>19</option>
                                              <option>20</option>
                                          </select>
                                    </div>
                                    <input type="hidden" id="zz<?php echo $cnt; ?>" value="<?php echo $price; ?>"></div>
                            </div>
                        </td>
                    </tr>
                </table>
                <?php
            }
            echo '<br/><br/><label id="total">Total: $'. $total .'</label><br/>
            <br/>
            <br/>';?>
            <button class="buy-now" id="checktotal" onclick="totalbuy(<?php echo $total; ?>)">Checkout</button><br/><br/><br/>
            <?php
        }
    }
    class fetchPrice {
        public $id = '';
        public function __construct($id) {
            $this->id = $id;
            $id =  $this->id;
            $db = mysqli_connect('localhost','naijafo7_root','danielpatrick','naijafo7_dstore');
            $q = mysqli_query($db, "SELECT discounted_price FROM product WHERE product_id = '$id'");
            $price='';
            while ($r = mysqli_fetch_array($q)) {
                 $price = $r['discounted_price'];
            }
            echo $price;
        }
    }
    class SuccessfulPayment {
        public $price = '';
        public $ref = '';
        function __construct($paid,$ref) {
            $this->price = $paid;
            $this->ref = $ref;
            $ref = $this->ref;
            $paid = $this->price;
            $host = 'localhost';
            $user = 'naijafo7_root';
            $password = 'danielpatrick';
            $database = 'naijafo7_dstore';
            @session_start();
            $em = $_SESSION['account_email'];
            $db = mysqli_connect($host,$user,$password,$database);
            $q = mysqli_query($db,"SELECT * FROM customer WHERE email = '$em'");
            while ($r = mysqli_fetch_array($q)) {
                $custid = $r['email'];
            }
            $y = date('Y');
            $m = date('M');
            $d = date('d');
            $dt = $d.', '.$m.', '.$y. ' WAT';
            mysqli_query($db,"DELETE FROM shopping_cart WHERE cart_id = '$em'");
            mysqli_query($db,"INSERT INTO orders (created_on,price,shipped_on,status,customer_id,reference,shipping_id,nation,delivery_date,charge) VALUES ('$dt','$paid','Pending','Pending','$custid','$ref','Pending','Pending','Pending','Pending')") or error_log(mysqli_error($db));
        }
    }
    class ShippingUpdate {
        public $id;
        public $nation;
        public $shippind_id;
        public $type;
        public function __construct($id,$nation,$shipping_id,$type) {
            $this->id = $id;
            $this->type = $type;
            $this->shipping_id = $shipping_id;
            $host = 'localhost';
            $user = 'naijafo7_root';
            $password = 'danielpatrick';
            $database = 'naijafo7_dstore';
            $region = '';
            $db = mysqli_connect($host,$user,$password,$database);
            $this->nation = htmlspecialchars(mysqli_real_escape_string($db,$nation));
            $cost = '';
            $delivery_date = '';
            $typeid = '';
            $q = mysqli_query($db, "SELECT shipping_id,shipping_cost FROM shipping WHERE shipping_region_id = '$this->shipping_id' AND shipping_type = '$this->type'");
            while ($r = mysqli_fetch_array($q)) {
                $cost = $r['shipping_cost'];
                $typeid = $r['shipping_id'];
            }
            if ($typeid == '1') {
                $cost = '$20';
                $dat = date('d-m-Y',strtotime('+1day'));
                $delivery_date = $dat. ' WAT';
            }
            else if ($typeid == '2') {
                $cost = '$10';
                $dat = date('d-m-Y',strtotime('+4days'));
                $delivery_date = $dat. ' WAT';
            }
            else if ($typeid == '3') {
                $cost = '$5';
                $dat = date('d-m-Y',strtotime('+7days'));
                $delivery_date = $dat. ' WAT';
            }
            else if ($typeid == '4') {
                $cost = '$25';
                $dat = date('d-m-Y',strtotime('+7days'));
                $delivery_date = $dat. ' WAT';
            }
            else if ($typeid == '5') {
                $cost = '$10';
                $dat = date('d-m-Y',strtotime('+28days'));
                $delivery_date = $dat. ' WAT';
            }
            else if ($typeid == '6') {
                $cost = '$35';
                $dat = date('d-m-Y',strtotime('+10days'));
                $delivery_date = $dat. ' WAT';
            }
            else {
                $cost = '$30';
                $dat = date('d-m-Y',strtotime('+28days'));
                $delivery_date = $dat. ' WAT';
            }
            @session_start();
            $em = $_SESSION['account_email'];
            mysqli_query($db, "UPDATE orders SET status = 'progress' WHERE customer_id = '$em' AND order_id = '$this->id'");
            mysqli_query($db, "UPDATE orders SET shipping_id = '$shipping_id' WHERE customer_id = '$em' AND order_id = '$this->id'");
            mysqli_query($db, "UPDATE orders SET nation = '$nation' WHERE customer_id = '$em' AND order_id = '$this->id'");
            mysqli_query($db, "UPDATE orders SET delivery_date = '$delivery_date' WHERE customer_id = '$em' AND order_id = '$this->id'");
            mysqli_query($db, "UPDATE orders SET charge = '$cost' WHERE customer_id = '$em' AND order_id = '$this->id'");
        }
    }
    class SearchProduct {
        public $qstr = '';
        public function __construct($qstr) {
            $this->qstr = $qstr;
            $host = 'localhost';
            $user = 'naijafo7_root';
            $password = 'danielpatrick';
            $database = 'naijafo7_dstore';
            $db = mysqli_connect($host,$user,$password,$database);
            $qstr = htmlspecialchars(mysqli_real_escape_string($db,$this->qstr));
            $q = mysqli_query($db, "SELECT * FROM product WHERE name LIKE '%$qstr%'");
            while ($r = mysqli_fetch_array($q)) {
            $img = $r['image'];
            ?>
            <div class="product-tile">
                <img src="<?php echo $img; ?>" class="fill">
                <br/>
                <br/>
                <center>
                    <label class="name"><?php echo $r['name']; ?></label>
                    <br/>
                    <br/>
                    <?php
                        if ($r['discounted_price'] == '0.00') {?>
                            <label style="font-family:'GothamRounded';color:hotpink">FREE</label>
                            <br/>
                            <br/>
                        <?php
                        }
                        else { ?>
                             <label class="price">$<?php echo $r['discounted_price']; ?></label>
                             <br/>
                             <strike><label class="price"><?php echo $r['price']; ?></label></strike>
                             <br/>
                             <br/>
                        <?php
                        }
                        @session_start();
                        if (isset($_SESSION['account_email'])) { ?>
                            <center><button class="buy-now" id="<?php echo $r['product_id']; ?>" onclick="buynow(this.id)">Buy Now</button></center>
                            <p align="right">
                                <label class="little cart" id="<?php echo $r['product_id']; ?>" onclick="addcart(this.id)"><i class="fas fa-shopping-cart"></i> Add to Cart</label>
                            </p>
                        <?php
                        }
                    ?>
                </center>
                </center>
            </div>
    <?php
            }
            $cnt = mysqli_num_rows($q);
            if ($cnt >=1) {

            }
            else {
                echo '<center style="font-family:\'GothamRounded\'">No result(s) found from your input...</center>';
            }
        }
    }
?>
