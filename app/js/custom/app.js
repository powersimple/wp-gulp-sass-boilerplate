(function () {
    'use strict';
    // this function is strict...
 }());
var menu = {},
this_item = {}

function setVideo(url){
    jQuery('#video-player').attr("src",url);
}
function initSite() {
    megaMenu();
   
    if (menus == undefined) {
        window.setTimeout(initSite(), 100);
    }
}
jQuery(function () {
    jQuery('#main-menu').on("click", "a.toggle-menu", function () {
        
        jQuery('.exo-menu').toggleClass('display');

    });

});

var winTop = jQuery(window).scrollTop();
// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
jQuery(function () {
    jQuery(window).scroll(function () {
       
        if (winTop >= 30) {
            jQuery("#site-title").addClass("sticky-header");
       //     jQuery("#sdg-nav").addClass("sticky-header");
            jQuery("#main-menu").addClass("sticky-header");
            jQuery("#pinned-nav").addClass("sticky-header");
        } else {
              jQuery("#site-title").removeClass("sticky-header");
        //      jQuery("#sdg-nav").removeClass("sticky-header");
            jQuery("#main-menu").removeClass("sticky-header");
            jQuery("#pinned-nav").removeClass("sticky-header");
        } //if-else
    }); //win func.
}); //ready func.




