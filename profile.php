
  <?php
  include "includes/head.php";

  ?>
  <body>

  <?php
  include "includes/header.php";

  ?>

    <!-- Page Contents -->
    <div class="pageContents tape">
      <!-- Menu Side Start -->
        <?php
        include "includes/side-menu.php"
        ?>
      <!-- Menu Side End -->

        <?php
        if($User != null){
            ?>
            <div class="midContents">
                <div class="coverDownloader">
                    <div style="border-radius: 20px;border: 1px solid rgba(32, 35, 51, 0.09);">
                        <?php
                            if($LoggedInUser != null){
                                if($LoggedInUser->getObjectId() == $User->getObjectId()){
                                    ?>
                                    <form id="UserCoverForm" method="post" enctype="multipart/form-data">
                                        <input id="UserCoverInput" type="file" accept="image/*" name="UserCover" style="display: none; width: 0px; height: 0px;">
                                    </form>
                                    <form id="ProfileImageForm" method="post" enctype="multipart/form-data">
                                        <input id="ProfileImageInput" type="file" accept="image/*" name="ProfileImage" style="display: none; width: 0px; height: 0px;">
                                    </form>
                                    <div class="downloadArea" style="background-position: center; background-size: cover; background-image: url('<?php echo ($User->get("CoverImage") != null ? $User->get("CoverImage")->getURL():SITE_URL."img/dummy_banner.jpg"); ?>')" onclick="ChangeCover()" id="UserCover">
                                        <?php echo ($LoggedInUser != null ? ($User->getObjectId() == $LoggedInUser->getObjectId() ? "<div class=\"uploadCover\"> <i class=\"fas fa-camera\"></i> <div>Add Cover</div> </div>":""): "")?>
                                    </div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="downloadArea" style="<?php echo ($LoggedInUser != null ? ($User->getObjectId() == $LoggedInUser->getObjectId() ? "":"cursor: unset;"): "cursor: unset;")?> background-position: center; background-size: cover; background-image: url('<?php echo ($User->get("CoverImage") != null ? $User->get("CoverImage")->getURL():SITE_URL."img/dummy_banner.jpg");?>')" >
                                        <?php echo ($LoggedInUser != null ? ($User->getObjectId() == $LoggedInUser->getObjectId() ? "<div class=\"uploadCover\"> <i class=\"fas fa-camera\"></i> <div>Add Cover</div> </div>":""): "")?>
                                    </div>
                                    <?php
                                }
                            }else{
                                ?>
                                <div class="downloadArea" style="<?php echo ($LoggedInUser != null ? ($User->getObjectId() == $LoggedInUser->getObjectId() ? "":"cursor: unset;"): "cursor: unset;")?> background-position: center; background-size: cover; background-image: url('<?php echo ($User->get("CoverImage") != null ? $User->get("CoverImage")->getURL():SITE_URL."img/dummy_banner.jpg");?>')" >
                                    <?php echo ($LoggedInUser != null ? ($User->getObjectId() == $LoggedInUser->getObjectId() ? "<div class=\"uploadCover\"> <i class=\"fas fa-camera\"></i> <div>Add Cover</div> </div>":""): "")?>
                                </div>
                                <?php
                            }
                        ?>


                        <a href="javascript:;" style=" <?php echo ($LoggedInUser != null ? ($User->getObjectId() == $LoggedInUser->getObjectId() ? "":"cursor: unset;"): "cursor: unset;")?>" class="coverImage">
                            <img  <?php echo ($LoggedInUser != null ? ($User->getObjectId() == $LoggedInUser->getObjectId() ? "onclick='ChangeProfile()'":""): "")?> style="width: 93px;object-fit: cover;height: 93px;border-radius: 50%;" id="UserImage" src="<?php echo ($User->get("avatar") != null ? $User->get("avatar"): SITE_URL."img/dummy.jpg");?>" alt=""/> <?php echo ($LoggedInUser != null ? ($User->getObjectId() == $LoggedInUser->getObjectId() ? "<i class=\"fas fa-camera\" onclick='ChangeProfile()'></i>":""): "")?>
                        </a>

                        <div style="padding: 10px;">
                            <div class="userInfo">
                                <h2 class="commonHeading my-2"><?php echo $User->get("username");?></h2>

                                <?php

                                if($LoggedInUser != null){
                                    $query= new \Parse\ParseQuery("Followings");
                                    $query->equalTo("Follower", $LoggedInUser);
                                    $query->equalTo("Followed", $User);
                                    $Found = $query->count();
                                    if($User->getObjectId() == $LoggedInUser->getObjectId()){
                                        ?>
                                        <div style="display: flex">
                                          <!--  <button class="btn btn-primary userInfoBtn" type="button" onclick="PostIntroVoice()"> <i class="fas fa-music"></i>
                                                <?php /*echo ($LoggedInUser->get("introFile") != null ? "Update Short Voice Sample" : "Add a Short Voice Sample")*/?>
                                            </button>

                                            <button class="btn btn-primary userInfoBtn" type="button" style="margin-left: 10px" onclick="$('#editModal').modal('toggle');">
                                                <i class="fas fa-pencil-alt"></i> Settings
                                            </button>-->

                                            <div class="dropdown donloaderDropdown">
                                                  <button class="btn btn-secondary" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" > <i class="fas fa-ellipsis-v"></i> </button>
                                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId" >
                                                      <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#editModal" ><i class="fas fa-pencil-alt"></i> Settings</a >
                                                      <a class="dropdown-item" href="javascript:;" onclick="PostIntroVoice()" ><i class="fas fa-music"></i> <?php echo ($LoggedInUser->get("introFile") != null ? "Update Short Voice Sample" : "Add a Short Voice Sample")?></a >
                                                  </div>
                                            </div>
                                        </div>
                                        <?php
                                    }else{
                                        ?>
                                        <div class="dropdown donloaderDropdown">
                                            <button class="btn btn-primary" type="button" onclick="HandleTrack('<?php echo $User->getObjectId()?>')" id="SubscribeBtn"> <i id="SubscribeIcon" class="fas fa-plus"></i>
                                                <span id="SubscribeText">
                                                    <?php
                                                    if($Found > 0){
                                                        echo "Stop Tracking";
                                                    }else{
                                                        echo "Track";
                                                    }

                                                    ?>
                                                </span>
                                            </button>
                                        </div>
                                        <?php
                                    }
                                }else{
                                    ?>

                                    <div class="dropdown donloaderDropdown">
                                        <button class="btn btn-secondary" type="button" onclick="HandleTrack('<?php echo $User->getObjectId()?>')"> <i id="SubscribeIcon" class="fas fa-plus"></i>
                                            <span id="SubscribeText">Track</span>
                                        </button>
                                    </div>
                                    <?php
                                }
                                ?>


                            </div>
                            <p style=" word-wrap: break-word;">

                                <?php
                                echo ($User->get("userBio") != null ? $User->get("userBio") : "");
                                ?>
                            </p>
                            <div style="display: flex; justify-content: space-between;">
                                <div class="commonHeading">Tracked By
                                    <span style="color: #817cfe">
                                        <?php
                                        $query= new \Parse\ParseQuery("Followings");
                                        $query->equalTo("Followed", $User);
                                        $UsersCount = $query->count();

                                        echo number_format($UsersCount, 0, "", ",");
                                        ?>
                                    </span>
                                </div>
                                <div class="mt-2" style="text-align: left">
                                    <?php
                                    if($User->get("fbLink") != null){
                                        ?>
                                        <a  target="_blank" href="http://www.facebook.com/<?php echo $User->get("fbLink")?>" class="socialLink" style="background-color: #4267b2; color: white">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <?php
                                    }
                                    if($User->get("twitterLink") != null){
                                        ?>
                                        <a  target="_blank" href="https://twitter.com/#!/<?php echo $User->get("twitterLink")?>" class="socialLink" style="background-color: #1da1f2; color: white">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <?php
                                    }
                                    if($User->get("instaLink") != null){
                                        ?>
                                        <a  target="_blank" href="http://www.instagram.com/<?php echo $User->get("instaLink")?>" class="socialLink" style="background-color: #c13584; color: white">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <?php
                                    }
                                    if($User->get("linkedinLink") != null){
                                        ?>
                                        <a target="_blank" href="http://www.linkedin.com/profile/view?id=<?php echo $User->get("linkedinLink")?>" class="socialLink" style="background-color: #0077b5; color: white">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                    <div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                <div class="mt-4 mb-5" id="FablesContainer"></div>
                <div class='row' id="FablesLoader"><i class='fas fa-spinner fa-pulse auto-margin'></i></div>
                <div class="my-4">
                    <hr/>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="rightContents">
            <div class="grayText">DETAILED INFORMATION</div>
            <div class="blackText mt-3"> <i class="far fa-clock mr-2"></i> On site since <?php echo $User->getCreatedAt()->format("F Y")?> </div>
            <?php
            if($LoggedInUser != null){
                ?>
                <div class="topInterests">
                    <div class="meetHeader">
                        <div>
                            <div class="mainText mt-2"> Recently Liked </div>
                        </div>
                    </div>
                </div>
                <?php
                $query = new Parse\ParseQuery("Buzz");
                $query->includeKey("userPointer");
                $query->containedIn("likedBy", array($LoggedInUser->getObjectId()));
                $query->notContainedIn("blockedBy", array($LoggedInUser->getObjectId()));
                $query->notContainedIn("reportedBy", array($LoggedInUser->getObjectId()));
                $query->limit(7);
                $stories = $query->find();
                if(sizeof($stories) == 0){
                    echo "<div class='row topInterests text-center  mt-5'><h2 class='col-12 subHeading'>No Liked Fables Found</h2><p class='mainText col-12'>Fables will be displayed here when you start liking them</p></div>";

                }
                foreach ($stories as $story){
                    ?>
                    <div class="commonLink mt-2 full-width" >
                        <div class="imageContents">
                            <div class="auto-margin"  style="cursor: pointer;" onclick="window.location='https://app.fablefrog.com/index.php?id=<?php echo $story->getObjectId()?>'">
                                <div class="<? echo $story->getObjectId()?>Title"><?php echo $story->get("postBody")?></div>
                                <div class="imageContents">
                                    <div class="auto-margin lightText" style="width: 60px;"> <i class="fas fa-user"></i> <?php echo (strlen($story->get("userPointer")->get("username")) > 5 ? substr($story->get("userPointer")->get("username"), 0, 4)."...":$story->get("userPointer")->get("username"));?> </div>
                                    <div class="auto-margin lightText" style="width: 60px;"> <i class="fas fa-comments"></i> <?php echo number_shorten($story->get("commentsCount"), 2)?> </div>
                                    <div class="auto-margin lightText" style="width: 60px;"> <i class="fas fa-music"></i> <?php echo number_shorten($story->get("playedByCount"), 2);?> </div>
                                </div>
                            </div>
                            <div class="auto-margin" style="display: flex; justify-content: center;  align-items: center; text-align: center; background-image: url('<?php echo $story->get("coverImage")->getURL()?>');background-size: cover; width: 60px; height: 60px; box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px; border-radius: 5px">
                                <div class="btn-play-small auto-margin" style="cursor:pointer;flex-shrink: 0; display: flex; justify-content: center;  align-items: center;" onclick="StartPlaying('<?php echo $story->get("audioFile")->getURL()?>', '<?php echo $story->get("coverImage")->getURL()?>', '<?php echo $story->get("userPointer")->get("username")?>', '<?php echo $story->get("postBody")?>', '<?php echo $story->getObjectId()?>')">
                                    <a class="<?php echo $story->getObjectId()."Btn"?>" data-is-playing = "false" href="javascript:;" ><i class="fas fa-play auto-margin <?php echo $story->getObjectId()."Loader"?>" style="color: white; flex-shrink: 0;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }else{
                echo "<div class='row topInterests text-center  mt-5'><h2 class='col-12 subHeading'>No Liked Fables Found</h2><p class='mainText col-12'>Fables will be displayed here when you start liking them</p></div>";
            }

            ?>
        </div>
    </div>


        <!-- Modal Two -->
        <div
                class="modal commonModals fade"
                id="editModal"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            Edit Profile
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="modalContents px-0 px-lg-4 mt-4" id="ProfileForm">
                            <div class="oddInput">
                                <input required  class="modalInput"  maxlength="25"  style="border-radius: 0.3em; border-right: 1px solid #dedede;" type="text" value="<?php echo ($LoggedInUser != null ? $LoggedInUser->get("username") : "")?>" id="userName" name="userName"  placeholder="Enter Fabler Name (25 char limit)"/>
                            </div>
                            <div class="oddInput" style="display: none">
                                <textarea class="modalInput" style="border-radius: 0.3em; border-right: 1px solid #dedede;" type="text" id="fullName" name="fullName"  placeholder="John Snow"><?php echo ($LoggedInUser != null ? $LoggedInUser->get("fullName") : "")?></textarea>
                            </div>
                            <div class="oddInput">
                                <textarea class="modalInput" style="  resize: none; border-radius: 0.3em; border-right: 1px solid #dedede;" rows="2"  maxlength="150"  type="text"   id="userBio" name="userBio"  placeholder="Enter Bio(150 char limit)"><?php echo ($LoggedInUser != null ? $LoggedInUser->get("userBio") : "")?></textarea>
                            </div>
                            <div class="oddInput">
                                <input class="modalInput" style="border-radius: 0.3em; border-right: 1px solid #dedede;" type="text"  maxlength="20"  value="<?php echo ($LoggedInUser != null ? $LoggedInUser->get("fbLink") : "")?>" id="fbLink" name="fbLink"  placeholder="Facebook Username"/>
                            </div>
                            <div class="oddInput">
                                <input class="modalInput" style="border-radius: 0.3em; border-right: 1px solid #dedede;" type="text"  maxlength="20" value="<?php echo ($LoggedInUser != null ? $LoggedInUser->get("twitterLink") : "")?>" id="twitterLink" name="twitterLink"  placeholder="Twitter Username"/>
                            </div>
                            <div class="oddInput">
                                <input class="modalInput" style="border-radius: 0.3em; border-right: 1px solid #dedede;" type="text"  maxlength="20" value="<?php echo ($LoggedInUser != null ? $LoggedInUser->get("instaLink") : "")?>" id="instaLink" name="instaLink"  placeholder="Instagram Username"/>
                            </div>
                            <div class="oddInput">
                                <input class="modalInput" style="border-radius: 0.3em; border-right: 1px solid #dedede;" type="text"  maxlength="20" value="<?php echo ($LoggedInUser != null ? $LoggedInUser->get("linkedinLink") : "")?>" id="linkedinLink" name="linkedinLink"  placeholder="LinkedIn Username"/>
                            </div>

                            <div style="cursor: pointer " class="mainBtn py-2" onclick="SaveProfile()"><span style="display: none" id="editLoader"><i class="ml-2 mr-2 fas fa-spinner fa-pulse"></i></span> Save Changes</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <?php
include "includes/dialogs.php";
include "includes/scripts.php";
?>



<script>
    var FablesContainer = $("#FablesContainer");
    var FablesLoader = $("#FablesLoader");

    function LoadStories() {
        FablesLoader.show();
        $.ajax({
            url : "<?php echo SITE_URL?>api/stories.php",
            type: "POST",
            data : {
                'WHAT': "GET-USER-STORIES",
                'USER': "<?php echo ($User != null ? $User->getObjectId() : "")?>",
                'SKIP': SKIP
            }
        }).done(function(response){
            var obj = jQuery.parseJSON(response);
            isMoreDataAvailable = obj.moreData;
            FablesLoader.hide();

            if(obj.success === 1)
            {
                SKIP = SKIP + <?php echo LOAD_LIMIT;?>;
                FablesContainer.append(obj.stories);
            }else{
                FablesContainer.append("<div class='row topInterests text-center'><h2 class='col-12 subHeading'>No Fables Found</h2><p class='mainText col-12'>Try again later</p></div>");
            }
        }).catch(function(error) {
            console.log(error);
            FablesLoader.hide();
            launch_toast("Error", error.message);
        });
    }
    var SKIP = 0;
    var isMoreDataAvailable = false;
    $(document).ready(function () {
        $(window).bind('scroll', function() {
            if ($(window).scrollTop() + $(window).height() > FablesContainer.height() && isMoreDataAvailable) {
                isMoreDataAvailable = false;
                setTimeout(function() {
                    LoadStories();
                }, 1000);
            }
        });

        LoadStories();
    });

    function ChangeCover() {
        $("#UserCoverInput").click();
    }

    $("#UserCoverInput").change(function(){
        readCoverURL(this);
    });
    function readCoverURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img, file;
                var _URL = window.URL || window.webkitURL;
                if ((file = input.files[0])) {
                    var objectUrl = _URL.createObjectURL(file);
                    $("#UserCover").css("background-image", "url('"+objectUrl+"')");
                    $("#UserCoverForm").submit();

                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    function ChangeProfile() {
        $("#ProfileImageInput").click();
    }

    $("#ProfileImageInput").change(function(){
        readProfileURL(this);
    });
    function readProfileURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img, file;
                var _URL = window.URL || window.webkitURL;
                if ((file = input.files[0])) {
                    var objectUrl = _URL.createObjectURL(file);
                    $("#UserImage").attr("src", objectUrl);
                    $("#ProfileImageForm").submit();

                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#UserCoverForm").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var FableFormData = new FormData(this);
        FableFormData.append("WHICH", "UPLOAD-COVER");
        $.ajax({
            type: "POST",
            url : "<?php echo SITE_URL;?>api/auth.php",
            data: FableFormData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                launch_toast("Success", obj.message);
            }
        });
    });
    $("#ProfileImageForm").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var FableFormData = new FormData(this);
        FableFormData.append("WHICH", "UPLOAD-PROFILE");
        $.ajax({
            type: "POST",
            url : "<?php echo SITE_URL;?>api/auth.php",
            data: FableFormData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                launch_toast("Success!", obj.message);
            }
        });
    });

    function SaveProfile() {
        if($("#userName").val() == ""){
            launch_toast("Error", "Kindly enter username")
            return;
        }
        $("#ProfileForm").submit();
    }
    $("#ProfileForm").submit(function (e) {
        var editLoader = $("#editLoader");
        editLoader.show();
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var FableFormData = new FormData(this);
        FableFormData.append("WHICH", "UPDATE-PROFILE");
        $.ajax({
            type: "POST",
            url : "<?php echo SITE_URL;?>api/auth.php",
            data: FableFormData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            success: function (data) {
                editLoader.hide();
                var obj = jQuery.parseJSON(data);

                if(obj.success === 1){
                   // launch_toast("Success!", obj.message);
                    <?php
                    if($LoggedInUser != null){
                        ?>
                    window.location = '<?php echo SITE_URL."profile/"?>'+$("#userName").val();
                    <?php
                    }
                    ?>
                }else{
                    launch_toast("Error", obj.message);
                }
            }
        });
    });

    var isProcessing = false;
    function HandleTrack(UserId) {
        <?php
        if($LoggedInUser != null){
        ?>
        if(!isProcessing) {
            isProcessing = true;
            var SubscribeBtn = $("#SubscribeBtn");
            var SubscribeIcon = $("#SubscribeIcon");
            var SubscribeText = $("#SubscribeText");
            SubscribeIcon.toggleClass("fa-plus");
            SubscribeIcon.toggleClass("fa-spinner fa-pulse");
            SubscribeText.html("Loading");

            $.ajax({
                type: "POST",
                url: "<?php echo SITE_URL;?>api/auth.php",
                data: {
                    "WHICH": "TRACK-USER",
                    "USER": UserId,
                }, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                success: function (data) {
                    isProcessing = false;
                    var obj = jQuery.parseJSON(data);
                    SubscribeIcon.toggleClass("fa-plus");
                    SubscribeIcon.toggleClass("fa-spinner fa-pulse");
                    if (obj.success === 1) {
                        if (obj.isSubscribed) {

                            SubscribeText.html("Stop Tracking");
                        } else {
                            SubscribeText.html("Track");
                        }
                    } else {
                        SubscribeText.html("Track");
                        launch_toast("Error", obj.message);
                    }
                }
            });
        }
        <?php
        }else{
        ?>
        $("#LoginDialog").modal("toggle");

        <?php
        }
        ?>


    }
</script>
  </body>
</html>
