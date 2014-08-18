/**
 * Created with JetBrains PhpStorm.
 * User: fsalomon
 * Date: 12/12/12
 * Time: 3:15 PM
 * To change this template use File | Settings | File Templates.
 */
var rootURL = "http://10.100.1.110/easy-delivery-services/api";

function updateMessage() {
    $('.message').show();
}
$(document).ready(function () {

    var f = $('form');
    var l = $('#loader'); // loder.gif image
    var b = $('#uploadImageButton'); // upload button
    var p = $('#preview'); // preview area

    b.click(function () {
        // implement with ajaxForm Plugin
        f.ajaxForm({
            beforeSend: function () {
                l.show();
                b.attr('disabled', 'disabled');
                p.fadeOut();
            },
            success: function (e) {
                l.hide();
                f.resetForm();
                b.removeAttr('disabled');
                p.html("<img src='" + e + "' />").fadeIn();
                p.attr('data-image-path', e);
            },
            error: function (e) {
                b.removeAttr('disabled');
                p.html(e).fadeIn();
            }
        });
    });


    verifyOrders();
    var table = $('#example').dataTable();
    var deleteProductButton = $('#deleteProduct');
    var deleteOrderButton = $('#deleteOrder');
    var editProductButton = $('#editProduct');
    var editOrderButton = $('#editOrder');
    var viewOrderButton = $('#viewOrder');
    var viewDetail = $('#viewDetail');
    deleteProductButton.prop('disabled', true);
    deleteOrderButton.prop('disabled', true);
    editProductButton.prop('disabled', true);
    editOrderButton.prop('disabled', true);
    viewOrderButton.prop('disabled', true);
    $('#saveProduct').click(saveProduct);
    $('#saveOrder').click(saveOrder);
    $('#example').find('tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            deleteProductButton.prop('disabled', true);
            deleteOrderButton.prop('disabled', true);
            editProductButton.prop('disabled', true);
            editOrderButton.prop('disabled', true);
            viewOrderButton.prop('disabled', true);
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            deleteProductButton.prop('disabled', false);
            deleteOrderButton.prop('disabled', false);
            editProductButton.prop('disabled', false);
            editOrderButton.prop('disabled', false);
            viewOrderButton.prop('disabled', false);
        }
    });
    deleteProductButton.click(function () {
        if (confirm('Estas seguro?')) {
            confirmDeleteProduct(table.$('tr.selected').attr('id'));
            table.$('tr.selected').remove();
        }
    });
    deleteOrderButton.click(function () {
        if (confirm('Estas seguro?')) {
            confirmDeleteOrder(table.$('tr.selected').attr('id'));
            table.$('tr.selected').remove();
        }
    });
    editProductButton.click(function () {
        window.location = 'editProduct.php?pid=' + table.$('tr.selected').attr('id');
    });
    $('#addProduct').click(function () {
        window.location = 'editProduct.php';
    });
    editOrderButton.click(function () {
        window.location = 'editOrder.php?oid=' + table.$('tr.selected').attr('id');
    });
    viewOrderButton.click(function () {
        window.location = 'viewOrder.php?oid=' + table.$('tr.selected').attr('id');
    });
    viewDetail.click(function () {
        window.location = 'viewOrder.php?oid=' + $('#oid').val();
    });
});
function saveOrder() {
    var status = $('#statusDropdown').find('option:selected').val();
    var oid = $('#oid').val();
    $.ajax({
        type: 'PUT',
        contentType: 'application/json',
        url: rootURL + '/order/',
        dataType: "json",
        data: orderUpdateFormToJSON(status, oid),
        success: function () {
            console.log('Order updated successfully');
        },
        error: function (jqXHR, textStatus) {
            console.log('orderUpdate error: ' + textStatus);
        }
    });
    verifyOrders();
}
function saveProduct() {
    var description = $('#description').val();
    var name = $('#name').val();
    var price = $('#price').val();
    var p = $('#preview');
    var image = p.attr('data-image-path');
    var pid = $('#pid').val();
    var newCid = $('#cidDropDown').find('option:selected').val();
    var newVid = $('#vidDropdown').find('option:selected').val();
    if (validateProduct(description, name, price) && image != '') {
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL + '/products/',
            dataType: "json",
            data: productUpdateFormToJSON(description, name, price, pid, newCid, newVid, image),
            success: function () {
                console.log('product updated successfully');
                alert('Guardado Correctamente');
            },
            error: function (jqXHR, textStatus) {
                console.log('updateUser error: ' + textStatus);
            }
        });
    }
    else {
        $('#saveProduct').parent().addClass('error');
    }
}
function validateProduct(description, name, price) {
    if (name == '') {
        $('#name').addClass('error');
        return false;
    }
    else {
        $('#name').removeClass('error');
    }
    if (description == '') {
        $('#description').addClass('error');
        return false;
    }
    else {
        $('#description').removeClass('error');
    }
    if (price == '') {
        $('#price').addClass('error');
        return false;
    }
    else {
        $('#price').removeClass('error');
    }
    return true;
}
function productUpdateFormToJSON(description, name, price, pid, newCid, newVid, image) {
    return JSON.stringify({
        "pid": pid,
        "name": name,
        "description": description,
        "price": price,
        "cid": newCid,
        "vid": newVid,
        "picture": image
    });
}
function orderUpdateFormToJSON(status, oid) {
    return JSON.stringify({
        "status": status,
        "oid": oid
    });
}
function confirmDeleteProduct(itemId) {
    $.ajax({
        type: 'DELETE',
        url: rootURL + '/products/delete/' + itemId,
        dataType: "json",
        success: function () {
            console.log('Deleted successfully');
        },
        error: function () {
            updateMessage('No hay nuevos pedidos');
        }
    });
}
function confirmDeleteOrder(itemId) {
    $.ajax({
        type: 'DELETE',
        url: rootURL + '/order/delete/' + itemId,
        dataType: "json",
        success: function () {
            console.log('Deleted successfully');
        },
        error: function () {
            updateMessage('No hay nuevos pedidos');
        }
    });
}
function verifyOrders() {
    $.ajax({
        type: 'GET',
        url: rootURL + '/order/newOrderArrived',
        dataType: "json",
        success: function (data) {
            if (data) {
                updateMessage('Nuevo Pedido');
            }
            else {
                $('.message').hide();
            }
        },
        error: function () {
            $('.message').hide();
        }
    });
}
setInterval(function () {
    $.ajax({
        type: 'GET',
        url: rootURL + '/order/newOrderArrived',
        dataType: "json",
        success: function (data) {
            if (data) {
                updateMessage('Nuevo Pedido');
            }
            else {
                $('.message').hide();
            }
        },
        error: function () {
            $('.message').hide();
        }
    });
}, 10000);
