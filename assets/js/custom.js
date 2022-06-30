"use strict";
var urllink = UrlLink;
let dropdown = $('#province-dropdown');
dropdown.empty();
dropdown.append('<option selected="true" disabled>Choose State/Province</option>');
dropdown.prop('selectedIndex', 0);
const url = urllink+'/assets/jsons/provinces.json';
$.getJSON(url, function(data) {
    $.each(data, function(key, entry) {
        dropdown.append($('<option></option>').attr('value', entry.key).text(entry.name));
    })
});
$('#province-dropdown').on('change', function() {
    $('#cities-dropdown').show();
    let dropdowncity = $('#cities-dropdown');
    dropdowncity.empty();
    dropdowncity.append('<option selected="true" disabled>Choose City</option>');
    dropdowncity.prop('selectedIndex', 0);
    const urlcity =  urllink+'/assets/jsons/cities.json';
    var data = this.value;
    $.getJSON(urlcity, function(datacity) {
        $.each(datacity, function(key, entry) {
            if (entry.province == data) {
                dropdowncity.append($('<option></option>').attr('value', entry.abbreviation).text(entry.name));
            }
        })
    });
});
$('#customer').click(function(e) {
    $('#processregistration').html('<i class="fa fa-spinner fa-spin"></i> Processing Form</font>');
    $('#customer').hide();
    e.preventDefault();
    setTimeout(function() {
        window.location.href = "?form&type=customer";
    }, 2000);
});
$('#retailer').click(function(e) {
    $('#process-registration-retailer').html('<i class="fa fa-spinner fa-spin"></i> Processing Form</font>');
    $('#retailer').hide();
    e.preventDefault();
    setTimeout(function() {
        window.location.href = "?form&type=retailer";
    }, 2000);
});
$('#distributor').click(function(e) {
    $('#process-registration-distributor').html('<i class="fa fa-spinner fa-spin"></i> Processing Form</font>');
    $('#distributor').hide();
    e.preventDefault();
    setTimeout(function() {
        window.location.href = "?form&type=distributor";
    }, 2000);
});
$('#driver').click(function(e) {
    $('#process-registration-driver').html('<i class="fa fa-spinner fa-spin"></i> Processing Form</font>');
    $('#driver').hide();
    e.preventDefault();
    setTimeout(function() {
        window.location.href = "?form&type=delivery";
    }, 2000);
});
$('#retailer-linkorder').click(function(e) {
    e.preventDefault();
    var code = $(this).attr('data-code');
    setTimeout(function() {
        window.location.href = "?processorder&code=" + code;
    }, 1000);
});
$('#retailer-processorder').click(function(e) {
    $('#processingorder').html('<i class="fa fa-spinner fa-spin"></i> Processing Orders .. </font>');
    $('#retailer-processorder').hide();
    var code = $(this).attr('data-code');
    e.preventDefault();
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: urllink + '/retailerprocessorder',
            data: {
                'code': code,
            },
            success: function(data) {
                $('#processingorder').html('<center><font size="3"><i class="fa fa-check"></i> Please Wait .. </font></center>');
                setTimeout(function() {
                    window.location.href = "?processorder&code=" + code;
                }, 3000);
            }
        });
    }, 3000);
});
$('#processcheckout').submit(function(e) {
    $('#process-checkout-order').html('<center><font size="5" color="blue"><i class="fa fa-spinner fa-spin"></i> Processing Checkout Order ..</font></center>');
    $('.btn-checkout').hide();
    e.preventDefault();
    var address   = $('#address').val();
    var staddress = $('#staddress').val();
    var province  = $('#province-dropdown').val();
    var city      = $('#cities-dropdown').val();
    var zipcode   = $('#zipcode').val();
    var transcode = $('#transcode').val();
    var userid    = $('#userid').val();
    var specialinstructions = $('#specialinstructions').val();
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: urllink + '/checkoutorder',
            data: {
                'customerID': userid,
                'address': address,
                'streetaddress': staddress,
                'province': province,
                'city': city,
                'zipcode': zipcode,
                'transcode': transcode,
                'specialinstructions': specialinstructions,
            },
            success: function(data) {
                $('#process-checkout-order').html('<center><font size="5" color="green"><i class="fa fa-check"></i> Processing Payment Form.. Please Wait .. </font></center>');
                setTimeout(function() {
                    window.location.href = "checkouts/payment";
                }, 3000);
            }
        });
    }, 3000);
});
$('#processpayment').submit(function(e) {
    $('#process-payment-order').html('<center><font size="5px" color="blue"><i class="fa fa-spinner fa-spin"></i> Processing Payment ..</font></center>');
    $('.btn-checkout').hide();
    e.preventDefault();
    var paymentoption = $('#paymentoption').val();
    var paymentname = $('#paymentname').val();
    var paycode = $('#paycode').val();
    var amount = $('#amount').val();
    var transcode = $('#transcode').val();
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: urllink + '/processpayment',
            data: {
                'transcode': transcode,
                'paymentMethod': paymentoption,
                'amount': amount,
                'payName': paymentname,
                'payCode': paycode,
            },
            success: function(data) {
                $('#process-payment-order').html('<center><font size="5" color="green"><i class="fa fa-check"></i> Payment Success! Thank You! </font></center>');
                setTimeout(function() {
                    window.location.href = "success";
                }, 3000);
            }
        });
    }, 3000);
});