$( document ).ready(function() {
    $("#btn").click(
		function(){
			sendAjaxForm('result_form', 'signin_form', 'action_signin.php');
			return false;
		}
	);
});

function sendAjaxForm(result_form, signin_form, url) {
    $.ajax({
        url:     url,
        type:     "POST",
        dataType: "json",
        data: $("#"+signin_form).serialize(),
        success: function(result) {
          if (result.status) {
            window.location.href = 'profile.php';
          } else {
            $('#result_form').html('Неверный логин или пароль');
          }
        },
      	error: function(response) {
              $('#result_form').html('Ошибка. Данные не отправлены.');
      	}
   	});
}
