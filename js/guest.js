function get_code() {
    var phone = $('#register_form input[name="phone"]').val().substr(1);
    phone = '61' + phone;
    $('#register_form #code_button').html('正在发送');
    $('#register_form #code_button').prop('disabled', true);
    $.ajax({
        url: '/daigou/send_code',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'phone': phone
        },
        dataType: 'json',
        success: function (response) {
            alert('已发送');
            $('#register_form #code_button').prop('disabled', true);
            $('#register_form #code_button').html('已发送');
        },
        error: function (error) {
            if (error.responseText == '\"registered\"') {
                alert('该号码已被注册');
            }
            $('#register_form #code_button').removeAttr('disabled');
            $('#register_form #code_button').html('请重试');

        }
    });
}