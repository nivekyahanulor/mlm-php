"use strict";
$("[data-checkboxes]").each(function () {
  var me = $(this),
    group = me.data('checkboxes'),
    role = me.data('checkbox-role');

  me.change(function () {
    var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
      checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
      dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
      total = all.length,
      checked_length = checked.length;

    if (role == 'dad') {
      if (me.is(':checked')) {
        all.prop('checked', true);
      } else {
        all.prop('checked', false);
      }
    } else {
      if (checked_length >= total) {
        dad.prop('checked', true);
      } else {
        dad.prop('checked', false);
      }
    }
  });
});

// $("#genealogy-table").dataTable();

$("#genealogy-table").dataTable({
    "order": [[ 2, "asc" ]], //or asc 
});

$("#table-2").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0, 2, 3] }
  ],
  order: [[1, "asc"]] //column indexes is zero based

});
$('#save-stage').DataTable({
  "scrollX": true,
  stateSave: true
});
$('#tableExport').DataTable({
  dom: 'Bfrtip',
  buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
  ]
});
$("#tablecbu").dataTable({
  order: [[2, "desc"]] //column indexes is zero based
});
$("#tablesavings").dataTable({
  order: [[1, "desc"]] //column indexes is zero based
});
$("#tableloan").dataTable();
$("#tablemembersavings").dataTable();
$('#retailerinvetory').dataTable();
$('#retailerrequest').dataTable();
$('#sales-report-data').dataTable();

//** MEMBERS TABLE DATA **//
$(document).ready(function () {
  var url   = UrlLink + 'administrator/api/get_members_data';
  var table = $('#members-table').DataTable({
    'ajax': {
      type: 'POST',
      'url': url,
      'data': function (d) {
        console.log(d.order);
        return JSON.stringify( d );
      },
      "dataSrc": function (json) {
       $("#mydata").val(json.recordsTotal);
       return json.data;
    	}
    }, "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ] 
  });
  $('#members-table tbody').on( 'click', 'button', function () {
        var action = this.id;
		var data = table.row( $(this).parents('tr') ).data();
        if (action=='btn-members-data'){
			$("#memberid").val(data[0]);
			$("#name").html(data[1]);
			$("#email").html(data[2]);
			$('#membersinfo').trigger('click');

		}
    } );
 

});
//** ADMIN USER TABLE DATA **//
$(document).ready(function () {
  var url   =  UrlLink + 'administrator/api/get_admin_data';
  var table = $('#admin-data').DataTable({
    'ajax': {
      type: 'POST',
      'url': url,
      'data': function (d) {
        console.log(d.order);
        return JSON.stringify( d );
      },
      "dataSrc": function (json) {
       $("#mydata").val(json.recordsTotal);
       return json.data;
    	}
    }, "columnDefs": [
            {
                "targets": [ 0 , 1 , 2 , 3 , 4],
                "visible": false,
                "searchable": false
            }
        ] 
  });
  $('#admin-data tbody').on( 'click', 'button', function () {
        var action = this.id;
		var data = table.row( $(this).parents('tr') ).data();
        if (action=='btn-admin-update-data'){
			$("#adminID").val(data[0]);
			$("#firstname").val(data[1]);
			$("#lastname").val(data[2]);
			$("#username").val(data[4]);
			$("#password").val(data[3]);
			$('#updateadmininfo').trigger('click');
		} if (action=='btn-admin-delete'){
			$("#adminID").val(data[0]);
			$("#adminID").val(data[0]);
			$('#deleteadmininfo').trigger('click');
		}
    } );
 

});

//** WITHDRAWAL REPORTS TABLE DATA **//
$(document).ready(function () {
  var url   =  UrlLink + 'administrator/api/get_withdrawal_reports_data';
  var table = $('#withdrawal-reports-data').DataTable({
    'ajax': {
      type: 'POST',
      'url': url,
      'data': function (d) {
        console.log(d.order);
        return JSON.stringify( d );
      },
      "dataSrc": function (json) {
       $("#mydata").val(json.recordsTotal);
       return json.data;
    	}
    }, "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ] 
  });
  $('#withdrawal-reports-data tbody').on( 'click', 'button', function () {
        var action = this.id;
		var data = table.row( $(this).parents('tr') ).data();
        if (action=='btn-view-data'){
			  window.location.href = UrlLink +  "administrator/withdrawal/process/"+data[0];
		}
    } );
 

});

//** WITHDRAWAL REQUEST TABLE DATA **//
$(document).ready(function () {
  var url   =  UrlLink + 'administrator/api/get_withdrawal_request_data';
  var table = $('#withdrawal-request-data').DataTable({
    'ajax': {
      type: 'POST',
      'url': url,
      'data': function (d) {
        console.log(d.order);
        return JSON.stringify( d );
      },
      "dataSrc": function (json) {
       $("#mydata").val(json.recordsTotal);
       return json.data;
    	}
    }, "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ] 
  });
  $('#withdrawal-request-data tbody').on( 'click', 'button', function () {
        var action = this.id;
		var data = table.row( $(this).parents('tr') ).data();
        if (action=='btn-process-data'){
			  window.location.href = UrlLink +  "administrator/withdrawal/process/"+data[0];
		}
    } );
 

});

//** PRODUCT TABLE DATA **//
$(document).ready(function () {
  var url   =  UrlLink + 'administrator/api/get_product_data';
  var tableprod = $('#product-data').DataTable({
    'ajax': {
      type: 'POST',
      'url': url,
      'data': function (d) {
        console.log(d.order);
        return JSON.stringify( d );
        },
		"dataSrc": function (json) {
		$("#mydata").val(json.recordsTotal);
        return json.data;
    	}
		},

		'rowCallback': function(row, data, index){
			if(data[4] == ''){
				$(row).css('background-color', 'red');
			}
		}, "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            }
        ] 
		
  });
	
  $('#product-data tbody').on( 'click', 'button', function () {
        var action = this.id;
		var data = tableprod.row( $(this).parents('tr') ).data();
        if (action=='btn-product-data'){
			window.open("productdetails?product="+encodeURI(data[1]), '_blank');
		} if (action=='btn-product-delete'){
			$("#productID").val(data[1]);
			$('#deleteproductinfo').trigger('click');
		}
    } );

  var url   =  UrlLink + 'administrator/api/get_package_data';
  var table = $('#package-data').DataTable({
    'ajax': {
      type: 'POST',
      'url': url,
      'data': function (d) {
        console.log(d.order);
        return JSON.stringify( d );
        },
    "dataSrc": function (json) {
    $("#mydata").val(json.recordsTotal);
        return json.data;
      }
    },

    'rowCallback': function(row, data, index){
      if(data[4] == ''){
        $(row).css('background-color', 'red');
      }
    }, "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            }
        ] 
    
  });
  
  $('#package-data tbody').on( 'click', 'button', function () {
        var action = this.id;
    var data = table.row( $(this).parents('tr') ).data();
        if (action=='btn-package-data'){
      window.open("packagedetails?package="+encodeURI(data[1]), '_blank');
    } if (action=='btn-package-delete'){
      $("#packageID").val(data[1]);
      $('#deletepackageinfo').trigger('click');
    }
    } );
 

});

//** PAYMENT TABLE DATA **//
$(document).ready(function () {
	
  var url   =  UrlLink + 'administrator/api/get_payment_data';
  var url_package_payment   =  UrlLink + 'administrator/api/get_package_payment_data';
  var url_package_upgrade   =  UrlLink + 'administrator/api/get_package_upgrade_data';
  
  var table = $('#payment-data').DataTable({
    'ajax': {
      type: 'POST',
      'url': url,
      'data': function (d) {
        console.log(d.order);
        return JSON.stringify( d );
        },
		"dataSrc": function (json) {
		$("#mydata").val(json.recordsTotal);
        return json.data;
    	}
		},

		'rowCallback': function(row, data, index){
			if(data[4] == ''){
				$(row).css('background-color', 'red');
			}
		}, "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ] 
		
  });
	
  $('#payment-data tbody').on( 'click', 'button', function () {
        var action = this.id;
		var data = table.row( $(this).parents('tr') ).data();
        if (action=='btn-payment-data'){
			window.open("payments/paymentdetails/"+encodeURI(data[0]));
		} else if (action=='btn-approve-order'){
			$("#code").val(data[0]);
			$('#approveorder').trigger('click');
		} else if (action=='btn-decline-order'){
			$("#codes").val(data[0]);
			$('#declineorder').trigger('click');
		}
    } );
 
 var table1 = $('#payment-package-data').DataTable({
    'ajax': {
      type: 'POST',
      'url': url_package_payment,
      'data': function (d) {
        // console.log(d.order);
        return JSON.stringify( d );
        },
    "dataSrc": function (json) {
    $("#mydata").val(json.recordsTotal);
        return json.data;
      }
    },

    'rowCallback': function(row, data, index){
      if(data[4] == ''){
        $(row).css('background-color', 'red');
      }
    }, "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ] 
    
  });
  
  $('#payment-package-data tbody').on( 'click', 'button', function () {
    var action = this.id;
    var data = table1.row( $(this).parents('tr') ).data();
    if (action=='btn-approve-packagepayment'){
      window.location = "../payments/paymentpackagedetails/"+encodeURI(data[0]);
    } else if (action=='btn-approve-packagepayment'){
      $("#code").val(data[0]);
      $('#approvepackagepayment').trigger('click');
    } else if (action=='btn-decline-packagepayment'){
      $("#codes").val(data[0]);
      $('#declinepackagepayment').trigger('click');
    }
    } );
 


// ** UPGRADES **//
 var table11 = $('#payment-upgrade-data').DataTable({
    'ajax': {
      type: 'POST',
      'url': url_package_upgrade,
      'data': function (d) {
        // console.log(d.order);
        return JSON.stringify( d );
        },
    "dataSrc": function (json) {
    $("#mydata").val(json.recordsTotal);
        return json.data;
      }
    },

    'rowCallback': function(row, data, index){
      if(data[4] == ''){
        $(row).css('background-color', 'red');
      }
    }, "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ] 
    
  });
  
  
    $('#payment-upgrade-data tbody').on( 'click', 'button', function () {
		var action = this.id;
		var data = table11.row( $(this).parents('tr') ).data();
		if (action=='btn-approve-upgrade'){
		  window.location = "../payments/paymentpackageupgrades/"+encodeURI(data[0]);
		} else if (action=='btn-approve-upgrade'){
		  $("#code").val(data[0]);
		  $('#approvepackagepayment').trigger('click');
		} 
    } );
 


  

});



//** EXPENSES TABLE DATA **//
$(document).ready(function () {
  var url   =  UrlLink + 'administrator/api/get_expenses_data';
  var table = $('#expenses-data').DataTable({
    'ajax': {
      type: 'POST',
      'url': url,
      'data': function (d) {
        console.log(d.order);
        return JSON.stringify( d );
        },
		"dataSrc": function (json) {
		$("#mydata").val(json.recordsTotal);
        return json.data;
    	}
		},

		'rowCallback': function(row, data, index){
			if(data[4] == ''){
				$(row).css('background-color', 'red');
			}
		}, "columnDefs": [
            {
                "targets": [ 0 ,1 ],
                "visible": false,
                "searchable": false
            }
        ] 
		
  });
	
  $('#expenses-data tbody').on( 'click', 'button', function () {
        var action = this.id;
		var data = table.row( $(this).parents('tr') ).data();
        if (action=='btn-expenses-data'){
			$("#expensesIDs").val(data[0]);
			$("#expeamount").val(data[1]);
			$("#expedetails").val(data[2]);
			$("#expedate").val(data[6]);
			$("#expeby").val(data[5]);
			$("#quantity").val(data[3]);

			$('#updateexpenses').trigger('click');
		} if (action=='btn-expenses-delete'){
			$("#expensesID").val(data[0]);
			$('#deleteexpenses').trigger('click');
		}
    } );
 

});


//** PAYMENT METHOD TABLE DATA **//
$(document).ready(function () {
  var url   =  UrlLink +'administrator/api/get_paymentmethod_data';
  var table = $('#paymethod-data').DataTable({
    'ajax': {
      type: 'POST',
      'url': url,
      'data': function (d) {
        console.log(d.order);
        return JSON.stringify( d );
        },
		"dataSrc": function (json) {
		$("#mydata").val(json.recordsTotal);
        return json.data;
    	}
		},

		'rowCallback': function(row, data, index){
			if(data[4] == ''){
				$(row).css('background-color', 'red');
			}
		}, "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ] 
		
  });
	
  $('#paymethod-data tbody').on( 'click', 'button', function () {
        var action = this.id;
		var data = table.row( $(this).parents('tr') ).data();
        if (action=='btn-edit-data'){
			$("#paymentmethod").val(data[1]);
			$(".summernote-simple").summernote('code',data[2]); //add text to summernote
			$("#payid").val(data[0]);
			$('#editpaymedthodinfo').trigger('click');
		} if (action=='btn-delete-data'){
			$("#payid").val(data[0]);
			$('#deletepaymedthodinfo').trigger('click');
		}
    } );
 

});


