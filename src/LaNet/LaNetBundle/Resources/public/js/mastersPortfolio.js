function addImageForm(collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');

    // get the new index
    var index = collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addImageFormDeleteLink($newFormLi);
}

function addImageFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="" class="blue-link">Удлить фото</a>');
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
    var $addImageLink = $('<a href="" class="blue-link">Добавить фото</a>');
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
});