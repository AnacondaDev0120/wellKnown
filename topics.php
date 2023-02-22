
  <?php
  include "includes/head.php";
 // session_destroy();
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

        <!-- Mid Contents Start -->
        <div class="midContents">

                <?php
                if(isset($_GET["id"])){
                    $query = new \Parse\ParseQuery("BuzzSubTopics");
                    $query->includeKey("TopicPointer");
                    $query->equalTo("TopicPointer", \Parse\ParseObject::create("BuzzTopics", $_GET["id"]));
                    $query->limit(200);
                    $topics = $query->find();
                    ?>
                    <div class="communitiesTopHeader">
                        <h1 class="commonHeading"><?php echo $topics[0]->get("TopicPointer")->get("Title");?></h1>
                    </div>
                    <div class="ml-1 mr-1">
                    <?php
                    foreach ($topics as $topic){
                        ?>
                        <a  href="<?php echo SITE_URL."explore/".clean($topic->get("Title"))."/".$topic->getObjectId()?>" class="borderBox col-6" style="margin-bottom: 0.2em;padding: 0; border: 1px solid rgba(32, 35, 51, 0.09);">
                            <div class="borderBoxBody lazy" data-src="<?php echo $topic->get("CoverImage")->getURL()?>" style="margin:0;  padding: 0; min-height: 15vh">
                                <div style="width: 100%; height: 100%; min-height: 15vh; padding: 1em; background: #00000070; border-radius: 1em; ">
                                    <div class="col-12">
                                        <h1 class="mainHeading GtSuper whiteText" style="margin-top: 10px;font-size: 1.9rem"><?php echo $topic->get("Title")?></h1>
                                        <div class="whiteText mt-2 mb-2"><?php echo number_shorten(sizeof($topic->get("FollowedBy")), 2);?> participants</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php
                    }
                }else{
                    $query = new Parse\ParseQuery("BuzzTopics");
                    $query->descending("createdAt");
                    $query->limit(200);
                    $topics = $query->find();
                    ?>
                        <div class="communitiesTopHeader">
                            <h1 class="commonHeading">Topics</h1>
                        </div>
                        <div class="ml-1 mr-1">
                            <?php
                    foreach ($topics as $topic){
                        ?>
                        <a  href="<?php echo SITE_URL."topics/".clean($topic->get("Title"))."/".$topic->getObjectId()?>" class="borderBox col-6" style="margin-bottom: 0.2em;padding: 0; border: 1px solid rgba(32, 35, 51, 0.09);">
                            <div class="borderBoxBody lazy" data-src="<?php echo $topic->get("CoverImage")->getURL()?>" style="margin:0;  padding: 0; min-height: 15vh">
                                <div style="width: 100%; height: 100%; min-height: 15vh; padding: 1em; background: #00000070; border-radius: 1em; ">
                                    <div class="col-12">
                                        <h1 class="mainHeading GtSuper whiteText" style="margin-top: 10px;font-size: 1.9rem"><?php echo $topic->get("Title")?></h1>
                                        <div class="whiteText mt-2 mb-2"><?php echo number_shorten(sizeof($topic->get("FollowedBy")), 2);?> participants</div>
                                    </div>
                                </div>
                            </div>

                        </a>


                        <?php
                    }
                }

                ?>
            </div>
        </div>
        <!-- Mid Contents End -->
        <!-- Right Contents  Start -->
        <div class="rightContents">
            <div class="grayText">ABOUT TOPICS</div>
            <div class="lighGrayText">
                The various topics keywords will help you find fables of similar nature.
            </div>
            <div class="lighGrayText">
                Tracking a topic will send fables of that topic to your home page for listening. This will make it easier for you to find fables instead of having to go to the specific topic page in order to find them.
            </div>
        </div>
        <!-- Right Contents End -->
    </div>

<?php
include "includes/dialogs.php";
include "includes/scripts.php";
?>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>

<script>
    $(function() {
        $('.lazy').Lazy();
    });
</script>
  </body>
</html>
