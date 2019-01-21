<form ref='uploadForm' id="form-control-main" class="login100-form validate-form" role="form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
    {{-- <form id="form-control-main" ref='uploadForm' class="login100-form validate-form" role="form"> --}}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <span class="login100-form-title p-b-26">
        PRO-MAN <br />LOGIN
    </span>
    <span class="login100-form-title p-b-48">
        <i class="fa fa-pie-chart"></i>
    </span>
    <div class="error-field"></div>
    <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
        <input class="input100 " id="log" type="text" name="log" value="{{ old('log') }}"
            required> {{--
        <input type="text" id="email" name="email" required> --}}
        <span class="focus-input100" data-placeholder="
@lang('Email')"></span>
    </div>

    <div class="
            wrap-input100 validate-input" data-validate="Enter password">
            <input class="input100" id="password" type="password" name="password" required> {{-- <input class="input100"
                type="password" id="pass" name="pass" required> --}}
            <span class="focus-input100" data-placeholder="@lang('Password')"></span>
    </div>
    <label class="
                txt1">
        <input type="checkbox" name="remember"
            {{ old('remember') ? 'checked' : '' }}>
        <span class="label-text">
            @lang('Remember me')</span>
    </label>
    <div class="container-login100-form-btn">
        <div class="wrap-login100-form-btn">
            <div class="login100-form-bgbtn"></div>
            {{-- <input class="login100-form-btn" type="submit" value=" @lang('Login')"> --}}
            <button type="submit" class="login100-form-btn">
                    @lang('Login')
                </button>

            {{-- <button class="login100-form-btn" type="submit">
                Login
            </button> --}}
        </div>
    </div>

</form>
<div class="text-center p-t-15">
    <label class="txt1">
        <a href="{{ route('password.request') }}">

            @lang('Forgot Your Password?')
        </a><br>
        <button id="register-toggle">

            @lang('Not registered?')
        </button>
    </label> {{-- <span class="txt1">
        Don’t have an account?
    </span>

    <form action="/signup" method="post">
        <button type="submit" class="txt2">Sign Up</button>
    </form> --}}
</div>
<script>
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
</script>