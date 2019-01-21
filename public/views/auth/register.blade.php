<form id="form-control-main" class="login100-form validate-form" role="form" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <span class="login100-form-title p-b-26">

        @lang("Register")
    </span>
    <span class="login100-form-title p-b-48">
        <i class="fa fa-pie-chart"></i>
    </span>

    <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
        <input id="
        email" class="input100" type="email" name="email" value="{{ old('email') }}" required>
        <span class="focus-input100" data-placeholder="Email"></span>
    </div>




    <div class="wrap-input100 validate-input">

        @if($errors->has('name'))
            @component('front.components.error')
                {{ $errors->first('name') }}
            @endcomponent
        @endif
        <input id="name" class="input100" type="text" name="name" value="
{{ old('name') }}" pattern=".{3,10}"
            required>
        <span class="focus-input100" data-placeholder="Name"></span>
    </div>





    @if($errors->has('password'))
        @component('front.components.error')
            {{ $errors->first('password') }}
        @endcomponent
    @endif
    <div class="wrap-input100 validate-input" data-validate="Enter password" title="3 characters minimum">

        {{-- <span class="btn-show-pass">
            <i class="zmdi zmdi-eye"></i>
        </span> --}}
        <input id="password" pattern=".{3,10}" class="input100" type="password" name="password" title="3 characters minimum"
            required>
        <span class="focus-input100" data-placeholder="Password"></span>
    </div>

    <div class="wrap-input100 validate-input" data-validate="Re-enter password">

        {{-- <span class="btn-show-pass">
            <i class="zmdi zmdi-eye"></i>
        </span> --}}
        <input id="password-confirm" pattern=".{3,10}" class="input100" type="password" name="password_confirmation"
            title="3 characters minimum" required>
        <span class="focus-input100" data-placeholder="Re-enter password"></span>
    </div>





    <p class="notice">
        By clicking on register, you agree to
        <a href="#" target="_blank" style="color:#e66587">budget buddy's terms &amp; conditions</a> and
        <a href="#" target="_blank" style="color: #f09458">privacy policy</a>
    </p>

    <div class="container-login100-form-btn">
        <div class="wrap-login100-form-btn">
            <div class="login100-form-bgbtn"></div>
            <button type="submit" class="login100-form-btn">
                Register
            </button>
        </div>
    </div>

</form>
<div class="text-center p-t-15">
    <span class="txt1">
        Have account?
    </span>
    <button id="login-toggle" class="txt2 log-in-toggle">Login</button>
</div>


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