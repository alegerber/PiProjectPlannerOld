window.$ = require('jquery');


var $collectionHolderTags;

// setup an "add a tag" link
var $addTagButton = $('<button type="button" class="add_tag_link btn btn-success btn-outline">Add a tag</button>');
var $newLinkLiTags = $('<li></li>').append($addTagButton);

$(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolderTags = $('ul.tags');

    // add a delete link to all of the existing tag form li elements
    $collectionHolderTags.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolderTags.append($newLinkLiTags);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolderTags.data('index', $collectionHolderTags.find(':input').length);

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolderTags, $newLinkLiTags);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    // add a delete link to the new form
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<div class="input-group-append"><button class="btn btn-danger btn-outline" type="button">Remove</button><div>');
    $tagFormLi.children().append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}

var $collectionHolderCategory;

// setup an "add a tag" link
var $addCategoryButton = $('<button type="button" class="add_category_link">Add a Category</button>');
var $newLinkLiCategory = $('<li></li>').append($addCategoryButton);

$(document).ready(function() {
    // Get the ul that holds the collection of categories
    $collectionHolderCategory = $('ul.categories');

    // add a delete link to all of the existing tag form li elements
    $collectionHolderCategory.find('li').each(function() {
        addCategoryFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolderCategory.append($newLinkLiCategory);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolderCategory.data('index', $collectionHolderCategory.find(':input').length);

    $addCategoryButton.on('click', function(e) {
        // add a new category form (see next code block)
        addCategoryForm($collectionHolderCategory, $newLinkLiCategory);
    });
});

function addCategoryForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a Category" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    // add a delete link to the new form
    addCategoryFormDeleteLink($newFormLi);
}

function addCategoryFormDeleteLink($categoryFormLi) {
    var $removeFormButton = $('<button type="button">Delete this Category</button>');
    $categoryFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the category form
        $categoryFormLi.remove();
    });
}


var $collectionHolderComponent;

// setup an "add a components" link
var $addComponentButton = $('<button type="button" class="add_component_link">Add a Component</button>');
var $newLinkLiComponent = $('<li></li>').append($addComponentButton);

$(document).ready(function() {
    // Get the ul that holds the collection of components
    $collectionHolderComponent = $('ul.components');

    // add a delete link to all of the existing component form li elements
    $collectionHolderComponent.find('li').each(function() {
        addComponentFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolderComponent.append($newLinkLiComponent);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolderComponent.data('index', $collectionHolderComponent.find('select').length);

    $addComponentButton.on('click', function(e) {

        console.log($collectionHolderComponent);
        // add a new component form (see next code block)
        addComponentForm($collectionHolderComponent, $newLinkLiComponent);
    });
});

function addComponentForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);


    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a component" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    // add a delete link to the new form
    addComponentFormDeleteLink($newFormLi);
}

function addComponentFormDeleteLink($componentFormLi) {
    var $removeFormButton = $('<button type="button">Delete this tag</button>');
    $componentFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the component form
        $componentFormLi.remove();
    });
}