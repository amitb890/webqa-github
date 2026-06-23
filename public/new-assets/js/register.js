$( document ).ready(function() {

    function getFieldValue($form, key, fallbackSelector){
        const $field = $form.find(`[data-name="${key}"], [name="${key}"]`).first()
        if($field.length){
            return $field.val()
        }

        return $(fallbackSelector).val()
    }

    function appendError($form, key, error){
        const alert = buildAlertNew(error)
        const $field = $form.find(`[data-name="${key}"], [name="${key}"]`).first()
        const target = $field.length ? $field.parent()[0] : $form[0]

        target.appendChild(alert)
    }

    function authenticateRequest(dataVal, request, form){
        const $form = $(form)

        $.ajax({
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            data: dataVal,     
            url: `/${request}`,  
            success : function(data) {
                window.location = "/dashboard"
            },
            error: function(data){
                const errors = data.responseJSON && data.responseJSON.errors

                if(!errors){
                    appendError($form, "", "Something went wrong. Please try again.")
                    return
                }

                for (const key in errors) {
                    const error = errors[key][0]
                    appendError($form, key, error)
                }
                
            }
        })
    }


    function submitLoginModal(e){
        e.preventDefault()
        clearAlerts()
        const $form = $(e.currentTarget)
        const dataVal = new FormData()
        const email = getFieldValue($form, "email", "#emailLogin")
        const password = getFieldValue($form, "password", "#passwordLogin")
        const remember = $("#remember_me").val()
        dataVal.append("email", email)
        dataVal.append("password", password)
        dataVal.append("remember_me", remember)
        dataVal.append("_token", $('meta[name="csrf-token"]').attr('content'))
        authenticateRequest(dataVal, "login", $form)
    }

    function submitRegisterModal(e){
        e.preventDefault()
        clearAlerts()
        const $form = $(e.currentTarget)
        const dataVal = new FormData()
        const email = getFieldValue($form, "email", "#emailRegister")
        const password = getFieldValue($form, "password", "#passwordRegister")
        const passwordConfirm = getFieldValue($form, "password_confirmation", "#passwordConfirmationRegister")
        const name = getFieldValue($form, "name", "#nameRegister")
        dataVal.append("email", email)
        dataVal.append("name", name)
        dataVal.append("password", password)
        dataVal.append("password_confirmation", passwordConfirm)
        dataVal.append("_token", $('meta[name="csrf-token"]').attr('content'))
        authenticateRequest(dataVal, "register", $form)
    }

    
    $(`[data-auth-form="login"]`).on("submit", function(e){
        submitLoginModal(e)
    })

    $(`[data-auth-form="register"]`).on("submit", function(e){
        submitRegisterModal(e)
    })

    $(".drop-toggle").on("change", function(e){
        const el = e.target.nextElementSibling.children[0]
        if(e.target.checked){
            el.classList.add("active")
        }else{
            el.classList.remove("active")
        }
    })


    $('[data-auth-form="login"]').on('keypress', function(event) {
        if (event.which === 13) { // 13 is the Enter key
            event.preventDefault(); // Prevent the default action
            $(this).submit(); // Submit the form
        }
    });


    const $passwordInput = $('.passwordRegister');
    const $togglePassword = $('.togglePassword');
    $togglePassword.on('click', function() {
        if($passwordInput.attr('type') == 'password') {
            $passwordInput.attr('type', 'text');
        }else{
            $passwordInput.attr('type', 'password');
        }
    });

    const $passwordInputConfirm = $('#passwordConfirmationRegister');
    const $togglePasswordConfirm = $('#toggleConfirmPassword');
    $togglePasswordConfirm.on('click', function() {
        if($passwordInputConfirm.attr('type') == 'password') {
            $passwordInputConfirm.attr('type', 'text');
        }else{
            $passwordInputConfirm.attr('type', 'password');
        }
    });

    $(document).on('click', '.login_forgetPass', function(e) {
        const href = $(this).attr('href');
        if (!href) return;

        const $form = $(this).closest('form');
        let email = '';

        if ($form.length) {
            const $emailInput = $form.find('input[name="email"], input[data-name="email"], input[type="email"]').first();
            email = ($emailInput.val() || '').trim();
        }

        if (!email) {
            email = ($('#emailLogin').val() || $('#email').val() || '').trim();
        }

        if (email && typeof validateEmail === 'function' && validateEmail(email)) {
            e.preventDefault();
            const baseUrl = href.split('?')[0];
            window.location.href = baseUrl + '?email=' + encodeURIComponent(email);
        }
    });
})
