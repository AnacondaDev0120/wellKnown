<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 2021-06-21
 * Time: 11:50
 */
?>

<div class="mobileHeader row" style="text-align: start; <?php echo ($PageName == "search" ? "display: none !important" : "")?>">
    <div style="width: 50%">
        <h2 class="subHeading"><img src="<?php echo SITE_URL?>img/logo.png" style="width: 52px;margin-top: -10px;"> <span class="GtSuper logo"><span style="color: #817CFE">Fable</span>Frog</span></h2>
    </div>
    <div style="width: 50%">
        <img src="<?php echo SITE_URL?>img/ic_bell.png" style="width: 30px;float: right;margin-left: 10px;margin-right: 10px;" onclick="<?php echo ($LoggedInUser != null ? "window.location='https://app.fablefrog.com/recents.php'" : "OpenLogin()")?>">
        <a href="<?php echo SITE_URL?>search.php" style="width: 30px; float: right;" ><img src="<?php echo SITE_URL?>img/ic_search_gray.png?v=<?php $AppVersion?>" ></a>
    </div>
</div>
<style>
    .select2-container--default .select2-results>.select2-results__options {
        max-height: 50% !important;
        overflow-y: auto;
    }

    ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: gray;
        opacity: 1; /* Firefox */
    }

    :-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: gray;
    }

    ::-ms-input-placeholder { /* Microsoft Edge */
        color: gray;
    }

</style>
<!-- Page Header -->
<header class="pageHeader fixed-top">
    <div class="commonDiv">
        <a class="brand" href="<?php echo SITE_URL?>"><img src="<?php echo SITE_URL?>img/logo.png" style="width: 60px"><span class="GtSuper "><span style="color: #817CFE">Fable</span>Frog</span></a>
    </div>
        <div class="headerInput" style=" <?php echo ($PageName == "search" ? "opacity: 0 !important" : "")?>">
            <select name="headerSearch" id="headerSearch" value="<?php echo (isset($_GET["q"]) ? $_GET["q"] : "")?>"  ></select>
            <i class="fas fa-search" id="SearchBtn" style="cursor: pointer; display: none "></i>
        </div>
        


    <div class="commonDiv text-right">
        <?php
            if($LoggedInUser == null){
                ?>
                <a class="btn btn-primary" href="javascript:;"   data-toggle="modal"  data-target="#LoginDialog"><i class="fa fa-user mr-3"></i>Login/Sign-Up</a>
                <?php
            }else{
                ?>
                <span id="signoutModal" class="dropdown">
                  <button class="grayBtn" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img style="    height: 25px;width: 25px; object-fit: cover; border-radius: 50%; margin-right: 10px" src="<?php echo ($LoggedInUser->get("avatar") != null ? $LoggedInUser->get("avatar") : SITE_URL."img/dummy.jpg")?>"> <?php echo $LoggedInUser->get("username")?> <i class="fas fa-chevron-down"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                    <a class="dropdown-item" style="padding: .25rem .5rem;" href="<?php echo SITE_URL."profile/".$LoggedInUser->get("username")?>"><img style="    height: 25px;width: 25px; object-fit: cover; border-radius: 50%; margin-right: 10px" src="<?php echo ($LoggedInUser->get("avatar") != null ? $LoggedInUser->get("avatar") : SITE_URL."img/dummy.jpg")?>"> <?php echo $LoggedInUser->get("username")?></a>
                    <a class="dropdown-item log-out" style="padding: .25rem 0.75rem;" href="javascript:;"><i class="fas fa-sign-out-alt" style="color: black"></i> Log out</a>
                  </div>
                </span>

                <?php
            }
        ?>
    </div>
</header>

