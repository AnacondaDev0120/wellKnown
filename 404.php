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
        <style>

            /*======================
                404 page
            =======================*/


            .page_404{ padding:40px 0; background:#fff;
            }

            .page_404  img{ width:100%;}

            .four_zero_four_bg{

                background-image: url(<?php echo SITE_URL?>img/dribbble_1.gif);
                height: 400px;
                background-position: center;
            }


            .four_zero_four_bg h1{
                font-size:80px;
            }

            .four_zero_four_bg h3{
                font-size:80px;
            }

            .link_404{
                color: #fff!important;
                padding: 10px 20px;
                background: #39ac31;
                margin: 20px 0;
                display: inline-block;}
            .contant_box_404{ margin-top:-50px;}
        </style>

        <div class="midContents">

            <section class="page_404">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 ">
                            <div class="col-sm-10 col-sm-offset-1  text-center">
                                <div class="four_zero_four_bg">
                                    <h1 class="text-center ">404</h1>


                                </div>

                                <div class="contant_box_404">
                                    <h3 class="h2">
                                        Look like you're lost
                                    </h3>

                                    <p>the page you are looking for not avaible!</p>

                                    <a class="btn btn-primary" href="<?php echo SITE_URL?>"  ><i class="fa fa-home mr-3"></i>Go to Home</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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

  </body>
</html>
