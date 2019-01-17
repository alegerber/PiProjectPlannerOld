window.$ = require('jquery');


var $collectionHolderViewTags;

// setup an "add a tag" link
var $addViewTagButton = $('<button type="button" class="add_view_tag_link btn btn-success btn-outline">Add a tag</button>');
var $newLinkLiViewTags = $('<li></li>').append($addViewTagButton);
var $viewTagClass = 'view-tags';

var $collectionHolderImageTags;

// setup an "add a tag" link
var $addImageTagButton = $('<button type="button" class="add_image_tag_link btn btn-success btn-outline">Add a tag</button>');
var $newLinkLiImageTags = $('<li></li>').append($addImageTagButton);
var $imageTagClass = 'image-tags';

var $collectionHolderCategory;

// setup an "add a tag" link
var $addCategoryButton = $('<button type="button" class="add_category_link btn btn-success btn-outline">Add a Category</button>');
var $newLinkLiCategory = $('<li></li>').append($addCategoryButton);
var $categoryClass = 'categories';

var $collectionHolderComponent;

// setup an "add a components" link
var $addComponentButton = $('<button type="button" class="add_component_link btn btn-success btn-outline">Add a Component</button>');
var $newLinkLiComponent = $('<li></li>').append($addComponentButton);
var $componentClass = 'components';

$(document).ready(function(){
    actionEdit($collectionHolderViewTags, $addViewTagButton, $newLinkLiViewTags, $viewTagClass);
    actionEdit($collectionHolderImageTags, $addImageTagButton, $newLinkLiImageTags, $imageTagClass);
    actionEdit($collectionHolderCategory, $addCategoryButton, $newLinkLiCategory, $categoryClass);
    actionEdit($collectionHolderComponent, $addComponentButton, $newLinkLiComponent, $componentClass);
});

function actionEdit($collectionHolder, $addButton, $newLinkLi, $class) {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.'.concat($class));

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li').each(function() {
        addFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addForm($collectionHolder, $newLinkLi);
    });
}

function addForm($collectionHolder, $newLinkLi) {
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
    addFormDeleteLink($newFormLi);
}

function addFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<div class="input-group-append"><button class="btn btn-danger btn-outline" type="button">Remove</button></div>');
    $tagFormLi.children().append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}
