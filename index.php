<?php
include "includes/head.php";
  $User = null;

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

        <div class="midContents">
            <div class="col-12" style="cursor: pointer; border: 1px solid #8f919a;height: 51px;border-radius: 50px;margin: 10px 0;" onclick="OpenRecordModal()">
                <div class="row" style="height: 45px;">
                    <div class="col-8">
                        <div style="color: var(--fontcolor);padding-top: 14px;">Click here to record your fable</div>
                    </div>
                    <div class="col-4" style="padding: 0 2px 0 0;">
                        <div class="tab full-width text-center selected-tab" style="height: 100%; margin-top: 2.3px; font-size: 15px; text-align: center"  >Record Now</div>
                    </div>
                </div>

            </div>

            <div class="topInterests">
                <div class="meetHeader">
                    <div>
                        <h2 class="subHeading">Top Interests</h2>
                        <?php /*<div class="mainText mt-2"> To be a part of </div>*/?>
                    </div>
                    <?php /*<a href="<?php echo SITE_URL?>interests/all/any" class="mainText">View All</a>*/?>
                </div>

                <div class="owl-carousel owl-theme mt-2" id="intrestCarousel">
                    <?php
                        $query = new Parse\ParseQuery("BuzzInterests");
                        $query->descending("createdAt");
                        $query->limit(20);
                        $Interests = $query->find();
                        foreach ($Interests as $interest){
                            ?>
                            <div class="item" onclick="window.location='<?php echo SITE_URL."interests/".clean($interest->get("Title"))."/".$interest->getObjectId();?>'">
                                <div class="borderBox" style="padding: 0;">
                                    <div class="borderBoxBody" style="cursor: pointer; background-image: url('<?php echo $interest->get("CoverImage")->getURL()?>'); border-radius: 1em 1em 0 0; margin: 0;"></div>
                                    <div style="margin: 10px">
                                        <div class="meetCardHeading subHeading"><?php echo $interest->get("Title")?></div>
                                        <div class="mainText">
                                            <a class="btn btn-primary " href="javascript:;" style="padding: .1rem .75rem;"> Explore</a>
                                            <span style="float: right; margin-top: 6px;"><?php echo ($interest->get("AudioCounts") != null? $interest->get("AudioCounts") : 0);?> <i class="fa fa-music mr-3" style="color: #817cfe; margin-left: 15px;"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>


                </div>
            </div>
            <div style="padding-bottom: 20px; ">
                <h2 class="subHeading">Fables on the Rise</h2>
                <div class="row" style="margin-top: 20px">
                    <div class="col-6 col-lg-6 col-md-6 col-sm-6 " style="padding-right: 0;" >
                        <a href="javascript:;" class="tab full-width text-center leftTab activeLeftTab" id="RisingFables"> Trending Fables</a>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6 col-sm-6" style="padding-left: 0;">
                        <a href="javascript:;" class="tab full-width text-center rightTab" id="TrackFables">Fablers You Track</a>
                    </div>
                </div>
            </div>

            <div id="FablesContainer">
                <?php
                if(isset($_GET["id"])){
                    $tags = array();
                    $tags = $story->get("buzzTopics");
                    if($tags == null){
                        $tags = array();
                    }
                    $likedBy = $story->get("likedBy");
                    if($likedBy == null){
                        $likedBy = array();
                    }
                    $isLikedByMe = "NO";
                    if($LoggedInUser != null){
                        if(in_array($LoggedInUser->getObjectId(),$likedBy)){
                            $isLikedByMe = "YES";
                        }
                    }
                    $TagsHTML = "";
                    if(sizeof($tags) > 5){
                        for ($x = 0 ; $x < 4 ; $x++){
                            $TagsHTML .= "<span class=\"tooltipBtn small-tab selected-tab\" >".$tags[$x]."</span>";
                        }
                        $TagsHTML .= '<a href="javascript:;" onclick=\'OpenTags('.json_encode($tags).')\' class="plusBtn small-tab disable-tab" >+'.(sizeof($tags) - 3).'</a>';
                    }else{
                        for ($x = 0 ; $x < sizeof($tags) ; $x++){
                            $TagsHTML .= "<span class=\"tooltipBtn small-tab selected-tab\" >".$tags[$x]."</span>";

                        }
                    }
                    echo "<div class=\"borderBox\" style=\"padding: 0; border: 1px solid rgba(32, 35, 51, 0.09);\">
                        <div class=\"borderBoxBody\" style=\"margin:0; background-image: url('".$story->get("coverImage")->getURL()."'); padding: 0;\">
                            <div style=\"width: 100%; height: 100%;  padding: 1em; background: #00000070; border-radius: 1em; display: flex;\">

                                <div class=\"col-8\">
                                    <h1 class=\"mainHeading GtSuper whiteText mainTextTitle ".$story->getObjectId()."Title\"  style=\"margin-top: 10px;\">".$story->get("postBody")."</h1>
                                    <div class=\"whiteText mt-2 mb-2\">Posted: ".get_time_ago($story->getCreatedAt())."</div>
                                    <div class=\"whiteText mt-2 mb-2\">Told By: <img style=\"object-fit: cover; border-radius: 50%; width: 30px; height: 30px;\" src=\"".($story->get("userPointer")->get("avatar") == null ? SITE_URL."img/dummy.jpg": $story->get("userPointer")->get("avatar"))."\"> <a href=\"".SITE_URL."profile/".$story->get("userPointer")->get("username")."\" class=\"ml-3\">".$story->get("userPointer")->get("username")."</a></div>
                                    <div class='horizontalScroll'>".$TagsHTML."</div>
                                </div>
                                <div class=\"auto-margin col-4\" >
                                    <div style=\"float: right; margin-top: -35px\">
                                        <a class=\"mr-3\" onclick=\"HandleLike('".$story->getObjectId()."')\" href=\"javascript:;\" >
                                            <i class=\"far fa-heart\" style=\"font-size: 30px; color: ".($isLikedByMe == "YES" ? "red": "white")."\" id=\"".$story->getObjectId()."LikeIcon\" ></i>
                                            <br/>
                                            <span style=\"    margin-left: 11px;\" id=\"".$story->getObjectId()."Likes\" class=\"whiteText\">".number_shorten(sizeof($likedBy), 2)."</span>
                                        </a>
                                    </div>
                                    <div class=\"btn-play-large auto-margin\"  style=\"cursor: pointer\" onclick=\"StartPlaying('".$story->get("audioFile")->getURL()."', '".$story->get("coverImage")->getURL()."', '".$story->get("userPointer")->get("username")."', '".clean($story->get("postBody"))."', '".$story->getObjectId()."')\">
                                        <a class=\"".$story->getObjectId()."Btn\" data-is-playing = \"false\" href=\"javascript:;\">
                                            <i class=\"play-icon fas fa-play auto-margin ".$story->getObjectId()."Loader\" ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=\"borderBoxTextArea\" style=\"padding: 0 1.2em 1em 1.2em\">
                            <div class=\"borderBoxFooter\">
                                <div class=\"commentSide\" onclick=\"OpenComments('".$story->getObjectId()."')\"> <span><i class=\"fas fa-paragraph\"></i></span> Reply to ".$story->get("userPointer")->get("username")." </div>
                                <div>
                                    <span class=\"counterText\"> <i class=\"fas fa-comments\"></i> <span id='".$story->getObjectId()."CommentsCount'>".number_shorten($story->get("commentsCount"), 2)."<span> </span>
                                    <span class=\"counterText\"> <i class=\"fas fa-eye\"></i> ".number_shorten($story->get("playedByCount"), 2)."  </span>
                                    <span class=\"dotsBtnParent\">
                                            <span class=\"dotsBtn\"  onclick=\"ShareFable('".$story->getObjectId()."')\"> <i class=\"fas fa-ellipsis-h\"></i> </span>
                                            <div class=\"dotsModal\">
                                               <a class=\"editProfileLink\" href=\"#\"> <i class=\"far fa-gem mr-2\"></i> Lorem ipsum dolor sit. </a> <a href=\"#\" class=\"editProfileLink\"> <i class=\"fas fa-share mr-2\"></i> Share </a> <a href=\"#\" class=\"editProfileLink\"> <i class=\"fas fa-info-circle mr-2\"></i> Lorem ipsum dolor sit. </a>
                                               <div class=\"editProfileLink editProfileLinkTwo\">
                                                  <i class=\"fas fa-bell-slash mr-2\"></i>
                                                  <div>
                                                     <div>Participate in the rating</div>
                                                     <div class=\"smText\"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque, vero! </div>
                                                  </div>
                                                  <div> <label class=\"switch\"> <input type=\"checkbox\"/> <span class=\"slider round\"></span> </label> </div>
                                               </div>
                                               <div class=\"editProfileLink editProfileLinkTwo\">
                                                  <i class=\"fas fa-comment-alt mr-2\"></i>
                                                  <div>
                                                     <div>Participate in the rating</div>
                                                     <div class=\"smText\"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque, vero! </div>
                                                  </div>
                                                  <div> <i class=\"fas fa-chevron-right\"></i> </div>
                                               </div>
                                            </div>
                                         </span>
                                </div>
                            </div>
                            <div class=\"hideCommentArea\" id=\"{$story->getObjectId()}CommentsContainer\"></div>
                        </div>
                    </div>";
                }
                ?>
            </div>
            <?php
                if(!isset($_GET["id"])){
                    ?>
                    <div class='row shimmer' id="FablesLoader">
                        <box class="shine" style="width: 100%; height: 130px; border-radius: 20px">
                            <div style="width: 100%">
                                <lines class="shineDark"></lines>
                                <lines class="shineDark"></lines>
                            </div>
                        </box>
                        <lines class="shine"></lines>
                        <lines class="shine"></lines>
                        <br>

                        <box class="shine" style="width: 100%; height: 130px; border-radius: 20px">
                            <div style="width: 100%">
                                <lines class="shineDark"></lines>
                                <lines class="shineDark"></lines>
                            </div>
                        </box>
                        <lines class="shine"></lines>
                        <lines class="shine"></lines>
                        <br>

                        <box class="shine" style="width: 100%; height: 130px; border-radius: 20px">
                            <div style="width: 100%">
                                <lines class="shineDark"></lines>
                                <lines class="shineDark"></lines>
                            </div>
                        </box>
                        <lines class="shine"></lines>
                        <lines class="shine"></lines>
                        <br>

                        <box class="shine" style="width: 100%; height: 130px; border-radius: 20px">
                            <div style="width: 100%">
                                <lines class="shineDark"></lines>
                                <lines class="shineDark"></lines>
                            </div>
                        </box>
                        <lines class="shine"></lines>
                        <lines class="shine"></lines>
                        <br>

                        <box class="shine" style="width: 100%; height: 130px; border-radius: 20px">
                            <div style="width: 100%">
                                <lines class="shineDark"></lines>
                                <lines class="shineDark"></lines>
                            </div>
                        </box>
                        <lines class="shine"></lines>
                        <lines class="shine"></lines>
                        <br>

                        <box class="shine" style="width: 100%; height: 130px; border-radius: 20px">
                            <div style="width: 100%">
                                <lines class="shineDark"></lines>
                                <lines class="shineDark"></lines>
                            </div>
                        </box>
                        <lines class="shine"></lines>
                        <lines class="shine"></lines>
                        <br>
                    </div>

                    <?php
                }
                ?>

        </div>
        <div class="rightContents">
            <div class="topInterests">
                <div class="meetHeader">
                    <div>
                        <h2 class="subHeading">Rising Topics</h2>
                        <div class="mainText mt-2"> You may wanna check.. </div>
                    </div>
                    <a href="<?php echo SITE_URL."topics/"?>" class="mainText">View All</a>
                </div>
            </div>

            <?php
            $query = new Parse\ParseQuery("BuzzTopics");
            $query->descending("FollowedBy");
            if($LoggedInUser != null) {
                $query->notContainedIn("FollowedBy", array($LoggedInUser->getObjectId()));
            }
            $query->limit(5);
            $topics = $query->find();
            foreach ($topics as $topic){
                $FollowedBy = $topic->get("FollowedBy");
                if($FollowedBy == null){
                    $FollowedBy = array();
                }
                $isTracking = false;
                if($LoggedInUser != null){
                    if(in_array($LoggedInUser->getObjectId(), $FollowedBy)){
                        $isTracking = true;
                    }
                }
                ?>
                <div class="commonLink mt-2 full-width" >
                    <div class="imageContents ">
                        <div style="width: 80%"><?php echo $topic->get("Title")?></div>
                        <div class="auto-margin lightText" style="display: none" > <i class="fas fa-users"></i>
                            <span id="Subscribers<?php echo $topic->getObjectId()?>"><?php echo number_shorten(sizeof($topic->get("FollowedBy")), 2)?></span>
                        </div>
                        <button style="height: 35px; float: right" class="btn btn-primary" href="javascript:;" onclick="<?php echo ($isTracking ? "":"HandleSubscribe('".$topic->getObjectId()."')")?>" id="SubscribeText<?php echo $topic->getObjectId()?>"><?php echo ($isTracking ? "Tracking":"Track")?></button>
                    </div>
                </div>
                <?php
            }
            ?>



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
                $query->limit(5);
                $stories = $query->find();
                foreach ($stories as $story){
                    ?>
                    <div class="commonLink mt-2 full-width" >
                        <div class="imageContents">
                            <div class="auto-margin" style="cursor: pointer;" onclick="window.location='https://app.fablefrog.com/index.php?id=<?php echo $story->getObjectId()?>'" >
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
                if(sizeof($stories) == 0){
                    echo "<div class='row topInterests text-center  mt-5'><h2 class='col-12 subHeading'>No Liked Fables Found</h2><p class='mainText col-12'>Fables will be displayed here when you start liking them</p></div>";

                }
            }else{
                echo "<div class='row topInterests text-center  mt-5'><h2 class='col-12 subHeading'>No Liked Fables Found</h2><p class='mainText col-12'>Fables will be displayed here when you start liking them</p></div>";

            }
            ?>
        </div>
    </div>

<?php
include "includes/dialogs.php";
include "includes/scripts.php";
?>

<script>
    var RisingFables =  $("#RisingFables");
    var TrackFables =  $("#TrackFables");
    var Type = "RISING";
    RisingFables.on("click touchend", function () {
        ClearTabs();
        Type = "RISING";
        SKIP = 0;
        FablesContainer.empty();
        TrackFables.removeClass("activeRightTab");
        RisingFables.addClass("activeLeftTab");
        LoadStories();
    });
    TrackFables.on("click touchend", function () {
        <?php
            if($LoggedInUser == null){
                ?>
                $("#LoginDialog").modal("toggle");
        <?php
            }else{
                ?>
                ClearTabs();
                Type = "TRACK";
                FablesContainer.empty();
                SKIP = 0;
                TrackFables.addClass("activeRightTab");
                RisingFables.removeClass("activeLeftTab");
                LoadStories();
        <?php
    }
        ?>

    });

    function ClearTabs() {
        RisingFables.removeClass("selected-tab");
        TrackFables.removeClass("selected-tab");
        RisingFables.addClass("disable-tab");
        TrackFables.addClass("disable-tab");
    }

    var FablesContainer = $("#FablesContainer");
    var FablesLoader = $("#FablesLoader");

    function LoadStories() {
        FablesLoader.show();
        $.ajax({
            url : "<?php echo SITE_URL?>api/stories.php",
            type: "POST",
            data : {
                'WHAT': "GET-HOME-STORIES",
                'SKIP': SKIP,
                'TYPE': Type
            }
        }).done(function(response){
            var obj = jQuery.parseJSON(response);
            isMoreDataAvailable = obj.moreData;
            console.log(isMoreDataAvailable);
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
        <?php
        if(!isset($_GET["id"])){
            ?>
        $(window).bind('scroll', function() {
            if ((($(window).scrollTop() + $(window).height()) > FablesContainer.height()) && isMoreDataAvailable) {
                isMoreDataAvailable = false;
                LoadStories();
            }
        });

        LoadStories();
        <?php
        }
        ?>

    });


    var isProcessing = false;
    function HandleSubscribe(TopicId) {
        <?php
        if($LoggedInUser != null){
        ?>
        if(!isProcessing) {
            isProcessing = true;
            var SubscribeText = $("#SubscribeText"+TopicId);
            SubscribeText.html("Loading...");

            $.ajax({
                type: "POST",
                url: "<?php echo SITE_URL;?>api/auth.php",
                data: {
                    "WHICH": "SUBSCRIBE-TOPIC",
                    "TOPIC": TopicId,
                }, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                success: function (data) {
                    isProcessing = false;
                    SubscribeText.html("Track");

                    var obj = jQuery.parseJSON(data);
                    if (obj.success === 1) {
                        SubscribeText.hide();
                        $("#Subscribers"+TopicId).html(obj.Subscribers);
                    } else {
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
