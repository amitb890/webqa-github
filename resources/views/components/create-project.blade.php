<script>
    $( document ).ready(function(){
        const route = `{{ \Route::currentRouteName() }}`;
        console.log(route)
        $("#createProject").on( "click", function() {
            clearAlerts()
            const name = $("#name")
            const homepage = $("#homepage")
            const urlsList = $("#urlsList")

            $.ajax({
                url : `/createProject`,
                type : 'POST',
                data: {
                    "name": name.val(),
                    "homepage": homepage.val(),
                    "urlsList": urlsList.val(),
                    "route": route, 
                    "_method": 'POST',
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },       
                success : function(data) {
                    if(data.status === 0){
                        validate(data)
                    }else{
                        if(route === "projects.create"){
                            console.log(data)
                            clearValues([name, homepage, urlsList])
                            displayAlert(data)
                            scrollToTop()
                        }else{
                            window.location = "/dashboard"
                        }
                    }
                }
            });
        });
    });
</script>