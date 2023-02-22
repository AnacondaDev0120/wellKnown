
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
    if($Topic != null){
        ?>
        <div class="midContents">
            <div class="coverDownloader">
                <div class="downloadArea" style="cursor: unset;background-position: center; background-size: cover; background-image: url('<?php echo ($Topic->get("CoverImage") != null ? $Topic->get("CoverImage")->getURL(): SITE_URL."img/img.jpg");?>')">
                    <?php echo ($LoggedInUser != null ? ($Topic->getObjectId() == $LoggedInUser->getObjectId() ? "<div class=\"uploadCover\"> <i class=\"fas fa-camera\"></i> <div>Add Cover</div> </div>":""): "")?>
                </div>
                <div class="coverImage">
                    <img style="border-radius: 50% ;height: 100%;" src="<?php echo ($Topic->get("CoverImage") != null ? $Topic->get("CoverImage")->getURL(): SITE_URL."img/dummy.png");?>" alt=""/> <?php echo ($LoggedInUser != null ? ($Topic->getObjectId() == $LoggedInUser->getObjectId() ? "<i class=\"fas fa-camera\"></i>":""): "")?>
                </div>
                <div class="coverDownloaderBody">
                    <div class="userInfo">
                        <h2 class="commonHeading my-2"><?php echo $Topic->get("Title");?></h2>
                        <div class="dropdown donloaderDropdown">
                            <button class="btn btn-primary" type="button" onclick="HandleSubscribe('<?php echo $Topic->getObjectId()?>')">
                                <i style="display: none" id="SubscribeIcon" class="fas fa-spinner fa-pulse"></i>
                                <span id="SubscribeText"><?php
                                    if($LoggedInUser != null){
                                        $FollowedBy = $Topic->get("FollowedBy");
                                        if($FollowedBy == null){
                                            $FollowedBy = array();
                                        }
                                        echo (in_array($LoggedInUser->getObjectId(), $FollowedBy) ? "Stop Tracking":"Start Tracking");
                                    }else{
                                        echo "Start Tracking";
                                    }

                                    ?></span>
                            </button>
                        </div>
                    </div>
                    <?php
                    echo ($Topic->get("Description") != null ? $Topic->get("Description") : "");
                    ?>

                </div>
            </div>

            <div class="mt-2 mb-5">

                <div class="row mb-5" style="margin-top: 20px">
                    <div class="col-4 col-lg-4 col-md-4 col-sm-4">
                        <a href="javascript:;" class="tab full-width text-center selected-tab" id="TopFables"> Top Fables</a>
                    </div>
                    <div class="col-4 col-lg-4 col-md-4 col-sm-4">
                        <a href="javascript:;" class="tab full-width text-center disable-tab" id="RecentFables"> Recent Fables</a>
                    </div>
                    <div class="col-4 col-lg-4 col-md-4 col-sm-4">
                        <a href="javascript:;" class="tab full-width text-center disable-tab" id="RelatedTopics">Related Topics</a>
                    </div>
                </div>
                <div id="FablesContainer">

                </div>
                <div class='shimmer' id="FablesLoader">
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

                <div class="row ml-1 mr-1" id="TopicsContainer" style="display: none">
                    <?php
                    $query = new Parse\ParseQuery("BuzzSubTopics");
                    $query->descending("createdAt");
                    $query->equalTo("TopicPointer", $Topic->get("TopicPointer"));
                    $query->limit(200);
                    $topics = $query->find();
                    foreach ($topics as $topic){
                        ?>
                        <a  href="<?php echo SITE_URL."explore/".clean($topic->get("Title"))."/".$topic->getObjectId()?>" class="borderBox col-6" style="margin-bottom: 0.2em;padding: 0; border: 1px solid rgba(32, 35, 51, 0.09);">
                            <div class="borderBoxBody" style="margin:0; background-image: url('<?php echo $topic->get("CoverImage")->getURL()?>'); padding: 0; min-height: 15vh">
                                <div style="width: 100%; height: 100%; min-height: 15vh; padding: 1em; background: #00000070; border-radius: 1em; display: flex;">
                                    <div class="col-12">
                                        <h1 class="mainHeading GtSuper whiteText" style="margin-top: 10px;font-size: 1.9rem"><?php echo $topic->get("Title")?></h1>
                                        <div class="whiteText mt-2 mb-2"><?php echo number_shorten(sizeof($topic->get("FollowedBy")), 2);?> participants</div>
                                    </div>
                                </div>
                            </div>

                        </a>


                        <?php
                    }
                    ?>
                </div>

            </div>
            <div class="my-4">
                <hr/>
            </div>

        </div>
        <?php
    }
    ?>

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
                    <div class="auto-margin lightText" style="display: none" > <i class="fas fa-users"></i> <span id="Subscribers<?php echo $topic->getObjectId()?>"><?php echo number_shorten(sizeof($topic->get("FollowedBy")), 2)?></span> </div>
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
                        <div class="auto-margin"  style="cursor: pointer;" onclick="window.location='https://app.fablefrog.com/index.php?id=<?php echo $story->getObjectId()?>'">
                            <div  class="<? echo $story->getObjectId()?>Title"><?php echo $story->get("postBody")?></div>
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
   var TopFables =  $("#TopFables");
   var RecentFables =  $("#RecentFables");
   var RelatedTopics =  $("#RelatedTopics");
   var TopicsContainer =  $("#TopicsContainer");
   var FablesContainer =  $("#FablesContainer");

   var Type = "TOP";
   TopFables.on("click touchend", function () {
       ClearTabs();
       Type = "TOP";
       SKIP = 0;
       FablesContainer.empty();
       FablesContainer.show();
       TopicsContainer.hide();
       TopFables.addClass("selected-tab");
       LoadStories();
   });
   RecentFables.on("click touchend", function () {
       ClearTabs();
       Type = "RECENT";
       FablesContainer.empty();
       FablesContainer.show();
       SKIP = 0;
       TopicsContainer.hide();

       RecentFables.addClass("selected-tab");
       LoadStories();
   });
   RelatedTopics.on("click touchend", function () {
       ClearTabs();
       RelatedTopics.addClass("selected-tab");
       FablesContainer.hide();
       TopicsContainer.show();
   });
   function ClearTabs() {
       TopFables.removeClass("selected-tab");
       RecentFables.removeClass("selected-tab");
       RelatedTopics.removeClass("selected-tab");
       RecentFables.addClass("disable-tab");
       TopFables.addClass("disable-tab");
       RelatedTopics.addClass("disable-tab");

   }

   var FablesContainer = $("#FablesContainer");
   var FablesLoader = $("#FablesLoader");

   function LoadStories() {
       FablesLoader.show();
       $.ajax({
           url : "<?php echo SITE_URL?>api/stories.php",
           type: "POST",
           data : {
               'WHAT': "GET-TOPICS-STORIES",
               'TOPIC': "<?php echo $Topic->getObjectId()?>",
               'TYPE': Type,
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
           //launch_toast("Error", error.message);
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


   var isProcessing = false;
   function HandleSubscribe(TopicId) {
       <?php
       if($LoggedInUser != null){
           ?>
       if(!isProcessing) {
           isProcessing = true;
           var SubscribeIcon = $("#SubscribeIcon");
           var SubscribeText = $("#SubscribeText");
           SubscribeIcon.show();
           SubscribeText.html("Loading");

           $.ajax({
               type: "POST",
               url: "<?php echo SITE_URL;?>api/auth.php",
               data: {
                   "WHICH": "SUBSCRIBE-TOPIC",
                   "TOPIC": TopicId,
               }, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
               success: function (data) {
                   isProcessing = false;
                   var obj = jQuery.parseJSON(data);
                   SubscribeIcon.hide();
                   if (obj.success === 1) {
                       if (obj.isSubscribed) {
                           SubscribeText.html("Stop Tracking");
                       } else {
                           SubscribeText.html("Start Tracking");
                       }
                   } else {
                       SubscribeText.html("Start Tracking");
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
