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
      var iChars = "!@#$%^&*()+=-[]\\\';,/{}|\":<>?"+"йцукенгшщзхъфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ";
      for (var i = 0; i < value.length; i++) {
          if (iChars.indexOf(value.charAt(i)) != -1) {
              return false;
          }
      }
      return result;
  }, '');
  $.validator.addMethod('validNamer', function (value) {
      var result = true;
      var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?012789"+"qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNMйцгшщзъфыплджэячиьбюЙЦГШЩЗЪФЫПЛДЖЭЯЧИЬБЮ"+" ";
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
	   vopros:{minlength:"<br> Слишком мало символов",
	    	   required:"<br>Введите вопрос",
	   },
	    datedtp: {required:"<br>Введите дату",
	   },
	     timedtp: {required:"<br>Введите время",
	   },
	     mesto: {required:"<br>Введите место",
	   },
	   otvet:{minlength:"<br> Слишком мало символов",
	   maxlength:"<br> Строго три цифры",
	   	   required:"<br>Введите ответ",
	   },
	  ser1:{minlength:"<br> Строго две буквы",
	   maxlength:"<br> Строго две буквы",
	   validNamer: "<br> Только буквы А, В, Е, К, М, Н, О, Р, С, Т, У и Х.",
	     required:"<br>Введите данные",
	   },
	   nomer1:{minlength:"<br> Строго три цифры",
	   maxlength:"<br> Строго три цифры",
	   digits:"<br> Только три цифры",
	   required:"<br>Введите данные",
	   },
	   nomer2:{minlength:"<br> Строго четыре цифры",
	   maxlength:"<br> Строго четыре цифры",
	   digits:"<br> Только четыре цифры",
	   required:"<br>Введите данные",
	   },
	   postr:{ digits:"<br> Только цифры",
	   required:"<br>Введите данные",
	   },
	    uchast:{ digits:"<br> Только цифры",
	   required:"<br>Введите данные",
	   },
	   },
		   });
    $(this).corner();
	 });