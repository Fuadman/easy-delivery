// The root URL for the RESTful services
var rootURL = "http://10.100.1.110/easy-delivery-services/api";

$('#btnTest').click(function() {
//    updateUser();
    addUser();
//    addProductToOrder();
//    login();
//    getOrderProductsByUid();
//    getAllProducts();
//    getUserByUid();
//    getProductByPid();
    return false;
});
// Helper function to serialize all the form fields into a JSON string
function getProductByPid(){
    $.ajax({
        type: 'GET',
        url: rootURL + '/products/3',
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            console.log(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(textStatus);
        }
    });
}
function userUpdateFormToJSON() {
	return JSON.stringify({
		"uid": 5,
		"name": 'Fuadmanasdf',
		"lastname": 'salomonasdf',
		"mail": 'fuadsalo@gmail.com',
		"password": 'control123!',
		"phone": '78887667!'
		});
}
function orderProductsJSON() {
	return JSON.stringify({
		"uid": 4
		});
}
function userFormToJSON() {
	return JSON.stringify({
		"name": 'Fuad1',
		"lastname": 'Salomon1',
		"mail": 'fuadsalo@gmail.com1',
		"password": 'control123!',
		"phone": '78887667'
		});
}
function productOrderFormToJSON() {
	return JSON.stringify({
		"pid": 1,
		"oid": 2,
		"quantity": 10,
		"details": 'addedNormally'
		});
}
function userLoginToJSON() {
	return JSON.stringify({
		"mail": 'fuadsalo@gmail.com',
		"password": 'control123!'
		});
}
function getUserByUid(){
    console.log('getUser');
    $.ajax({
        type: 'GET',
        url: rootURL + '/user/4',
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            console.log(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(textStatus);
        }
    });
}
function getOrderProductsByUid(){
    console.log('getOrderProductsByUid');
    $.ajax({
        type: 'GET',
        url: rootURL + '/order/products/4',
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            console.log(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(textStatus);
        }
    });
}
function getAllProducts(){
    console.log('getallproducts');
    $.ajax({
        type: 'GET',
        url: rootURL + '/products',
        dataType: "json",
        success: function(data, textStatus, jqXHR){
            console.log(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(textStatus);
        }
    });
}
function addUser() {
    console.log('addUser');
    $.ajax({
        type: 'POST',
        contentType: 'application/json',
        url: rootURL+/user/,
        dataType: "json",
        data: userFormToJSON(),
        success: function(data, textStatus, jqXHR){
            console.log(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('addUser error: ' + textStatus);
        }
    });
}
function addProductToOrder() {
    console.log('addProductToOrder');
    $.ajax({
        type: 'POST',
        contentType: 'application/json',
        url: rootURL+'/order/products/',
        dataType: "json",
        data: productOrderFormToJSON(),
        success: function(data, textStatus, jqXHR){
            console.log(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('addUser error: ' + textStatus);
        }
    });
}

function login(){
    console.log('login');
    $.ajax({
        type: 'POST',
        contentType: 'application/json',
        url: rootURL + '/user/login/',
        dataType: "json",
        data: userLoginToJSON(),
        success: function(data, textStatus, jqXHR){
            console.log('correct response');
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('updateUser error: ' + textStatus);
        }
    });
}
function updateUser() {
    console.log('updateUser');
    $.ajax({
        type: 'PUT',
        contentType: 'application/json',
        url: rootURL + '/user/',
        dataType: "json",
        data: userUpdateFormToJSON(),
        success: function(data, textStatus, jqXHR){
            console.log('user updated successfully');
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('updateUser error: ' + textStatus);
        }
    });
}



function test(){
    console.log('test options');
    $.ajax({
        type: 'OPTIONS',
        contentType: 'application/json',
        url: rootURL + '/user/',
        success: function(data, textStatus, jqXHR){
            alert('test successfully');
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('updateUser error: ' + textStatus);
        }
    });
}











// Nothing to delete in initial application state
$('#btnDelete').hide();

// Register listeners
$('#btnSearch').click(function() {
    search($('#searchKey').val());
    return false;
});

// Trigger search when pressing 'Return' on search key input field
$('#searchKey').keypress(function(e){
    if(e.which == 13) {
        search($('#searchKey').val());
        e.preventDefault();
        return false;
    }
});

$('#btnAdd').click(function() {
    newWine();
    return false;
});

$('#btnSave').click(function() {
    if ($('#wineId').val() == '')
        addUser();
    else
        updateWine();
    return false;
});

$('#btnDelete').click(function() {
    deleteWine();
    return false;
});

$('#wineList a').live('click', function() {
    findById($(this).data('identity'));
});

// Replace broken images with generic wine bottle
$("img").error(function(){
    $(this).attr("src", "pics/generic.jpg");

});

function search(searchKey) {
    if (searchKey == '')
        findAll();
    else
        findByName(searchKey);
}

function newWine() {
    $('#btnDelete').hide();
    currentWine = {};
    renderDetails(currentWine); // Display empty form
}

function findAll() {
    console.log('findAll');
    $.ajax({
        type: 'GET',
        url: rootURL,
        dataType: "json", // data type of response
        success: renderList
    });
}

function findByName(searchKey) {
    console.log('findByName: ' + searchKey);
    $.ajax({
        type: 'GET',
        url: rootURL + '/search/' + searchKey,
        dataType: "json",
        success: renderList
    });
}

function findById(id) {
    console.log('findById: ' + id);
    $.ajax({
        type: 'GET',
        url: rootURL + '/' + id,
        dataType: "json",
        success: function(data){
            $('#btnDelete').show();
            console.log('findById success: ' + data.name);
            currentWine = data;
            renderDetails(currentWine);
        }
    });
}


function deleteWine() {
    console.log('deleteWine');
    $.ajax({
        type: 'DELETE',
        url: rootURL + '/' + $('#wineId').val(),
        success: function(data, textStatus, jqXHR){
            alert('Wine deleted successfully');
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('deleteWine error');
        }
    });
}

function renderList(data) {
    // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
    var list = data == null ? [] : (data.wine instanceof Array ? data.wine : [data.wine]);

    $('#wineList li').remove();
    $.each(list, function(index, wine) {
        $('#wineList').append('<li><a href="#" data-identity="' + wine.id + '">'+wine.name+'</a></li>');
    });
}

function renderDetails(wine) {
    $('#wineId').val(wine.id);
    $('#name').val(wine.name);
    $('#grapes').val(wine.grapes);
    $('#country').val(wine.country);
    $('#region').val(wine.region);
    $('#year').val(wine.year);
    $('#pic').attr('src', 'pics/' + wine.picture);
    $('#description').val(wine.description);
}
