$( document ).ready(function() {

    function authenticateRequest(dataVal, request, element){
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
                const errors = data.responseJSON.errors
                for (const key in errors) {
                    const error = errors[key][0]
                    const alert = buildAlertNew(error)
                    $(`#${element} [data-name=${key}]`)[0].parentElement.appendChild(alert)
                }
                
            }
        })
    }


    function submitLoginModal(e){
        clearAlerts()
        const dataVal = new FormData()
        const email = $("#emailLogin").val()
        const password = $("#passwordLogin").val()
        const remember = $("#remember_me").val()
        dataVal.append("email", email)
        dataVal.append("password", password)
        dataVal.append("remember_me", remember)
        dataVal.append("_token", $('meta[name="csrf-token"]').attr('content'))
        authenticateRequest(dataVal, "login", "loginModal")
        e.preventDefault()
    }

    function submitRegisterModal(e){
        clearAlerts()
        const dataVal = new FormData()
        const email = $("#emailRegister").val()
        const password = $("#passwordRegister").val()
        const passwordConfirm = $("#passwordConfirmationRegister").val()
        const name = $("#nameRegister").val()
        dataVal.append("email", email)
        dataVal.append("name", name)
        dataVal.append("password", password)
        dataVal.append("password_confirmation", passwordConfirm)
        dataVal.append("_token", $('meta[name="csrf-token"]').attr('content'))
        authenticateRequest(dataVal, "register", "registerModal")
        e.preventDefault()
    }

    
    $("#loginModal").on("submit", function(e){
        submitLoginModal(e)
    })

    $("#registerModal").on("submit", function(e){
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


    $('#loginModal').on('keypress', function(event) {
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
})
