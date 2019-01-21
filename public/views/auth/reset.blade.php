<form id="form-control-main" class="login100-form validate-form" role="form" method="POST" action="reset">
        {{ csrf_field() }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <span class="login100-form-title p-b-26">

        @lang("Reset")
    </span>
 


    <div class="wrap-input100 validate-input">

        <input id="name" class="input100" type="text" name="name" value="
{{ old('name') }}" pattern=".{3,10}"
            required>



    <div class="container-login100-form-btn">
        <div class="wrap-login100-form-btn">
            <div class="login100-form-bgbtn"></div>
            <button type="submit" class="login100-form-btn">
                Reset
            </button>
        </div>
    </div>

</form>


{{-- <script>
        $("#form-control-main").submit(function (e) {
            let data_array = $(this).serializeArray();
            let data_json = {};
            data_array.forEach(node => {
                //if (node.name != "_token")
                    data_json[node.name] = node.value;
            });
            data_json.email = "node.value";
            console.log(data_json)
    
            e.preventDefault();
            $.ajax({
                url: "/login",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: "application/x-www-form-urlencoded",
                data: $(this).serialize(),
                success: function (data) {
                    window.location.reload()
                },
                error: function (msg) {
                    if(msg.responseJSON.errors.log[0] != undefined){
                        failedAttempt("#form-control-main", msg.responseJSON.errors.log[0]);
                    }else{
                        failedAttempt("#form-control-main", "Unknown error");
                    }
                }
            })
        })
    </script> --}}
{{-- _________________ --}}