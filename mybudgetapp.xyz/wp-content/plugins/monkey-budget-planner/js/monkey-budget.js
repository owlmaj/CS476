var budget_calculator = (function($){
	

	//Set the default incomes and outgoings here
	var defaultsObj = {
		'income':{
			1:{name:"Pay (after tax)",freq:52,value:0},
			2:{name:"Partners take home pay",freq:4,value:0},
			3:{name:"Bonuses/overtime",freq:26,value:0},
			4:{name:"Income from savings and investments",freq:1,value:0},
			5:{name:"Child support received ",freq:12,value:0}
		},'outgoings':{
			1:{name:"Electricity",freq:4,value:0},
			2:{name:"Gas",freq:4,value:0},
			3:{name:"Water",freq:4,value:0},
			4:{name:"Internet",freq:4,value:0},
			5:{name:"Telephone",freq:4,value:0},
			6:{name:"Car Insurance",freq:1,value:0}
		}
	};




	
	//Functions to store and retrieve objects from localstorage
	function ls_store(name,o){
		localStorage.setItem(name, JSON.stringify(o));			
	};
	function ls_read(name){
		return JSON.parse(localStorage.getItem(name));
	};
	

	function set_defaults(){
		ls_store('monkey_expenses',defaultsObj);
		expensesObj = ls_read('monkey_expenses'); 
	}
	//If our localstroage items are empty let's store the defaults
	if(ls_read('monkey_expenses')==null){
		set_defaults();
	}
	var expensesObj = ls_read('monkey_expenses'); 
	//Reset the localstorage if the clear link is clicked
	$('.reset-localstorage').click(function(e) {
		e.preventDefault();
        set_defaults();
		display_tables();
    });	
    

	//Set our frequencies object
	var frequenciesObj = {52:"Weekly", 26:"Fortnightly", 12:"Monthly", 4:"Quarterly", 1:"Annually"}; 
	
	function display_percents(element_class, value, percent){
		$('#totals '+element_class+' > h3 > span').html(format_currency(value));
		$('#totals '+element_class+' .progress-bar').html('<span class="percent">' + percent.toFixed(2)+'%</span>')
		if(percent<0){
			$('#totals '+element_class+' .progress-bar').css('width',(percent*-1)+'%').addClass('progress-bar-danger');
		}else{
			$('#totals '+element_class+' .progress-bar').css('width',percent+'%').removeClass('progress-bar-danger');	
		}
	}




	function calc_totals(){
		var income_total = 0;
		var outgoings_total = 0;
		for(var i in expensesObj['income']){
			var e = expensesObj['income'][i];
			income_total = income_total+e.value * e.freq;

			console.log(income_total);
		}
		for(var i in expensesObj['outgoings']){
			var e = expensesObj['outgoings'][i];
			outgoings_total = outgoings_total+e.value * e.freq;
		}	
		var outgoings_percent = (outgoings_total/income_total)*100;
		var income_percent = 100-outgoings_percent;
		savings_total = parseInt(income_total - outgoings_total,10);
		var savings_percentage = (savings_total/income_total)*100;
		display_percents('.total-income', income_total, income_percent);if(isNaN(income_percent)){display_percents('.total-income', 0, 0)}
		display_percents('.total-outgoings', outgoings_total, outgoings_percent);if(isNaN(outgoings_percent)){display_percents('.total-outgoings', 0, 0)}
		display_percents('.total-savings', savings_total, savings_percentage);if(isNaN(savings_percentage)){display_percents('.total-savings', 0, 0)}
	}
	//Function to calculate the incomes or outgoings
	function calc_costs(){
		for(var type in expensesObj){
			var total = 0;
			$('.budget-calculator #'+type+' tbody tr').each(function() {
				var amount = $(this).find('.amount').val();
				var freq = $(this).find('.freq').val();
				var single_total = amount*freq;
				var row_id = $(this).attr('data-id');
				if(!isNaN(single_total)){
					total = total + single_total;
					$('#'+type+' tbody tr[data-id="'+row_id+'"]').find('.single-total').html(''+format_currency(single_total));
					$('#'+type+' tfoot .total').html('Total yearly '+type+': '+format_currency(total));
					expensesObj[type][row_id].value=amount;
					expensesObj[type][row_id].freq=freq;
					ls_store('monkey_expenses',expensesObj)
				}
			});
		}
		calc_totals();
		
	}
	//Display the incomes/outgoings objects as a table
	function display_tables(){
		for(var type in expensesObj){
			var d = '';
			for(var i in expensesObj[type]){
				d+='<tr data-id="'+i+'" data-type="'+type+'">'+
				'<td>'+expensesObj[type][i].name+':</td>'+
				'<td><select class="freq">';
				for(var f in frequenciesObj){
					var selected = '';
					if(expensesObj[type][i].freq == f){selected = ' selected';}
					d+='<option value="'+f+'" '+selected+'>'+frequenciesObj[f]+'</option>';
				}
				d+='</select></td>'+
				'<td><input class="amount" type="text" maxlength="8" value="'+expensesObj[type][i].value+'"/></td>'+
				'<td><span class="single-total">$0</span></td>'+
				'<td><span class="remove-row"><i class="glyphicon glyphicon-trash"></i></span></td>'+
				'</tr>';
			}
			$('.budget-calculator #'+type+' tbody').html(d);		
		}
		calc_costs();		
	}


	$('.nav-tabs a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	})
	//text value get's changed
	$('.budget-calculator').on('keyup','tbody .amount',function(e) {
		var type= $(this).closest('.tab-pane').attr('id')
		calc_costs()
    });
	//Frequency gets changed
	$('.budget-calculator').on('change','tbody .freq',function(e) {
		var type= $(this).closest('.tab-pane').attr('id')
		calc_costs()
    });
	//Add a row button get's clicked - launch the bootstrap modal
	$('.budget-calculator').on('click','.add-row',function(e) {
		var type= $(this).attr('data-type');
		$('#budget-calculator-add-row .btn-add-row').attr('data-type',type)
		$('#budget-calculator-add-row label').text('Enter name for '+type)
		$('#budget-calculator-add-row').modal('toggle').slideDown();
	});
	//Add a new row
	$('#budget-calculator-add-row .btn-add-row').click(function(e) {
		var val = $('#add-row-name').val();
		var type= $(this).attr('data-type');
       if(val.length>0){
		   //Lets add the row
		   for(var i in expensesObj[type]){
			   var new_index = parseInt(i,10)+1;
		   }
		   expensesObj[type][new_index] = {name:val,freq:12,value:0}
		   ls_store('monkey_expenses',expensesObj);//Store the object
		   display_tables();
		   calc_costs();
		   $('#add-row-name').val('')
		   $('#budget-calculator-add-row').modal('hide');
		}else{
			console.info('No value Entered so will not save!');
		}
    });
	//Remove a row
	$('.budget-calculator').on('click','.remove-row',function(e) {
		var type= $(this).closest('tr').attr('data-type');
		var id= $(this).closest('tr').attr('data-id');
		delete expensesObj[type][id];
		ls_store('monkey_expenses',expensesObj);//Store the object
		display_tables();
		calc_costs();		
	})
	//Display the objects as HTML in the forms
	display_tables();
	

	function sticktothetop() {

		$(document).ready(function () {
		  var window_top = $(window).scrollTop();
		  var top = $('.stick-here').offset().top;
		  if (window_top > top) {
			  $('.stickThis').addClass('stick');
			  $('.stick-here').height($('#stickThis').outerHeight());
			  $('.reset-button-text').hide();
		  } else {
			  $('.stickThis').removeClass('stick');
			  $('.stick-here').height(0);
			  $('.reset-button-text').show();
		  }
		});		 
	  }

	
	
	
$(document).ready(function () {

	$(function() {
        $(window).scroll(sticktothetop);
        sticktothetop();
    });	


    var monkey_expenses = JSON.parse(localStorage.getItem("monkey_expenses.income[0]"));
    console.log(monkey_expenses)
    function printData() {
        var income = document.getElementById("income");
        var outgoings = document.getElementById("outgoings");
        var totals = document.getElementById("totals");
        
        newWin = window.open("");
        newWin.document.write(income.outerHTML);
        newWin.document.write(outgoings.outerHTML);
        newWin.document.write(totals.outerHTML);

        newWin.print();
        newWin.close();
	}

	function prepareDataArray(budget_type) {
		var table = document.getElementById(budget_type);
		var amount_list = table.getElementsByClassName("amount");
		var row_list = table.getElementsByTagName("TR");
		var category_list = [];
		
		for(var i = 1; i <= amount_list.length; i++){
			var temp = row_list[i].getElementsByTagName("TD");
			category_list.push(temp[0].textContent);
		}

		var array = {};

		for (var i = 0; i < amount_list.length; i++) {
			array[category_list[i]] = parseInt(amount_list[i].value);
		}

		return array;
	}

	function ajaxFunction() {
		var dataArray = prepareDataArray("income");
		var incomejson = JSON.stringify(dataArray);
		var dataArray = prepareDataArray("outgoings");
		var outgoingsjson = JSON.stringify(dataArray);
		
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				income_data: incomejson,
				outgoings_data: outgoingsjson,
				action: 'update_budget_action'
			}
		});	
		
		// FIX ME
		//
		function redirFunc(){
			window.location = "https://www.mybudgetapp.xyz/";	
		}
		
		setTimeout(redirFunc, 1000);
	}
	
	function alertfunc() {
		alert("Invalid character on form fields detected");
	}
	
	function validateAmounts(){
		var v_table = document.getElementById("income");
		var v_amount_list = v_table.getElementsByClassName("amount");
		
		for (var i = 0; i < v_amount_list.length; i++) {
			if(isNaN(v_amount_list[i].value)){
				return false;
			}
		}
		
		v_table = document.getElementById("outgoings");
		v_amount_list = v_table.getElementsByClassName("amount");
		
		for (var i = 0; i < v_amount_list.length; i++) {
			if(isNaN(v_amount_list[i].value)){
				return false;
			}
		}
		
		return true;
	}
	
    $('.submitbutton').on('click', function () {
		//validate func first
		if(validateAmounts()){
			ajaxFunction();
		}
		else{
			alertfunc();
		}
    });	
	
	/*
    $('.printbutton').on('click', function () {
		printData();
    });

    $('.toggleMail').on('click', function () {
        $("#emailMokeyForm").slideToggle({direction: "up"}, 400);
    });
	*/
   

    
    //Filter Button Functions
    $('#weekly').on('click', function () {
	    var onethirdMargin = parseInt(savings_total) / 52;
		document.querySelector('.total-savings span').innerHTML = '£'+parseInt(onethirdMargin)+' a Week';
	    console.log(onethirdMargin);
    });
    
    $('#fortnightly').on('click', function () {
	    var onethirdMargin = parseInt(savings_total) / 26;
		document.querySelector('.total-savings span').innerHTML = '£'+parseInt(onethirdMargin)+' a Fortnight';
	    console.log(onethirdMargin);
    });
    
    $('#monthly').on('click', function () {
	    var onethirdMargin = parseInt(savings_total) / 12;
		document.querySelector('.total-savings span').innerHTML = '£'+parseInt(onethirdMargin)+' a Month';
	    console.log(onethirdMargin);
    });
    
    $('#annually').on('click', function () {
	    var onethirdMargin = parseInt(savings_total) / 1;
		document.querySelector('.total-savings span').innerHTML = '£'+parseInt(onethirdMargin)+' a Year';
	    console.log(onethirdMargin);
    });

    
    
    
    
    // tab buttons extra
    $('.viewOutgoings').on('click', function () {

	    $('a[href="#outgoings"]').tab('show');
	    console.log('out');
    });
    
    $('.viewIncome').on('click', function () {
	    $('a[href="#income"]').tab('show');
	    console.log('in');
    });
    
    
    //form submit and add the form data
    $("#monkeyForm").submit(function() { //notice submit event
		console.log('form submitted');
			$("#data").val($("#monkeyTable").html()); //notice html function instead of text();
		});
    
    
    
        
});
	        
	        	
})(jQuery);






