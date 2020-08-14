$( document ).ready(function() {
    $("#btn").click(
		function(){
			sendAjaxForm('result_form', 'signup_form', 'action_signup.php');
			return false;
		}
	);
});

function sendAjaxForm(result_form, signup_form, url) {
    $.ajax({
        url:     url,
        type:     "POST",
        dataType: "html",
        data: $("#"+signup_form).serialize(),
        success: function(response) {
          result = $.parseJSON(response);
          switch (result.type)
              {
                  case 'loginExist':
                      $('#result_form').html('Логин уже существует');
                  break;
                  case 'noLogin':
                      $('#result_form').html('Логин не указан');
                  break;
                  case 'emailExist':
                      $('#result_form').html('Почта уже существует');
                  break;
                  case 'noEmail':
                      $('#result_form').html('Email не указан');
                  break;
                  case 'filterEmail':
                      $('#result_form').html('Неправильный формат email');
                  break;
                  case 'shotEmail':
                      $('#result_form').html('Email должен быть больше 4х символов');
                  break;
                  case 'noName':
                      $('#result_form').html('Имя не указано');
                  break;
                  case 'noPassword':
                      $('#result_form').html('Пароль не указан');
                  break;
                  case 'noConfirm':
                      $('#result_form').html('Нужно повторить пароль');
                  break;
                  case 'passNoConfirm':
                      $('#result_form').html('Пароли не совпадают');
                  break;
                  case 'success':
                      $('#result_form').html('Регистрация прошла успешно');
                      window.location.href = 'index.php';
                  break;

              }
        },
      	error: function(response) {
              $('#result_form').html('Ошибка. Данные не отправлены.');
      	}
   	});
}
