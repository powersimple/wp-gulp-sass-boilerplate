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