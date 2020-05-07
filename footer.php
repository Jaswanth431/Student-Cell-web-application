
<?php
if(!isset($_SESSION['user_type'])){
    $path = "img/developer.jpg";
}else if($_SESSION['user_type'] == "student"){
    $path = "../img/developer.jpg";
}else{
    $path = "../../img/developer.jpg";
}
?>
<footer>
    <div class="footer-left">
        Copyright &copy; RGUKT ONGOLE
    </div>
    <div class="footer-right">
        <i class="fa fa-user" aria-hidden="true"></i>
        Developed by 
        <div class="developer-data-box">
            <a href="#">Jaswanth Kumar</a>
            <div class="developer-details">
                <h2>Developer</h2>
                <div class="developer-img-box"><img src="<?php echo $path?>" alt=""></div>
                <p>Jaswanth Kumar</p>
                <p>(O170431)</p>
            </div>
        </div>
    </div>
</footer>