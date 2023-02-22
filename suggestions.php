
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
            <div class="communitiesTopHeader">
                <h1 class="commonHeading" style="color: #388E3C;">Suggestions</h1>
            </div>
            <div class="row ml-1 mr-1">
                <?php
                $query = new Parse\ParseQuery("Suggestions");
                $query->descending("createdAt");
                $query->limit(2000);
                $topics = $query->find();
                foreach ($topics as $topic){
                    ?>
                    <a href='javascript:;' onclick="OpenRecordDialog('<?php echo addslashes($topic->get("Title"))?>')" class="borderBox col-12" style="margin-bottom: 0.2em;margin-top: 0.5em;padding: 10px 10px;border-radius: 10px;border: 1px solid rgba(32, 35, 51, 0.09);">
                        <h4 class="mainHeading GtSuper blackText" style="font-size: 0.9rem"><?php echo $topic->get("Title")?></h4>
                    </a>


                    <?php
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
