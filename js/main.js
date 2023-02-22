$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

$(".moreLink").click(function (e) {
  e.preventDefault();
  $(".moreTextArea").css("display", "block");
  $(".moreLink").css("display", "none");
  $(".dots").css("display", "none");
});

/*$(".commentSide").click(function (e) {
  e.preventDefault();
  $(".hideCommentArea").css("display", "block");
});*/

$(".profileBox .profileButton").click(function (e) {
  e.preventDefault();
  $(".unClickButton").css("pointer-events", "unset");
  $(".unClickButton").css("background-color", "#202333");
  $(".unClickButton").css("color", "white");
});



$(".downloadCoverClosedBtn").click(function (e) {
  e.preventDefault();
  $(".downlaodCover").css("display", "none");
});

$("#profileButton").click(function (e) {
  e.preventDefault();
  $(".editProfileArea").toggleClass("show");
});

$(".modalAddCoverImg").click(function (e) {
  e.preventDefault();
  $(".downlaodCover.downlaodCoverModal").css("display", "block");
});


$(document).delegate('.dotsBtn', 'click touchend', function (e) {
    e.preventDefault();
    console.log("Called");
    $(this).parent().find(".dotsModal").toggleClass("show");
});

$(".hideMenuLink").click(function (e) {
  e.preventDefault();
  $(".subLinks").toggleClass("show");
});

// Owl
$(".owl-carousel").owlCarousel({
  loop: false,
  margin: 12,
  nav: true,
  dots: false,
  autoPlay: false,
  navRewind: true,
  autoplayHoverPause: true,
  responsiveClass: true,
  responsive: {
    0: {
      items: 2,
    },
    600: {
      items: 2,
    },
    1000: {
      items: 3,
    },
  },
    afterAction : function(){
      console.log('afterAction');

      if(this.currentItem === this.maximumItem){
            console.log(this.currentItem, this.maximumItem);
          /*  alert(
                $('.owl-item').eq(this.maximumItem)
            )*/
        }
    },
  onTranslated:callBack
});

function callBack(){
   /* if($('.owl-carousel .owl-item').last().hasClass('active')){
        $('.owl-next').hide();
        $('.owl-prev').show();
        console.log('owl-prev true');
    }else if($('.owl-carousel .owl-item').first().hasClass('active')){
        $('.owl-prev').hide();
        $('.owl-next').show();
        console.log('owl-prev false');
    }*/
}
