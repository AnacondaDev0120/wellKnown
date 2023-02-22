
  <?php
  include "includes/head.php";
  if(isset($_GET["user"])){
      $query = new \Parse\ParseQuery("_User");
      $query->equalTo("username", $_GET["user"]);
      $User = $query->first(true);
  }
  ?>
  <style>
      a{
          color: #000;
      }
  </style>
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



            <div class="midContents ">

                <?php
                try{
                    $query = new Parse\ParseQuery("Notifications");
                    $query->includeKey("otherUser");
                    $query->equalTo("currUser", $LoggedInUser);
                    $query->includeKey("FablePointer");
                    $query->limit(2000);
                    $query->descending("createdAt");
                    $stories = $query->find();
                    if(sizeof($stories) > 0){
                        foreach ($stories as $story){
                            ?>
                            <div class="commonLink mt-2 full-width" >
                                <div class="imageContents">
                                    <div style="display: flex; justify-content: center;  align-items: center; text-align: center; background-image: url('<?php echo ($story->get("otherUser")->get("avatar") != null ? $story->get("otherUser")->get("avatar"):SITE_URL."img/dummy.jpeg")?>');background-size: cover; width: 60px; height: 60px; box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px; border-radius: 5px"></div>
                                    <div class="ml-4 mt-1">
                                        <a href="<?php echo ($story->get("FablePointer") != null ? "https://app.fablefrog.com/index.php?id=".$story->get("FablePointer")->getObjectId() : "javascript:;")?>"><?php echo $story->get("text")?></a>
                                        <div class="imageContents">
                                            <div class="lightText" > <i class="fas fa-clock"></i> <?php echo get_time_ago($story->getCreatedAt());?> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }else{
                        ?>
                        <div class="row mt-5" style="text-align: center">
                            <h2 class="col-12 subHeading auto-margin">Nothing Found</h2>
                            <div class="col-12 mainText mt-2"> All your account related notifications will be displayed here </div>
                        </div>
                        <?php
                    }
                }catch (Exception $exception){
                    echo $exception->getMessage();
                    print_r($exception);
                }


                ?>
                </div>


        <div class="rightContents">
            <div class="grayText">DETAILED INFORMATION</div>
           <?php
            if($LoggedInUser != null){
                $TotalFables = 0;
                $TotalComments = 0;
                $TotalFollowers = 0;
                $query = new \Parse\ParseQuery("Notifications");
                $query->equalTo("pushType", "NEW-COMMENT");
                $query->equalTo("otherUser", $LoggedInUser);
                $TotalComments = $query->count();


                $query = new \Parse\ParseQuery("Followings");
                $query->equalTo("Followed", $LoggedInUser);
                $TotalFollowers = $query->count();

                $query = new \Parse\ParseQuery("Buzz");
                $query->equalTo("userPointer", $LoggedInUser);
                $TotalFables = $query->count();
                ?>
                <div class="blackText mt-3"> <i class="far fa-clock mr-2"></i> On site since <b><?php echo $LoggedInUser->getCreatedAt()->format("F Y")?></b> </div>
                <div class="blackText mt-3"> <i class="fas fa-music mr-2"></i> Number of Fables <b><?php echo $TotalFables?></b> </div>
                <div class="blackText mt-3"> <i class="fas fa-user mr-2"></i> Total Followers <b><?php echo $TotalFollowers?></b> </div>
                <div class="blackText mt-3"> <i class="fas fa-comments mr-2"></i> Reactions Received <b><?php echo $TotalComments?></b> </div>

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

  </body>
</html>
