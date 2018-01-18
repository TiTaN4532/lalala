function addImageForm(collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');

    // get the new index
    var index = collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);
    
    //var id = $(newForm).find("img").attr("id");
    
    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addImageFormDeleteLink($newFormLi);
   /* 
    return id;
    */
}

function addImageFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="" class="blue-link delete-image-from-portfolio">Удалить фото</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        $tagFormLi.remove();
    });
}


$(document).ready(function(){
  
  var collectionImageHolder = $('ul.images');
    // setup an "add a tag" link
    var $addImageLink = $('<a href="" id="add-new-image" class="blue-link">Добавить фото</a>');
    var $newImageLinkLi = $('<li></li>').append($addImageLink);
    
    collectionImageHolder.find('li').each(function() {
        addImageFormDeleteLink($(this));
    });
    // add the "add a tag" anchor and li to the tags ul
    collectionImageHolder.append($newImageLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionImageHolder.data('index', collectionImageHolder.find(':input').length);

    $addImageLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addImageForm(collectionImageHolder, $newImageLinkLi);
    });
    /*
     $(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;
            
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                //console.log ( $('ul.images li:last'));
            
               
             
                         
                reader.onload = function(event) {
                    var id = addImageForm(collectionImageHolder, $newImageLinkLi);
                    $('#'+id).click();
                    console.log (id);
                    $("#"+id).attr('src', event.target.result);
                    
                    
                    //$($.parseHTML('<img>')).attr('src', event.target.result).appendTo($('ul.images li').eq(-2));
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };
    
    

        $('#gallery-photo-add').on('change', function() {
            imagesPreview(this, 'div.gallery');
        });
    });*/
    
    
});