<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 2021-06-18
 * Time: 10:47
 */?>
<div class="menuSide">
    <a href="<?php echo SITE_URL?>" class="menuLink <?php echo ($PageName == "index"? "active":"")?>"><i class="fas fa-home"></i> Home</a>
    <a href="<?php echo SITE_URL."search.php"?>" class="menuLink <?php echo ($PageName == "search" ? "active":"")?>"><i class="fas fa-search"></i> Search</a>
    <?php
    if($LoggedInUser != null){
        ?>
        <a href="<?php echo SITE_URL."suggestions/"?>" class="menuLink <?php echo ($PageName == "suggestions"  ? "active":"")?>"><i class="fab fa-sketch"></i> <span style=" width: 100%">Suggestions<i style="float: right" class="fas fa-arrow-right"></i></span> </a>
        <a href="<?php echo SITE_URL."profile/".$LoggedInUser->get("username")?>" class="menuLink <?php echo ($PageName == "profile" && $LoggedInUser->get("username") == $_GET["user"] ? "active":"")?>"><i class="far fa-user"></i> Profile</a>

        <a href="<?php echo SITE_URL."recents.php"?>" class="menuLink <?php echo ($PageName == "recents"? "active":"")?>"><i class="far fa-bell"></i> Recent User Activity</a>
        <a href="javascript:;" class="menuLink log-out"><i class="fas fa-sign-out-alt" style="color: black"></i> Log out</a>

        <?php
    }
    /*
     * <!-- <a
       href="#"
       data-toggle="modal"
       data-target="#exampleModalCenter"
       class="menuLink"
       ><i class="far fa-gem"></i> Become a Kew expert
     </a>-->
    <!-- <a
       href="#"
       data-toggle="modal"
       data-target="#LoginDialog"
       class="mainBtn"
       >Ask a Question</a
     >-->
    <a href="#" class="socialMediaLink"><i class="fab fa-facebook-f"></i></a>
    <a href="#" class="socialMediaLink"><i class="fab fa-telegram-plane"></i></a>
    <a href="#" class="socialMediaLink"><i class="fab fa-google-wallet"></i></a>
    <a href="#" class="socialMediaLink"><i class="fab fa-youtube"></i></a>
    <a href="#" class="socialMediaLink"><i class="fas fa-plus-square"></i></a>
    <a href="#" class="socialMediaLink"><i class="fas fa-globe-asia"></i></a>
     */
    ?>

    <div class="footerLinks">

        <div>
            <a href="#" class="downloadLink" data-toggle="modal"  data-target="#exampleModalCenterEight">
                <i class="fas fa-square"></i> Download the App
            </a>
        </div>
        <a href="<?php echo SITE_URL."contact-us.php";?>" class="footerLink">Contact Us</a>
        <a href="<?php echo SITE_URL."privacy-policy.php"?>" class="footerLink">Privacy Policy</a>
        <a href="<?php echo SITE_URL."copyright.php";?>" class="footerLink">Copyright Policy</a>
        <a href="<?php echo SITE_URL."terms.php";?>" class="footerLink">Terms & Conditions</a>
        <a href="<?php echo SITE_URL."faq/";?>" class="footerLink">FAQs</a>
        <div class="copyRightText">
            © <?php echo date("Y");?>
            <a href="<?php echo SITE_URL?>" class="footerLink"><span class="GtSuper"><span style="color: #817CFE">Fable</span><span style="color: black">Frog</span></span></a>
        </div>
    </div>
</div>
