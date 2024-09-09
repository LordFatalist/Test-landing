$(document).ready(function() {
    $('#contactform').submit(function(e) {
        e.preventDefault(); 

        var formData = $(this).serialize(); 
        console.log('Отправка формы:', formData); 

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'), 
            data: formData,
            success: function(response) {
                console.log('Ответ сервера: ', response); 
                try {
                    var data = JSON.parse(response); 

                    if (data.success) {
                        
                        $('#modalMessage').text(data.message);
                        $('#successModal').fadeIn();
                    } else {
                        $('#modalMessage').text(data.message);
                        $('#successModal').fadeIn();
                    }
                } catch (e) {
                    console.error('Ошибка при парсинге ответа: ', e);
                    $('#modalMessage').text('Произошла ошибка при обработке данных.');
                    $('#successModal').fadeIn();
                }
            },
            error: function(xhr, status, error) {
                console.error('Ошибка отправки формы: ', status, error);
                $('#modalMessage').text('Произошла ошибка при отправке формы. Попробуйте снова.');
                $('#successModal').fadeIn();
            }
        });
    });
});
