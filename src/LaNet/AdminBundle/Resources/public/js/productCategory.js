// Get the ul that holds the collection of tags


function addCategoryForm(collectionHolder, element) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');
    // get the new index
    var index = collectionHolder.data('index');
    var $newLinkLi = element.parent();
    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have

    var newForm = prototype.replace(/__name__/g, index).replace(/_children"><\/div>/g, '_children"><ul class="sub-categories" data-prototype=""></div>' );

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addCategoryFormDeleteLink($newFormLi);
}

function addCategoryFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#">Удалить</a>');
    $tagFormLi.find('input').eq(0).after($removeFormA);
//    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        if(confirm("Уверены что хотите удалить?")) 
            $tagFormLi.remove();
    });
}

function generateChildrenPrototype(collectionHolder, index) {
  
//    var index = collectionHolder.children('li').length;
    var prototype = collectionHolder.data('prototype');
    var newPrototype = prototype.replace(/__name__"/g, index + '_children___name__"');
    newPrototype = newPrototype.replace(/__name___name/g, index + '_children___name___name');
    newPrototype = newPrototype.replace(/\[__name__\]\[name\]/g, '[' + index + '][children][__name__][name]');
    newPrototype = newPrototype.replace(/__name___children"><\/div>/g, index + '_children___name___children"><ul class="sub-categories" data-prototype="__prototype__"></div>')
    //newPrototype = newPrototype.replace(/__prototype__/g, newPrototype);
    
    return newPrototype;
}

function findChildrenLists(collection) {
  
    collection.data('index',collection.children('li:has( input )').length);
    collection.children('li').each(function(index) {
    var childCollection = $(this).find('ul.sub-categories').eq(0);
    childCollection.attr('data-prototype', generateChildrenPrototype(collection,index));
    findChildrenLists(childCollection);
  });
}

$(document).ready(function() {
  
    var collectionCategoryHolder = $('ul.categories');
    
    
    findChildrenLists(collectionCategoryHolder);
    
//    var collectionSubCategoriesHolders = $('ul.sub-categories');
//    var prototype = collectionCategoryHolder.data('prototype');
//    var newPrototype = prototype.replace(/__name__"/g, index + '_children___name__"');
//    newPrototype = newPrototype.replace(/__name___name/g, index + '_children___name___name');
//    newPrototype = newPrototype.replace(/\[__name__\][name]/g, '[' + index + '][name][children][__name__][name]');
//    newPrototype = newPrototype.replace(/__name___children"><\/div>/g, index + '_children___name___children"><ul class="sub-categories" data-prototype="__prototype__"></div>')
//    newPrototype = newPrototype.replace(/__prototype__/g, newPrototype);
//    
//    collectionSubCategoriesHolders.each(function() {
//      $(this).data('prototype', newPrototype);
//    });
    var newCategoryLinkLi = '<li><a href="#" class="add_tag_link">Добавить</a></li>';
    
    collectionCategoryHolder.find('li').each(function() {
        addCategoryFormDeleteLink($(this));
    });
    // add the "add a tag" anchor and li to the tags ul
    
    $('ul.sub-categories').append(newCategoryLinkLi)
    collectionCategoryHolder.append(newCategoryLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
//    collectionCategoryHolder.data('index', collectionCategoryHolder.find(':input').length);

  $(document).on('click','.toggle-category',function(event) {
        event.preventDefault();
        var element = $(this);
        element.parent().next().toggle();
        if(element.hasClass('open')) {
            element.removeClass('open').addClass('close');
            element.html('-');
        } else {
            element.removeClass('close').addClass('open');
            element.html('+');
        }
    });
    $(document).on('click', '.add_tag_link', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        var collectionHolder = $(this).parents('ul').eq(0);
        if(collectionHolder.data('prototype') == undefined) {
          findChildrenLists(collectionHolder.parents('ul').eq(0));
        }
        // add a new tag form (see next code block)
        addCategoryForm(collectionHolder, $(this));
    });
});