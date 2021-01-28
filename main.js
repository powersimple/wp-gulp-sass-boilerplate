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






// pass the type in the route
// param = url arguments for the REST API
// callback is a dynamic function name 
// Pass the name of a function and it will return the data to that function

var posts = {},
    taxonomies = {},
    categories = {},
    tags = {},
    menus = {},
    media = {},
    posts_nav = {},
    posts_slug_ids = {},
    last_dest = 'outer-nav',
    menu_levels = [],
    menu_slides = [], // an array for all 
    related = {},
    data_score = 7,
    data_loaded = [],
    state = {},
    social = {},
    taxonomies = {},
    taxonomy_accordion = ''

state.featured = {
    'transition': {
        'type': 'flip',
        'face': 'front'
    }
}




function getStaticJSON(route, callback, dest) {
    // route =  the type 
    // param = url arguments for the REST API
    // callback = dynamic function name 
    // Pass in the name of a function and it will return the data to that function

    // local absolute path to the REST API + routing arguments
    var json_data = json_path + route + ".json"
    //console.log("jsonfile",json_data);
    jQuery.ajax({
        url: json_data, // the url
        data: '',
        success: function (data, textStatus, request) {
            console.log("data",data)
            //      data_loaded.push(callback);
            return data,

                callback(data, dest) // this is the callback that sends the data to your custom function

        },
        error: function (data, textStatus, request) {
            //console.log(endpoint,data.responseText)
        },

        cache: false
    })
}
/*
//THIS SECTION IS DEPRECATED, Data now consolidated into one content packet
getStaticJSON('posts', setPosts) // get posts

// retrieves all projects, with fields from REST API
getStaticJSON('pages', setPosts) // get pages

// retrieves all projects, with fields from REST API
getStaticJSON('project', setPosts) // get the projects

// retrieves all categories for the development category
getStaticJSON('categories', setCategories) // returns the children of a specified parent category

// retrieves all categories for the development category
getStaticJSON('tags', setTags) // returns the tags

// retrieves top menu
getStaticJSON('menus', setMenus) // returns the tags

getStaticJSON('media', setMedia) // returns the tags
*/

getStaticJSON('content', setData) // returns all content

function setTaxonomies(data){
    var tax_name = ''
    for(var t in data.taxonomies){
        tax_name = t
        switch (t){// this is necessary to translate the name because the API namespace doesn't map to the taxonomy slug
            case "category":
                tax_name = 'categories'
                break
            case "post_tag":
                tax_name = 'tags'
            case "nav_sdg":
                tax_name = 'sdg'

        }
        taxonomies[t] = {
            


            "data": data[tax_name],
            "name": data.taxonomies[t].name
       }
    }
    setTaxonomyAccordion(); // in taxonomies.js
//  console.log("taxonomies",taxonomies)
}

function setData(data) { //sets all content arrays
/*
    setPosts(data.posts)
    setPosts(data.pages)
    setPosts(data.project)
    setPosts(data.social)
    
    
    setMedia(data.media)
    */

    setTaxonomies(data)


   setTags(data.tags)
   setCategories(data.categories)
    setMenus(data.menus)
    initSite()
//    console.log("menu",menus);

}

function setPosts(data) { // special function for the any post type

    var type = 'post'

    //console.log(data)
    if (Array.isArray(data)) {

        for (var i = 0; i < data.length; i++) { // loop through the list of data
            //console.log("home", data[i].id)
            /*
              The REST API nests the output of title and content in the rendered variable, 
              so we must unpack and set it our way, which is just .title and .content
            */
            if (data[i].title !== undefined && data[i].title.rendered !== undefined) { // make sure the var is there
                data[i].title = data[i].title.rendered // lose that stupid rendered parameter
            }

            if (data[i].content !== undefined && data[i].content.rendered !== undefined) { // make sure the var is there
                data[i].content = data[i].content.rendered // lose the unnecessary "rendered" parameter
            }


            //console.log(dest,data[i]);
            if (data[i].type !== undefined) { // make sure the var is there
                type = data[i].type // set the type for the log

                posts[data[i].id] = data[i] // adds a key of the post id to address all data in the post as a JSON object
            }

        }
    } else {
        type = data.type // set the type for the log

        posts[data.id] = data // adds a key of the post id to address all data in the post as a JSON object

    }


    console.log("posts", posts)


    return posts
}

function megaMenu(){
    var classes = ''
    var megamenu = '<nav id="megamenu" class="content">'
    megamenu += '<ul class="exo-menu">';
    
     megamenu += getMegaMenu(menus.megamenu.menu_levels,classes);
     
    megamenu += '<a href="#" class="toggle-menu visible-xs-block"><i class="fa fa-bars"></i></a>'


    megamenu += '</ul></nav>'
//    console.log(megamenu)
    jQuery("#main-menu").html(megamenu);
}
function getMegaMenu(items,parent_classes){
    
    var this_item = 0,
    menu_items = '',
    classes = '',
    ulclass = '',
    headwrap = '',
    footwrap = '',
    link = "#",
    outer = 'li',
    level = 0,
    target = ''
    for(var i=0; i<items.length;i++){
        
        this_item = items[i]
        headwrap = ''
        footwrap = ''
        classes = ''
        link = ''
        outer = 'li'

        if(this_item.classes != ''){
            classes = ' class="' + this_item.classes + '"'
            ulclass = this_item.classes + '-ul'
                
        }
           
           
        if(this_item.classes.indexOf('mega-drop-down')){
      //      console.log(this_item.title, "mega")
            
                headwrap = '<div class="animated fadeIn mega-menu">'
                headwrap += '<div class="mega-menu-wrap">'
                headwrap += '<div class="row">'
                headwrap = '<ul class="' + ulclass + ' animated fadeIn">'
                footwrap = '</ul></div></div></div>'
                
        } else if (this_item.classes.indexOf('drop-down')) {

            headwrap = '<ul class="' + ulclass + ' animated fadeIn">'
            footwrap = '</ul>'


        } else {
            headwrap = '<ul class="' + ulclass + ' animated fadeIn">'
            footwrap = '</ul>'
        }
        if(this_item.parent_classes == 'mega-drop-down'){
            outer = 'div'
        }
        if(this_item.object == 'gradelevel'){
        console.log("obj",this_item)
        }
        switch(this_item.object) {
            case "page": link = this_item.url
            break
            case "category" : link = this_item.url
            break
            case "gradelevel" : link = this_item.url
            break
              case "custom": link = this_item.url
              
              break

            case "conference": link = this_item.url
            break
            case "award": link = this_item.url
            break

            // default: link = '#';
        }
    //    console.log(this_item)
    
        if(this_item.target != ''){
            target = ' target="_blank"'
        } 
        if(link == ''){
            //menu_items += '<' + outer + ' ' + classes + '><span>' + this_item.title + '</span>' this needs to open the dropdown
             menu_items += '<' + outer + ' ' + classes + '><a href="' + link + '"' + target + '>' + this_item.title + '</a>'
        } else {
         menu_items += '<' + outer + ' ' + classes + '><a href="' + link + '"'+target+'>' + this_item.title + '</a>'
        }

        if (this_item.children != undefined) {
        
            if(this_item.children.length>0){
                menu_items += headwrap
           //     console.log("wrap",headwrap,footwrap)
                menu_items += getMegaMenu(this_item.children, this_item.classes)
                
                menu_items += footwrap

            }
        }
        menu_items += '</li>'


    }
  
    return menu_items;
}

var menu_config = {
    'megamenu': {
        'menu_type': 'megamenu',
        'location': '#main-menu'
    },
    'projects':{
         'menu_type': 'project',
         'location': '#projects'
    }, 
    'social-links' : {
    'menu_type': 'social',
    'location': '#social'
    }
}

function setMenus(data) {
    //console.log("raw menu data",data)
 
    for (var i = 0; i < data.length; i++) {
        menus[data[i].slug] = {}
        menus[data[i].slug].menu_array = []
        menus[data[i].slug].name = data[i].name
        menus[data[i].slug].slug = data[i].slug
        menus[data[i].slug].items = setMenu(data[i].slug, data[i].items)
        
        //console.log("slug", data[i].slug)
    }
   buildMenuData();
//   console.log("raw menu data", menus)
    
}

function setMenu(slug, items) {
    menu = {}
    //console.log("setMenu",dest,slug,items)
    for (var i = 0; i < items.length; i++) {
        menu[items[i].ID] = setMenuItem(slug, items[i])
       // console.log("setMenu", items[i].ID, slug, items)
        if (items[i].menu_item_parent != 0) { //recursive
            menu[items[i].menu_item_parent].children.push(items[i].ID)//children empty array is created in setMenuItem

        } else {

        }
        menus[slug].menu_array.push(menu[items[i].ID])

    }
   // console.log("MENU ARRAY",menus[dest].menu_array)
    console.log("SetMenu",slug, menu)
    return menu
}

function setMenuItem(slug, item) {
    //console.log("setMenuItem",item)
    this_item = {}
    this_item.menu_id = item.ID
    this_item.title = item.title

    this_item.menu_order = item.menu_order
    this_item.object = item.object
    this_item.object_id = item.object_id
    this_item.parent = item.menu_item_parent
    this_item.classes = item.classes
    this_item.url = item.url
    this_item.description = item.description
    this_item.slug = slug


    this_item.children = []//this array is populated in Set Menu

    return this_item
}


function menu_order(a, b) {
    if (a.menu_order < b.menu_order)
        return -1;
    if (a.menu_order > b.menu_order)
        return 1;
    return 0;
}

function setLinearNav(m) {
    var counter = 0
    menus[m].linear_nav = [];
    var id = 0
    for (var i in menus[m].items) {


       // menu.items[i].post = posts[menu.items[i].object_id]
        menus[m].items[i].slug = i


        id = menus[m].items[i].object_id
        menus[m].linear_nav.push(menus[m].items[i])

      
        counter++;
    }
    menus[m].linear_nav.sort(menu_order);
    
    
   //console.log("linear_nav", menus[m].linear_nav);
   // console.log("posts_nav", posts_nav);

}

function setLinearDataNav(m,data) { // sets local data into linear array for wheel
    menus[m].data_nav = []
    menus[m].slug_nav = []
    var counter = 0,
        outer_counter = 0,
        inner_counter = 0,
        inner_subcounter = 0,
        grandparent = 0,
        next_parent = 0,
        dest = 'outer-nav'

    // THESE 3 NESTED LOOPS POPULATE THE data_nav array WITH WHAT IT NEEDS TO BUILD THE WHEEL AND HAVE IT BE CONTROLLED BY THE ORDERED NOTCHES FROM THE NAV
    //console.log(m,data)
    for (var d = 0; d < data.length; d++) { //outer
        dest = 'outer-nav'
        data[d].dest = dest;
        data[d].slice = outer_counter;
        data[d].notch = counter;
        grandparent = counter;
        menus[m].data_nav.push(data[d])
        menus[m].slug_nav[data[d].slug] = counter
        counter++;
        for (var c = 0; c < data[d].children.length; c++) { //children
            data[d].children[c].dest = "inner-nav"
            data[d].children[c].slice = c
            data[d].children[c].notch = counter
            data[d].children[c].parent = grandparent
            next_parent = counter
            menus[m].data_nav.push(data[d].children[c])
            menus[m].slug_nav[data[d].children[c].slug] = counter;
            counter++
            for (var g = 0; g < data[d].children[c].children.length; g++) { //grandchildren
                data[d].children[c].children[g].dest = "inner-subnav"
                data[d].children[c].children[g].slice = g
                data[d].children[c].children[g].notch = counter
                data[d].children[c].children[g].grandparent = grandparent
                data[d].children[c].children[g].parent = next_parent

                menus[m].data_nav.push(data[d].children[c].children[g])
                menus[m].slug_nav[data[d].children[c].children[g].slug] = counter;
                counter++
            }
            // console.log("dataNav", data);
        }

        outer_counter++;

    }
     //console.log("dataNav",m, menus[m].data_nav);
     //console.log("slug_nav",m, menus[m].slug_nav);
}
function getSlug(item,_of,_array,_it){
    var slug = ''
    if(item!=undefined){
        slug = item.slug
        if (posts[item.object_id] != undefined){
            slug = posts[item.object_id].slug
        }
    } else {
    //  console.log("get slug item undefined",slug,item.object_id,item,_of,_array,_it)
    }    
  return slug
    
}
function buildMenuData() {

    // needs post variable
    if (posts == undefined) {
        //console.log("No Posts Data Yet",  posts)
        window.setTimeout(buildMenuData(), 10);
    } else {

        
       
    
        for (var m in menus) { // 
             var data = [];
            //console.log('menu loop',m)
            if (menu_config[m] != undefined) { 
                var items = ''

                //menus[m].items.sort(function(a,b){return a.menu_order-b.menu_order})



                menus[m].menu_array = [];
                for (var i in menus[m].items) {
                    // console.log('menu item', menus[m].items[i], menu_config[m].location)
                    if (menus[m].items[i].parent == 0) {
                        // console.log("menu", menus[m].items[i].title)

                        menus[m].menu_array.push(menus[m].items[i]);
                    }
                    // items += '<a href="#" class="">' + menus[m].items[i].title + '</a>'

                }
                menus[m].menu_array.sort(menu_order);


                var children = [];
                var this_menu = menus[m].menu_array
                var slug = ''
                for (var a = 0; a < this_menu.length; a++) {
                    children = [];

                    for (var c = 0; c < this_menu[a].children.length; c++) {
                        var grandchildren = [];
                        var nested_children = menus[m].items[this_menu[a].children[c]].children;
                        for (var g = 0; g < nested_children.length; g++) {
                            slug = getSlug(menus[m].items[nested_children[g]],g,"g",nested_children,g)
                            grandchildren.push( // data for childe menus
                                {
                                    "title": menus[m].items[nested_children[g]].title,
                                    "url": menus[m].items[nested_children[g]].url,
                                    "slug": slug,
                                    "object": menus[m].items[nested_children[g]].object,
                                    "object_id": menus[m].items[nested_children[g]].object_id, // the post id
                                    "classes": menus[m].items[nested_children[g]].classes,
                                    "description": menus[m].items[nested_children[g]].description
                                }
                            )

                        }
                        
                    slug = getSlug(menus[m].items[this_menu[a].children[c]],"c",this_menu[a].children[c],c)
                      //console.log('bad slug', menus[m].items[this_menu[a].children[c]])
                        children.push( // data for child menus
                            {
                                "title": menus[m].items[this_menu[a].children[c]].title,
                                "slug": slug,
                                "url": menus[m].items[this_menu[a].children[c]].url,
                                "object": menus[m].items[this_menu[a].children[c]].object,
                                "object_id": menus[m].items[this_menu[a].children[c]].object_id, // the post id
                                "classes": menus[m].items[this_menu[a].children[c]].classes,
                                "description": menus[m].items[this_menu[a].children[c]].description,
                                "children": grandchildren,
                                
                            }
                        )

                    }
                    //console.log('outer', this_menu[a].object_id,  this_menu[a])
                    slug = getSlug(this_menu[a],"o",this_menu,a)
                  //  console.log(this_menu[a])
                    data.push({ // data for top level
                        "title": this_menu[a].title,
                        //"id": this_menu[a].id,
                        "slug": slug,
                        "url": this_menu[a].url,
                        "object": this_menu[a].object,
                        "object_id": this_menu[a].object_id, //the post_id
                        "children": children,
                        "classes": this_menu[a].classes,
                        "description": this_menu[a].description
                    })

                }
                menus[m].menu_levels = data
                menu_levels = data;
                setLinearDataNav(m,data);
                setLinearNav(m)
                console.log('data',menus);





                //circleMenu('.circle a')
            }
            
        }

    }

}

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

function setChildCategories(data) {
    for (var i = 0; i < data.length; i++) {
        categories[data[i].id] = data[i]
    }
    // console.log('categories', categories)

    return data
}

function setCategories(data) {
    //console.log("categories json", data)
    for (var i = 0; i < data.length; i++) { //creates object of categories by key
        categories[data[i].id] = data[i]
    }
     console.log('categories', categories)

    return data
}

function setTags(data) {
    for (var i = 0; i < data.length; i++) {
        tags[data[i].id] = data[i]
    }
    console.log('tags', tags)

    return data
}
function setTaxonomyAccordion(){
    console.log(taxonomies);
    showTaxonomies = "category,resource_type,gradelevel";
    tax_array = showTaxonomies.split(",")
    
    var thisdata = []
    for(var i=0;i<tax_array.length;i++){
   //     console.log("accordion", taxonomies[tax_array[i]].name)
        
        taxonomy_accordion += '<h3>' + taxonomies[tax_array[i]].name+'</h3>'
        taxonomy_accordion += '<div>'
        thisdata = taxonomies[tax_array[i]].data
        for(var d=0;d<thisdata.length;d++){

            

            if (thisdata[d].posts == undefined) {
               
                console.log(undefined[tax_array[i]], tax_array[i], thisdata[d].name)
            }
            if (thisdata[d].posts.length){
             taxonomy_accordion += '<a href="/' + tax_array[i] + '/' + thisdata[d].slug + '">' + thisdata[d].name+ '</a><br>'
                }
            }

        //console.log(thisdata)
        taxonomy_accordion += '</div>'
    }
    jQuery('#resource-accordion').html(taxonomy_accordion)
    
}