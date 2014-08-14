function addForm(collectionHolder, $newLinkLi, text) {
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
    addFormDeleteLink($newFormLi, text);
}

function addFormDeleteLink($tagFormLi, text) {
    var $removeFormA = $('<a href="" class="blue-link">Удалить ' + text + '</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        $tagFormLi.remove();
    });
}


$(document).ready(function(){
  
  var collectionHolder = $('ul.category');
    // setup an "add a tag" link
    var $addLink = $('<a href="" class="blue-link">Добавить линейку</a>');
    var $newLinkLi = $('<li></li>').append($addLink);
    
    collectionHolder.find('li').each(function() {
        addFormDeleteLink($(this), 'линейку');
    });

    // add the "add a tag" anchor and li to the tags ul
    collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolder.data('index', collectionHolder.find(':input').length);

    $addLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addForm(collectionHolder, $newLinkLi, 'линейку');
    });
});