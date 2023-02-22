<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 2021-06-18
 * Time: 10:47
 */
?>

<div id="miniMenu" class="footerMenu">
    <div class="container-fluid px-0">
        <div class="footerLinks">
            <a class="footerLink  <?php echo ($PageName == "index"? "active":"")?>" href="<?php echo SITE_URL?>">
                <i class="fas fa-home"></i>
                <div class="footerMenuText">Home</div>
            </a >
            <a class="footerLink  <?php echo ($PageName == "search"? "active":"")?>" href="<?php echo SITE_URL."search.php"?>" >
                <i class="fas fa-search"></i>
                <div class="footerMenuText">Search</div>
            </a >
            <a class="footerLink  <?php echo ($PageName == "topics"? "active":"")?>" href="<?php echo SITE_URL."topics.php"?>" >
                <i class="fas fa-music"></i>
                <div class="footerMenuText">Topics</div>
            </a >

          <!--  <a class="footerLink" onclick="OpenRecordModal()" href="javascript:;" >
                <i class="far fa-plus-square"></i>
                <div class="footerMenuText">ADD</div>
            </a >-->
            <?php
            if($LoggedInUser != null){
                ?>
                <a class="footerLink <?php echo ($PageName == "profile"? "active":"")?>" href="<?php echo SITE_URL."profile/".$LoggedInUser->get("username")?>" >
                    <img style="width: 40px; height: 40px; margin-bottom: 0.5em; border-radius: 100%;margin-top: 7px;" src="<?php echo  ($LoggedInUser->get("avatar") != null ? $LoggedInUser->get("avatar") : SITE_URL."img/dummy.jpg");?>">
                    <div class="footerMenuText">Profile</div>
                </a >

                <?php
                /*
                 *  <a class="footerLink <?php echo ($PageName == "recents"? "active":"")?>" href="<?php echo SITE_URL."recents.php"?>" >
                    <i class="far fa-bell"></i>
                    <div class="footerMenuText">Recent</div>
                </a >
                 */
            }else{
                ?>
                <a class="footerLink"  data-toggle="modal"  data-target="#LoginDialog" href="javascript:;" >
                    <img style="width: 40px; height: 40px; margin-bottom: 0.5em; border-radius: 100%;margin-top: 7px;" src="<?php echo  SITE_URL."img/dummy.jpg";?>">
                    <div class="footerMenuText">Profile</div>
                </a >
                <?php
            }
            ?>


        </div>
    </div>
</div>

<!-- Modal -->
<div
    class="modal commonModals fade"
    id="exampleModalCenter"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Being a Kew expert means:
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-4">
                    <div class="col-lg-4">
                        <div class="modalCard">
                            <i class="fas fa-pen"></i>
                            <div class="modalSubHeading">
                                More confidence in your answers
                            </div>
                            <div class="lighGrayText">
                                Everyone will understand everything by the corresponding
                                icon in your profile
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="modalCard">
                            <i class="fas fa-user-plus"></i>
                            <div class="modalSubHeading">New grateful readers</div>
                            <div class="lighGrayText">
                                Your answers are shown first - more people will see them
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="modalCard">
                            <i class="fas fa-keyboard"></i>
                            <div class="modalSubHeading">
                                Dissemination of reliable knowledge
                            </div>
                            <div class="lighGrayText">
                                You mark other authors' answers as true or false
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <a href="#" class="yellowBtn"
                    ><i class="far fa-gem"></i> I want to become a Kew expert
                    </a>
                    <br />
                    <a href="#" class="grayLink mt-4">More about the expert</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Two -->
<div
    class="modal commonModals fade"
    id="LoginDialog"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <img src="<?php echo SITE_URL?>img/logo.png" width="60">
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="askModalHeading GtSuper">Log in to <span class="GtSuper"><span style="color: #817CFE">Fable</span>Frog</span> to post recordings</h3>
                <div class="my-4">
                    <a href="javascript:;" class="yellowBtn" onclick="HandlePhone()">Login with a Phone</a>
                    <a href="javascript:;" class="yellowBtn mt-2" onclick="handleGoogleEmailLogin()">
                        <span id="GoogleLoginStatus">
                            <span style="display: none" id="GoogleLoader">
                                <i class="ml-2 mr-2 fas fa-spinner fa-pulse"></i>
                            </span>
                            Login with Google
                        </span>
                    </a>


                  <!--  <a href="#" class="socialLink facebookIcon">
                        <i class="fab fa-facebook-f"></i>
                    </a>-->

                </div>
                <a href="https://app.fablefrog.com/terms.php" class="grayLink">You agree to our <u>Terms & Conditions</u></a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Three -->
<div
    class="modal commonModals fade"
    id="exampleModalCenterThree"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <i class="fas fa-user-plus"></i>
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="askModalHeading ">
                    Log in to <img src="img/logo.png" style="width: 60px"></img><span class="GtSuper"><span style="color: #817CFE">Fable</span>Frog</span> to <br />
                    subscribe to users
                </h3>
                <div class="my-4">
                    <a href="javascript:;" class="yellowBtn phoneLoginModal">To come in</a>
                    <a href="#" class="socialLink wSign"
                    ><i class="fab fa-google-wallet"></i
                        ></a>
                    <a href="#" class="socialLink facebookIcon"
                    ><i class="fab fa-facebook-f"></i
                        ></a>
                    <a href="#" class="socialLink dotsIcon"
                    ><i class="fas fa-ellipsis-h"></i
                        ></a>
                </div>
                <a href="#" class="grayLink">Create a new account</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Four -->
<div
    class="modal fade"
    id="TagsModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Fable Topics
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="tagsContainer">

            </div>
        </div>
    </div>
</div>

<!-- Modal Four -->
<div
        class="modal fade"
        id="CommentsModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="CommentsModalTitle"
        aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CommentsModalTitle">
                    Fable Comments
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="midContents" style="padding: 0; width: 100%; min-width: 100%" id="commentsContainer">

                </div>
            </div>
            <div class="modal-footer midContents" style="padding: 0; width: 100%; min-width: 100%">
                <div class="borderBox" style="width: 100%; border: 0; padding: 0; margin-bottom: 0;">
                    <div class="borderBoxTextArea" style="padding: 0 1.2em 1em 1.2em">
                        <div class="borderBoxFooter">
                            <div class="commentSide">
                                Press the mic icon to start recording...
                            </div>
                            <div>
                                <span class="counterText"> <i class="fas fa-microphone" style="font-size: 25px"></i> </span>
                                <span class="counterText"> <i class="fas fa-paper-plane" style="font-size: 25px"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Five -->
<div
    class="modal commonModals fade"
    id="exampleModalCenterFive"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <i class="fas fa-heart"></i>
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="askModalHeading">
                    Log in to <img src="img/logo.png" style="width: 60px"></img><span class="GtSuper"><span style="color: #817CFE">Fable</span>Frog</span> so that <br />
                    your voice is heard!
                </h3>
                <div class="my-4">
                    <a href="#" class="yellowBtn">To come in</a>
                    <a href="#" class="socialLink wSign"
                    ><i class="fab fa-google-wallet"></i
                        ></a>
                    <a href="#" class="socialLink facebookIcon"
                    ><i class="fab fa-facebook-f"></i
                        ></a>
                    <a href="#" class="socialLink dotsIcon"
                    ><i class="fas fa-ellipsis-h"></i
                        ></a>
                </div>
                <a href="#" class="grayLink">Create a new account</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Five -->
<div
    class="modal commonModals fade"
    id="exampleModalCenterSix"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <i class="far fa-thumbs-down"></i>
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <h2 class="likeModalHeading">What's wrong with the answer?</h2>
                <div class="likeModalButtons my-3">
                    <button class="likeModalButton">
                        I disagree with the opinion of the author
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="likeModalButton">
                        The answer is misleading <i class="fas fa-check"></i>
                    </button>
                    <button class="likeModalButton">
                        The author did not answer the question
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="likeModalButton">
                        Errors in words and design <i class="fas fa-check"></i>
                    </button>
                    <button class="likeModalButton">
                        The answer is offensive <i class="fas fa-check"></i>
                    </button>
                    <button class="likeModalButton">
                        Its reason <i class="fas fa-check"></i>
                    </button>
                </div>
                <button class="rateBtn">Rate Answer</button>
            </div>
        </div>
    </div>
</div>
<style>
    .copyfrom {
        position: absolute;
        left: -9999px;
    }
</style>
<!-- Modal Seven -->
<div
    class="modal commonModals fade"
    id="shareDialog"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareDialogTitle">Share this</h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <input class='copyfrom' tabindex='-1' aria-hidden='true'>

                <a href="javascript:;" onclick="ShareWhatsApp()" class="shareMediaLink">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="javascript:;" class="shareMediaLink" onclick="FacebookShare()">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a href="javascript:;" class="shareMediaLink" onclick="TwitterShare()">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="javascript:;" onclick="CopyUrl()" class="commonButton">
                    <i class="fas fa-link"></i>
                    Copy link
                </a>

            </div>
        </div>
    </div>
</div>

<!-- Modal Eight -->
<div
    class="modal commonModals fade"
    id="exampleModalCenterEight"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h1 class="downloadModalHeading">
                    Download <img src="<?php echo SITE_URL?>img/logo.png" style="width: 60px"></img><span class="GtSuper"><span style="color: #817CFE">Fable</span>Frog</span><br/>on your SmartPhone
                </h1>
                <div class="downLoadModalText">
                    Download the app for iOS or Android
                </div>
                <div class="downLoadModalMediaLinks">
                    <div class="mr-4">
                        <a href="javascript:;" style="cursor: none" class="downLoadModalMediaLink">
                            <?php
                            /*
                             * <!--                            <img class="qrCodeImg" src="echo SITE_URLimg/QR-code.png" alt="" />
                            -->
                            */
                            ?>
                        </a>
                    </div>
                    <div>
                        <a href="https://play.google.com/store/apps/details?id=fablefrog.app" target="_blank" class="downLoadModalMediaLink">
                            <img src="<?php echo SITE_URL?>img/google-icon.png" alt="" style="width: 50%"/>
                        </a>
                        <br />
                        <a href="https://apps.apple.com/jm/app/fablefrog/id1568989824" target="_blank" class="downLoadModalMediaLink">
                            <img src="<?php echo SITE_URL?>img/play-store-icon.png" alt="" style="width: 50%"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ask Modal Two -->
<div
    class="modal commonModals fade"
    id="askModalTwo"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body pt-0">
                <div class="askTwoHeader">
                    <a id="loginHrefLink" href="profileAfterLogin.html">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <a href="#" class="unClickButton">Post a Fable</a>
                </div>
                <input
                    type="text"
                    class="largeTextInput"
                    maxlength="100"
                    placeholder="Write a few words about your fable"
                />
               <!-- <div class="colorChangers">
                    <div class="inputCheckBg">
                        <i class="fas fa-check"></i>
                        <div class="lines">
                            <div class="line"></div>
                            <div class="line sml"></div>
                        </div>
                    </div>
                    <div class="inputCheckBg">
                        <div class="lines">
                            <div class="line"></div>
                            <div class="line sml"></div>
                        </div>
                    </div>
                    <div class="inputCheckBg">
                        <div class="lines">
                            <div class="line"></div>
                            <div class="line sml"></div>
                        </div>
                    </div>
                    <div class="inputCheckBg">
                        <div class="lines">
                            <div class="line"></div>
                            <div class="line sml"></div>
                        </div>
                    </div>
                    <div class="inputCheckBg">
                        <div class="lines">
                            <div class="line"></div>
                            <div class="line sml"></div>
                        </div>
                    </div>
                    <div class="inputCheckBg">
                        <div class="lines">
                            <div class="line"></div>
                            <div class="line sml"></div>
                        </div>
                    </div>
                    <div class="inputCheckBg">
                        <div class="lines">
                            <div class="line"></div>
                            <div class="line sml"></div>
                        </div>
                    </div>
                </div>-->
                <div class="mt-2 askButtons">
                    <a href="#" class="commonButton">
                        <i class="fas fa-tag"></i>Topics
                    </a>
                    <a href="#" class="commonButton">
                        <i class="fas fa-image"></i>Cover
                    </a>
                    <a href="#" class="commonButton">
                        <i class="fas fa-image"></i>Details
                    </a>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="dropdown UserImageDropdown">
                            <button
                                class="btn btn-secondary"
                                type="button"
                                id="triggerId"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                    <span class="userDropdownImageButton">
                      <img src="./img/user-default-grey.png" alt="" />
                      <i class="fas fa-camera"></i>
                    </span>
                                Shehryar Khan
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="#"
                                ><img src="./img/user-default-grey.png" alt="" />
                                    Shehryar khan
                                    <i class="fas fa-check"></i>
                                </a>
                                <a class="dropdown-item" href="#"
                                ><img src="./img/user-default-grey.png" alt="" />
                                    Dont't give my name
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        appearance: none;
        outline: 0;
        box-shadow: none;
        border: 0 !important;
        background: #817CFE;
        background-image: none;
    }
    /* Remove IE arrow */
    select::-ms-expand {
        display: none;
    }
    /* Custom Select */
    .select {
        position: relative;
        display: flex;
        margin: auto;
        width: 20em;
        height: 2em;
        line-height: 2;
        background: #817CFE;
        overflow: hidden;
        border-radius: .25em;
    }
    select {
        flex: 1;
        height: 100%;
        padding: 0 .5em;
        color: #fff;
        cursor: pointer;
    }
    /* Arrow */
    .select::after {
        content: '\25BC';
        position: absolute;
        top: 0;
        right: 0;
        padding: 0 1em;
        background: #6965e6;
        color: white;
        cursor: pointer;
        pointer-events: none;
        -webkit-transition: .25s all ease;
        -o-transition: .25s all ease;
        transition: .25s all ease;
    }
    /* Transition */
    .select:hover::after {
        color: #817CFE;
    }

</style>

<div class="modal commonModals fade" id="askModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"  aria-labelledby="exampleModalCenterTitle"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 700px">
        <div class="modal-content">

            <div class="modal-body pt-0" style="overflow: auto; max-height: 90vh">
                <h5 class="subHeading" id="askModalTitle" style="display: none">Give your fable a title:</h5>

                <form id="FableForm" method="post" enctype="multipart/form-data">
                    <button type="button" style="margin-top: 13px" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
                    <div class="mt-2 mb-2 askButtons" id="FableActions">
                        <a href="javascript:;" id="ShowTitleBtn" onclick="SelectTab('TITLE')" class="commonButton">
                            <i class="fas fa-quote-right" id="TitleIcon"></i>Title
                        </a>
                        <a href="javascript:;" class="commonButton" id="MicBtn"  onclick="SelectTab('RECORDING')">
                            <i class="fas fa-microphone" id="MicIcon"></i>Recording
                        </a>
                        <a href="javascript:;" id="ShowTopicsBtn" onclick="SelectTab('TOPICS')" class="commonButton">
                            <i class="fas fa-tag" id="TopicIcon"></i>Topics
                        </a>
                        <a href="javascript:;" id="ShowInterestsBtn"  onclick="SelectTab('INTERESTS')" class="commonButton">
                            <i class="fas fa-tag" id="InterestIcon"></i>Interests
                        </a>
                        <a href="javascript:;" class="commonButton" id="CoverTab" onclick="SelectTab('COVER')">
                            <i class="fas fa-image" id="CovertIcon"></i>Cover Photo
                        </a>

                    </div>

                    <div id="TitleContainer">
                        <h5 class="subHeading">Give your fable a title:</h5>
                        <textarea style="resize: none;" class="largeTextInput" id="FableTitle" name="FableTitle" rows="5" maxlength="100" placeholder="Write a few words about your fable"></textarea>
                    </div>



                    <div id="TopicsContainer" style="display: none;" >
                        <h5 class="subHeading mr-5">Topics:</h5>
                        <div class="chips__choice TopicsContainer">
                            <?php
                            $query = new Parse\ParseQuery("BuzzTopics");
                            $query->descending("createdAt");
                            $query->limit(500);
                            $topics = $query->find();
                            foreach ($topics as $topic){
                                ?>
                                <a href="javascript:;" class="chip postTopics" data-object="<?php echo $topic->getObjectId()?>" data-name="<?php echo $topic->get("Title")?>">
                                    <i class="fas fa-check mr-2"></i> <?php echo $topic->get("Title")?>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <span style="display: none; margin: auto" id="TopicsLoader"><i class="ml-2 mr-2 fas fa-spinner fa-pulse"></i></span>
                    </div>

                    <div id="SubTopicsContainer" style="display: none;" >
                        <h5 class="subHeading mr-5">Sub Topics:</h5>
                        <div class="chips__choice SubTopicsContainer">

                        </div>
                    </div>

                    <div id="InterestsContainer" style="display: none;">
                        <h5 class="subHeading mr-5">Interests:</h5>
                        <div class="chips__choice InterestsContainer">
                            <?php
                            $query = new Parse\ParseQuery("BuzzInterests");
                            $query->descending("createdAt");
                            $query->limit(500);
                            $topics = $query->find();
                            foreach ($topics as $topic){
                                ?>
                                <a href="javascript:;" class="chip postInterests" data-object="<?php echo $topic->getObjectId()?>" data-name="<?php echo $topic->get("Title")?>">
                                    <i class="fas fa-check mr-2"></i> <?php echo $topic->get("Title")?>
                                </a>

                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div id="CoverContainer" style="display: none; text-align: center">
                        <input id="CoverImageInput" type="file" accept="image/*" name="CoverImage" style="display: none; width: 0px; height: 0px;">
                        <img id="CoverImage" style="margin-top: 15px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; width: 100%; object-fit: cover; max-height: 200px; border-radius: 10px;">
                        <a href="javascript:;" class="commonButton"  id="CoverImageBtn">
                            <i class="fas fa-image"></i>Select Cover Photo
                        </a>

                        <a href="javascript:;" class="ml-2 commonButton"  id="SearchCoverBtn" onclick="$('#SearchContainer').show()">
                            <i class="fas fa-search"></i>Search Cover Photo
                        </a>

                        <div class="row pageHeader" id="SearchContainer" style="display: none">
                            <div class="headerInput" style="width: 100% !important">
                                <input type="text" name="imageSearch" id="imageSearch" value="" placeholder="Search for Images Here">
                                <i class="fas fa-search" onclick="GetImages()" style="cursor: pointer; left: 25px"></i>
                            </div>
                            <div id="ImagesContainer" class="row">

                            </div>
                        </div>
                    </div>


                    <div class="app" id="RecordContainer" style="display: none">
                        <div class="select" style="display: none">
                            <select  id="micSelect" ></select>
                        </div>
                        <div class="audio-controls row">

                            <a href="javascript:;" id="record" class="col-5 commonButton" style="padding: 0.7em 1.5em;">
                                <i class="fas fa-microphone mr-2"></i><span id="RecordLabel">Record</span>
                            </a>
                            <p id="recordingTimer" style="width: 100%"></p>
                            <a href="javascript:;" id="stop" class="col-5 commonButton unClickButton" style="padding: 0.7em 1.5em; display: none">
                                <i class="fas fa-stop mr-2"></i>Stop
                            </a>
                            <audio class="col-10 mt-2" id="audio" style="display: none; height: 40px; width: 50%" controls></audio>

                            <div class="row" style=" text-align: left; width: 100%; display: none;" id="VoiceChangers">
                                <b class="subHeading col-12" style="    font-size: 0.9em; margin: 0;">Voice Changer:</b>
                                <div class="voice-card" onclick="loadTransform(event, 'troll')" style="cursor:pointer; border-radius: 100%;background-image:url('https://app.fablefrog.com/img/troll.jpeg');height: 100px;width: 100px;background-repeat: no-repeat;background-size: 100px 100px;    position: relative;"><span style="    width: 50px;    height: 50px;    position: absolute;   top: 50%;    color: white;    font-size: 13px;    left: 50%;    margin: -25px 0 0 -25px; text-align: center">Voice Changer # 1</span></div>
                                <div class="ml-2 voice-card" onclick="loadTransform(event, 'troll2')" style="cursor:pointer; border-radius: 100%;background-image:url('https://app.fablefrog.com/img/troll.jpeg');height: 100px;width: 100px;background-repeat: no-repeat;background-size: 100px 100px;    position: relative;"><span style="    width: 50px;    height: 50px;    position: absolute;   top: 50%;    color: white;    font-size: 13px;    left: 50%;    margin: -25px 0 0 -25px; text-align: center">Voice Changer # 2</span></div>
                            </div>



                            <a id="download" class="commonButton" style="display: none"><i class="fas fa-cloud-download-alt"></i> Download Your Audio File</a>

                        </div>
                        <canvas id="canvas" style="display: none; width: 100%" height="100"></canvas>

                    </div>
                </form>

                <div class="row">
                    <div class="progress mt-2 mb-2 hide"></div>

                    <div class="col-lg-12" style="margin: auto; text-align: right">
                        <a href="javascript:;" style="margin: auto" class="commonButton" id="PostFable"><i class="fas fa-arrow-right" id="PostFableIcon"></i> <span style="display: none" id="PostFableLoader"><i class="ml-2 mr-2 fas fa-spinner fa-pulse"></i></span> <span id="PostFableText">Continue</span></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Footer Profile Modal -->


<div class="modal commonModals fade" id="editFableModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"  aria-labelledby="exampleModalCenterTitle"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 700px">
        <div class="modal-content">

            <div class="modal-body pt-0" style="overflow: auto; max-height: 90vh">
                <form id="EditFableForm" method="post" enctype="multipart/form-data" style="text-align: left">
                    <button type="button" style="margin-top: 13px" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>

                    <div class="mt-2 mb-2 askButtons" id="FableActions">

                        <a href="javascript:;" id="ShowEditTopicsBtn" onclick="SelectEditTab('TOPICS')" class="commonButton">
                            <i class="fas fa-tag" id="EditTopicIcon"></i>Topics
                        </a>
                        <a href="javascript:;" id="ShowEditInterestsBtn"  onclick="SelectEditTab('INTERESTS')" class="commonButton">
                            <i class="fas fa-tag" id="EditInterestIcon"></i>Interests
                        </a>
                    </div>



                    <div id="TopicsContainerEdit" >
                        <h5 class="subHeading mr-5">Topics:</h5>
                        <div class="chips__choice EditTopicsContainer">
                            <?php
                            $query = new Parse\ParseQuery("BuzzTopics");
                            $query->descending("createdAt");
                            $query->limit(500);
                            $topics = $query->find();
                            foreach ($topics as $topic){
                                ?>
                                <a href="javascript:;" class="chip EditpostTopics" data-object="<?php echo $topic->getObjectId()?>" data-name="<?php echo $topic->get("Title")?>">
                                    <i class="fas fa-check mr-2"></i> <?php echo $topic->get("Title")?>
                                </a>
                                <?php
                            }
                            ?>

                        </div>
                        <span style="display: none; margin: auto" id="EditTopicsLoader"><i class="ml-2 mr-2 fas fa-spinner fa-pulse"></i></span>
                    </div>


                    <div id="SubTopicsContainerEdit" style="display: none;" >
                        <h5 class="subHeading mr-5">Sub Topics:</h5>
                        <div class="chips__choice EditSubTopicsContainer">

                        </div>
                    </div>

                    <div id="InterestsContainerEdit" style="display: none;">
                        <h5 class="subHeading mr-5">Interests:</h5>
                        <div class="chips__choice EditInterestsContainer">
                            <?php
                            $query = new Parse\ParseQuery("BuzzInterests");
                            $query->descending("createdAt");
                            $query->limit(500);
                            $topics = $query->find();
                            foreach ($topics as $topic){
                                ?>
                                <a href="javascript:;" class="chip EditpostInterests" data-object="<?php echo $topic->getObjectId()?>" data-name="<?php echo $topic->get("Title")?>">
                                    <i class="fas fa-check mr-2"></i> <?php echo $topic->get("Title")?>
                                </a>

                                <?php
                            }
                            ?>
                        </div>
                    </div>

                </form>

                <div class="row">
                    <div class="progress mt-2 mb-2 hide"></div>

                    <div class="col-lg-12" style="margin: auto; text-align: right">
                        <a href="javascript:;" style="margin: auto" class="commonButton" id="EditFable"><i class="fas fa-save" id="EditFableIcon"></i> <span style="display: none" id="EditFableLoader"><i class="ml-2 mr-2 fas fa-spinner fa-pulse"></i></span> Save Changes</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Footer Profile Modal -->
<div
    class="modal commonModals fade"
    id="footerProfileModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="roundBorderBox oddBox">
                    <i
                        id="profileModalClosedBtn"
                        class="fas fa-chevron-right"
                        data-dismiss="modal"
                    ></i>
                    <div class="userLoginArea">
                        <div class="userImageSide">
                            <img src="./img/user-default-grey.png" alt="" />
                            <div class="activeUserPoint"></div>
                        </div>
                        <div>
                            <div class="loginUserName">Shehryar Khan</div>
                            <div class="smText">Lorem, ipsum dolor.</div>
                        </div>
                    </div>
                </div>
                <div class="roundBorderBox">
                    <a href="#" class="profileModalLink">
                        <i class="fas fa-bell"></i> Notifications
                    </a>
                    <a href="#" class="profileModalLink">
                        <i class="far fa-clock"></i> Replay later
                    </a>
                    <a href="#" class="profileModalLink">
                        <i class="fas fa-bullhorn"></i> You are asked to answer
                    </a>
                    <a href="#" class="profileModalLink">
                        <i class="fas fa-pen"></i> Drafts
                    </a>
                    <a href="#" class="profileModalLink">
                        <i class="far fa-gem"></i> Become a kew expert
                    </a>
                </div>
                <div class="roundBorderBox">
                    <a href="#" class="profileModalLink">
                        <i class="far fa-user"></i> Change account
                    </a>
                    <a href="#" class="profileModalLink">
                        <i class="fas fa-sign-out-alt"></i> Go out
                    </a>
                </div>
                <div class="roundBorderBox">
                    <div class="grayText">Lorem ipsum dolor sit amet.</div>
                    <div class="menuSide">
                        <div class="footerLinks mt-2">
                            <a href="#" class="socialMediaLink"
                            ><i class="fab fa-facebook-f"></i
                                ></a>
                            <a href="#" class="socialMediaLink"
                            ><i class="fab fa-telegram-plane"></i
                                ></a>
                            <a href="#" class="socialMediaLink"
                            ><i class="fab fa-google-wallet"></i
                                ></a>
                            <a href="#" class="socialMediaLink"
                            ><i class="fab fa-youtube"></i
                                ></a>
                            <a href="#" class="socialMediaLink"
                            ><i class="fas fa-plus-square"></i
                                ></a>
                            <a href="#" class="socialMediaLink"
                            ><i class="fas fa-globe-asia"></i
                                ></a>
                            <a href="#" class="socialMediaLink"
                            ><i class="fas fa-globe-asia"></i
                                ></a>
                            <div class="downloadArea">
                                <div class="d-flex">
                                    <img class="downloadAreaImg" src="./img/img.jpg" alt="" />
                                    <div>
                                        <div class="subHeading"><img src="img/logo.png" style="width: 60px"></img><span class="GtSuper"><span style="color: #817CFE">Fable</span>Frog</span></div>
                                        <div class="grayText">Lorem, ipsum.</div>
                                    </div>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-primary">Download</a>
                                </div>
                            </div>
                            <div class="footerLinksTwo mt-3">
                                <a href="#" class="footerLink">For experts</a>
                                <a href="#" class="footerLink">reference</a>
                                <a href="#" class="footerLink">Conditions</a>
                                <a href="#" class="footerLink">Chat room</a>
                                <a href="#" class="footerLink">Business profile</a>
                            </div>
                            <div class="copyRightText">
                                © 2020
                                <a href="#" class="footerLink"><img src="img/logo.png" style="width: 60px"></img><span class="GtSuper"><span style="color: #817CFE">Fable</span>Frog</span>LLC</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<style>
    #music-dialog{
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
    }


    #app-cover
    {

        right: 0;
        left: 0;
        height: 60px;
        margin: 0px auto;
    }

    #player
    {
        position: relative;
        height: 100%;
        z-index: 3;
    }

    #player-track
    {
        position: absolute;
        top: 0;
        right: 15px;
        left: 15px;
        padding: 13px 22px 10px 184px;
        background-color: #fff7f7;
        border-radius: 15px 15px 0 0;
        transition: 0.3s ease top;
        z-index: 1;
    }

    #player-track.active
    {
        top: -95px;
    }

    #album-name
    {
        color: #54576f;
        font-size: 17px;
        font-weight: bold;
    }

    #track-name
    {
        color: #acaebd;
        font-size: 13px;
        margin: 2px 0 13px 0;
    }

    #track-time
    {
        height: 12px;
        margin-bottom: 3px;
        overflow: hidden;
    }

    #current-time
    {
        float: left;
    }

    #track-length
    {
        float: right;
    }

    #current-time, #track-length
    {
        color: transparent;
        font-size: 11px;
        background-color: #ffe8ee;
        border-radius: 10px;
        transition: 0.3s ease all;
    }

    #track-time.active #current-time, #track-time.active #track-length
    {
        color: #817CFE;
        background-color: transparent;
    }

    #s-area, #seek-bar
    {
        position: relative;
        height: 6px;
        border-radius: 6px;
    }

    #s-area
    {
        background-color:#817cfe6b;
        cursor: pointer;
    }
    #s-area::after {
        content: "";
        width: 60px;
        height: 60px;
        background-color: red;
    }

    #ins-time
    {
        position: absolute;
        top: -29px;
        color: #fff;
        font-size: 12px;
        white-space: pre;
        padding: 5px 6px;
        border-radius: 4px;
        display:none;
    }

    #s-hover
    {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        opacity: 0.2;
        z-index: 2;
    }

    #ins-time, #s-hover
    {
        background-color: #3b3d50;
    }

    #seek-bar
    {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 0;
        background-color: #817CFE;
        transition: 0.2s ease width;
        z-index: 1;
    }

    #player-content
    {
        position: relative;
        height: 100%;
        background-color: #fff;
        box-shadow: 0 30px 80px #656565;
        border-radius: 15px 15px 0 0;
        z-index: 2;
    }

    #album-art
    {
        position: absolute;
        top: -40px;
        width: 90px;
        height: 90px;
        margin-left: 40px;
        transform: rotateZ(0);
        transition: 0.3s ease all;
        box-shadow: 0 0 0 3px #9d6ffd;
        border-radius: 50%;
        overflow: hidden;
    }

    #album-art.active
    {
        top: -60px;
        box-shadow: 0 0 0 4px #fff7f7, 0 30px 50px -15px #afb7c1;
    }



    #album-art img
    {
        display: block;
        position: absolute;
        top: 0;
        object-fit: cover;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: -1;
    }

    #album-art img.active
    {
        opacity: 1;
        z-index: 1;
    }

    #album-art.active img.active
    {
        z-index: 1;
        /*animation: rotateAlbumArt 20s linear 0s infinite forwards;*/
    }

    @keyframes rotateAlbumArt
    {
        0%{ transform: rotateZ(0); }
        100%{ transform: rotateZ(360deg); }
    }

    #buffer-box
    {
        position: absolute;
        top: 50%;
        right: 0;
        left: 0;
        height: 13px;
        color: #1f1f1f;
        font-size: 13px;
        text-align: center;
        font-weight: bold;
        line-height: 1;
        padding: 6px;
        margin: -12px auto 0 auto;
        background-color: rgba(255, 255, 255, 0.19);
        opacity: 0;
        z-index: 2;
    }

    #album-art img, #buffer-box
    {
        transition: 0.1s linear all;
    }

    #album-art.buffering img
    {
        opacity: 0.25;
    }

    #album-art.buffering img.active
    {
        opacity: 0.8;
        filter: blur(2px);
        -webkit-filter: blur(2px);
    }

    #album-art.buffering #buffer-box
    {
        opacity: 1;
    }

    #player-controls
    {
        width: 250px;
        height: 100%;
        margin: 0 5px 0 141px;
        float: right;
        overflow: hidden;
    }

    .control
    {
        width: 33.333%;
        float: left;
        padding: 12px 0;
    }

    .button
    {
        width: 40px;
        height: 40px;
        /*padding: 25px;*/
        background-color: #fff;
        border-radius: 6px;
        cursor: pointer;
    }

    .button i
    {
        display: block;
        color: #d6dee7;
        font-size: 26px;
        text-align: center;
        line-height: 1;
        position:relative;
        top: calc(50% - 10px);
    }

    .button, .button i
    {
        transition: 0.2s ease all;
    }

    .button:hover
    {
        background-color: #d6d6de;
    }

    .button:hover i
    {
        color: #fff;
    }

    #ytd-url {
        display: block;
        position: fixed;
        right: 0;
        bottom: 0;
        padding: 10px 14px;
        margin: 20px;
        color: #fff;
        font-size: 14px;
        text-decoration: none;
        background-color: #ae5f87;
        border-radius: 4px;
        box-shadow: 0 10px 20px -5px rgba(174, 95, 135, 0.86);
        z-index: 125;
    }
</style>

<div id="music-dialog" class="overlay" style="z-index: 9999999; display: none">
    <div id="app-cover">
        <div id="player">
            <div id="player-track">
                <i class="closedModalIcon fa fa-times-circle" id="playerClose" style="position: absolute; top: 5px; right: 10px; font-size: 20px; color: #817CFE"></i>
                <a href="javascript:;" class="counterText" id="PlayerFullImage" onclick="OpenImage('https://parsefiles.back4app.com/JDHDpDyXmZHpD6jKwVj3Ld2L6LcgZtKBzvQ3VaqM/6dedde04d1e879a44f29ad75f0e3e4a2_cover.png','the blue laptop')" style="color: black;    float: right;    margin-right: 24px;    margin-top: -9px;"> <i class="fas fa-image"></i> View Full Photo</a>
                <div id="album-name"></div>
                <div id="track-name"></div>
                <div id="track-time">
                    <div id="current-time"></div>
                    <div id="track-length"></div>
                </div>
                <div id="s-area">
                    <div id="ins-time"></div>
                    <div id="s-hover"></div>
                    <div id="seek-bar"></div>
                </div>
            </div>
            <div id="player-content">
                <div id="album-art">
                    <img src="https://raw.githubusercontent.com/himalayasingh/music-player-1/master/img/_1.jpg" class="active" id="cover_img">
                    <div id="buffer-box">Buffering ...</div>
                </div>
                <div id="player-controls">
                    <div class="control" style="display: none">
                        <div class="button" id="play-previous">
                            <i class="fas fa-backward"></i>
                        </div>
                    </div>
                    <div class="control" style="width: 50%">
                        <div class="button" id="play-pause-button" style="margin: auto; height: 40px;width: 40px;border-radius: 50%;border: 1px solid #b9b3e1;background-color: #817cfe;color: #fff;">
                            <i class="fas fa-play" style="    font-size: 22px;"></i>
                        </div>
                    </div>
                    <div class="control" style="display: none">
                        <div class="button" id="play-next">
                            <i class="fas fa-forward"></i>
                        </div>
                    </div>

                    <div class="control" style="width: 50%;">
                        <div class="button" id="play-speed" onclick="ChangeSpeed()" style="font-weight: bolder; margin: auto;height: 40px;text-align: center;padding-top: 7px;width: 100px;border-radius: 5%;border: 1px solid #b9b3e1;background-color: #817cfe;color: #fff;">
                            normal
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal Two -->
<div
                class="modal commonModals fade"
                id="phoneLoginModal"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modalContents px-0 px-lg-4">
                            <div class="mainText mb-2">
                                In order to login from phone, you must verify your phone number with
                                a verification code.
                            </div>
                            <div class="oddInput">
                                <input class="modalInput phone-field" type="text" id="register_phone_number" maxlength="20" name="register_phone_number"  placeholder="Phone Number" style="width: 184px;"/>
                                <button class="mainBtn" id="sendOTPBtn"  onclick="submitPhoneNumberAuth()" ><span style="display: none" id="SendOtpLoader"><i class="ml-2 mr-2 fas fa-spinner fa-pulse"></i></span> Send OTP</button>
                            </div>
                            <div class="oddInput" id="OTP_CONTAINER" style="display: none;">
                                <input class="modalInput" type="number" maxlength="6" name="register_otp" id="register_otp" placeholder="Enter the 6 digit code" style="width: 184px;"/>
                                <button class="mainBtn" id="VerifyOTP" onclick="submitPhoneNumberAuthCode()"><span style="display: none" id="OtpLoader"><i class="ml-2 mr-2 fas fa-spinner fa-pulse"></i></span> Verify</button>
                            </div>
                            <a href="javascript:;" class="mainBtn py-2"><span style="display: none" id="PhoneLoader"><i class="ml-2 mr-2 fas fa-spinner fa-pulse"></i></span> Log In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


