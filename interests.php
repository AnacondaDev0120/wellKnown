
  <?php
  include "includes/head.php";
  if(isset($_GET["id"])){
      $query = new \Parse\ParseQuery("BuzzInterests");
      $query->equalTo("objectId", $_GET["id"]);
      $Interest = $query->first(true);
  }

  ?>
  <body>

  <?php
  include "includes/header.php";

  ?>

    <!-- Page Contents -->
    <div class="pageContents curious">
      <!-- Menu Side Start -->
        <?php
        include "includes/side-menu.php"
        ?>
      <!-- Menu Side End -->


        <div class="midContents ">
            <h1 class="commonHeading">Interests</h1>
            <div class="curiousTabs my-4 nav" id="nav-tab" role="tablist">
                <?php
                $query = new \Parse\ParseQuery("BuzzInterests");
                $BuzzInterests = $query->find();
                foreach ($BuzzInterests as $buzzInterest){
                    ?>
                    <a id="<?php echo $buzzInterest->getObjectId()?>Tab" onclick="ChangeInterest('<?php echo clean($buzzInterest->get("Title"))?>', '<?php echo $buzzInterest->getObjectId()?>')" class="curiousTab <?php echo ($Interest != null ? ($buzzInterest->getObjectId() == $Interest->getObjectId() ? "active": ""): "" )?>" href="javascript:;"><?php echo $buzzInterest->get("Title");?></a>
                    <?php
                }
                ?>
            </div>
            <div class="mt-4 mb-5" id="FablesContainer"></div>
            <div class='row' id="FablesLoader"><i class='fas fa-spinner fa-pulse auto-margin'></i></div>
            <div class="my-4">
                <hr/>
            </div>
        </div>
        <div class="rightContents ">
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
                foreach ($stories as $story){
                    ?>
                    <div class="commonLink mt-2 full-width" >
                        <div class="imageContents">
                            <div class="auto-margin" style="cursor: pointer;" onclick="window.location='https://app.fablefrog.com/index.php?id=<?php echo $story->getObjectId()?>'">
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
    var FablesContainer = $("#FablesContainer");
    var FablesLoader = $("#FablesLoader");
    var SelectedInterest = "<?php echo ($Interest != null ? $Interest->getObjectId() : "")?>";
    function LoadStories() {
        FablesLoader.show();
        $.ajax({
            url : "<?php echo SITE_URL?>api/stories.php",
            type: "POST",
            data : {
                'WHAT': "GET-INTEREST-STORIES",
                'INTEREST': SelectedInterest,
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
    function ChangeInterest(title, id) {
        $(".curiousTab").each(function () {
           $(this).removeClass("active");
        });
        $("#"+id+"Tab").addClass("active");
        FablesContainer.empty();
        SKIP = 0;
        SelectedInterest = id;
        var newurl =   '<?php echo SITE_URL?>interests/'+title+"/"+id;
        window.history.pushState({path:newurl},'',newurl);
        LoadStories();
    }
</script>
  </body>
</html>
