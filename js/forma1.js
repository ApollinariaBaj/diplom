$(document).ready(function(){
 	  $('.datepicker1').datepicker({
	  changeMonth:true,
	  	  changeYear:true,
		  	  yearRange:"1945:2000",
			  dateFormat:"yy-mm-dd",
	  }  
	  );
	    $('.datepicker2').datepicker({
	  changeMonth:true,
	  	  changeYear:true,
		  	  yearRange:"2011:2025",
			  dateFormat:"yy-mm-dd",
	  }  
	  );
	    $('.datepicker').datepicker({
	  changeMonth:true,
	  	  changeYear:true,
		  	  yearRange:"2011:2025",
			  dateFormat:"yy-mm-dd",
	  }  
	  );
	   $.validator.addMethod('validName', function (value) {
      var result = true;
      var iChars = "!@#$%^&*()+=-[]\\\';,/{}|\":<>?"+"����������������������������������������������������������������";
      for (var i = 0; i < value.length; i++) {
          if (iChars.indexOf(value.charAt(i)) != -1) {
              return false;
          }
      }
      return result;
  }, '');
  $.validator.addMethod('validNamer', function (value) {
      var result = true;
      var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?012789"+"qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM����������������������������������������"+" ";
      for (var i = 0; i < value.length; i++) {
          if (iChars.indexOf(value.charAt(i)) != -1) {
              return false;
          }
      }
      return result;
  }, '');

	   $ ('#signup').validate({
	   rules:{
	   vopros: {
	 minlength:5,
	
		   },
	   otvet: {
	   minlength:1,
	
	   },
	    ser1: {
	 minlength:2,
	  maxlength: 2,
	validNamer: true
		   },
	   nomer1: {
	   minlength:3,
	maxlength: 3,
	   digits: true
	   },
	   uchast: {
	   minlength:1,
	maxlength: 3,
	   digits: true
	   },
	    postr: {
	   minlength:1,
	maxlength: 3,
	   digits: true
	   },
	   nomer2: {
	   minlength:4,
	maxlength: 4,
	   digits: true
	   },
	     datedtp: {
	   	maxlength: 11
	  	   },
	   
	 	   },
	   messages:{
	   vopros:{minlength:"<br> ������� ���� ��������",
	    	   required:"<br>������� ������",
	   },
	    datedtp: {required:"<br>������� ����",
	   },
	     timedtp: {required:"<br>������� �����",
	   },
	     mesto: {required:"<br>������� �����",
	   },
	   otvet:{minlength:"<br> ������� ���� ��������",
	   maxlength:"<br> ������ ��� �����",
	   	   required:"<br>������� �����",
	   },
	  ser1:{minlength:"<br> ������ ��� �����",
	   maxlength:"<br> ������ ��� �����",
	   validNamer: "<br> ������ ����� �, �, �, �, �, �, �, �, �, �, � � �.",
	     required:"<br>������� ������",
	   },
	   nomer1:{minlength:"<br> ������ ��� �����",
	   maxlength:"<br> ������ ��� �����",
	   digits:"<br> ������ ��� �����",
	   required:"<br>������� ������",
	   },
	   nomer2:{minlength:"<br> ������ ������ �����",
	   maxlength:"<br> ������ ������ �����",
	   digits:"<br> ������ ������ �����",
	   required:"<br>������� ������",
	   },
	   postr:{ digits:"<br> ������ �����",
	   required:"<br>������� ������",
	   },
	    uchast:{ digits:"<br> ������ �����",
	   required:"<br>������� ������",
	   },
	   },
		   });
    $(this).corner();
	 });