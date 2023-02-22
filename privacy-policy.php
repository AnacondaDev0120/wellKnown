
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

        <style>
            .mainText h1 {
                font-size: 1.625rem;
                margin-top: 25px;
                margin-bottom: 15px;
                line-height: 1.4;
            }
            .mainText h2 {
                font-size: 1.625rem;
                margin-top: 25px;
                margin-bottom: 15px;
                line-height: 1.4;
            }
            .mainText ul {
                font-size: 1rem;
                list-style-type: disc;
                line-height: 2;
                margin-left: 30px;
                margin-top: 15px;
                margin-bottom: 15px;
            }
            .mainText  p {
                font-size: 1rem;
                margin-bottom: 10px;
            }
            .mainText  a {
                color: black;
            }
        </style>

            <div class="midContents ">

                <?php
                try{
                    $query = new Parse\ParseQuery("Settings");
                    $settings = $query->first();
                    if($settings != null){
                        ?>
                        <div class="row mt-5" >
                            <h2 class="col-12 subHeading">Privacy Policy</h2>
                            <div class="col-12 mainText mt-2"> <?php echo $settings->get("PrivacyPolicy")?> </div>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="row mt-5" style="text-align: center">
                            <h2 class="col-12 subHeading auto-margin">Nothing Found</h2>
                            <div class="col-12 mainText mt-2"> Seems like you have landed on unknown page </div>
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
                ?>
                <div class="blackText mt-3"> <i class="far fa-clock mr-2"></i> On site since <?php echo $LoggedInUser->getCreatedAt()->format("F Y")?> </div>
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
