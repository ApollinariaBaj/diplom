$(document).ready(function(){
 	  $('#datepicker1').datepicker({
	  changeMonth:true,
	  	  changeYear:true,
		  	  yearRange:"1945:2000",
			  dateFormat:"yy-mm-dd",
	  }  
	  );
	    $('#datepicker2').datepicker({
	  changeMonth:true,
	  	  changeYear:true,
		  	  yearRange:"1950:2010",
			  dateFormat:"yy-mm-dd",
	  }  
	  );
	    $('#datepicker').datepicker({
	  changeMonth:true,
	  	  changeYear:true,
		  	  yearRange:"1945:2000",
			  dateFormat:"yy-mm-dd",
	  }  
	  );
	});	
	   

function doClear(theText) { if (theText.value == theText.defaultValue) { theText.value = "" } }
function doDefault(theText) { if (theText.value == "") { theText.value = theText.defaultValue } };