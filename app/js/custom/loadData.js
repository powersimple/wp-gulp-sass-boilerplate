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
