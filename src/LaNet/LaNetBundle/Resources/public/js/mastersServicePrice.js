function addServiceForm(collectionHolder, $newLinkLi) {
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
    addServiceFormDeleteLink($newFormLi);
}

function addServiceFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<button>Удлить услугу</button>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        $tagFormLi.remove();
    });
}


$(document).ready(function(){
  
  var collectionServiceHolder = $('ul.serveces');
    // setup an "add a tag" link
    var $addServiceLink = $('<button class="add_service_btn">Добавить услугу</button>');
    var $newServiceLinkLi = $('<li></li>').append($addServiceLink);
    
    collectionServiceHolder.find('li').each(function() {
        addServiceFormDeleteLink($(this));
    });
    // add the "add a tag" anchor and li to the tags ul
    collectionServiceHolder.append($newServiceLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionServiceHolder.data('index', collectionServiceHolder.find(':input').length);

    $addServiceLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addServiceForm(collectionServiceHolder, $newServiceLinkLi);
    });
});