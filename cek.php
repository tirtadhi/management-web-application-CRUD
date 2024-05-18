<?php
//jika belum login

if(isset($_SESSION['log'])){

}else{
    header("Location:login.php");
}
?>