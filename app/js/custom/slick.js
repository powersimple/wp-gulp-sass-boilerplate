
  jQuery('.slideshow').slick({
  	autoplay: true,
  dots: true,
  arrows: true,
  infinite: true,
  speed: 1500,
  fade: true,
  cssEase: 'linear',
  focusoOnSelect: true,
  nextArrow: '<i class="slick-arrow slick-next"></i>',
  prevArrow: '<i class="slick-arrow slick-prev"></i>',
  responsive: [{
          breakpoint: 1024,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              dots: true
          }
      },
      {
          breakpoint: 600,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1
          }
      },
      {
          breakpoint: 480,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1
          }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
  ]
  });

  var $carousel = jQuery('.slideshow');
  jQuery(document).on('keydown', function (e) {
      if (e.keyCode == 37) {
          $carousel.slick('slickPrev');
      }
      if (e.keyCode == 39) {
          $carousel.slick('slickNext');
      }
  });
  jQuery('a[data-slide]').click(function (e) {

              e.preventDefault();
              var slideno = jQuery(this).data('slide');
              console.log(slideno);
              $carousel.slick('slickGoTo', slideno);
              });
