let globalCogIdCounter = 0;
class Cog {
    constructor(x, y, size, deg, color) {
        this.x = x;
        this.y = y;
        this.size = size;
        this.deg = deg;
        this.color = color;
        this.id = globalCogIdCounter++;
        this.cog = document.createElement("i");
        this.cog.style.cssText = cog_style(x, y, this.size, this.color, this.deg);
        this.cog.id = "cog_" + this.id;
        this.cog.className = "fas fa-cog";
        document.body.appendChild(this.cog);
    }
}
let cog_style = function (x, y, size, color, deg) {
    let string = "position:fixed;";
    string += "left:" + x + "px;";
    string += "top:" + y + "px;";
    //string += "width:" + w + "px;";
    //string += "height:" + h + "px;";
    string += "text-align:center;";
    string += "color:" + color + ";";
    string += "vertical-align: middle;";
    //string += "line-height:" + h + "px;";
    string += "font-size:" + (size) + "px;";
    string += "transform : rotate(" + deg + "deg);";
    //string += "background:rgba(0,0,0,0)";
    return string;
}
let star_style = function (x, y, size) {
    let string = "position:fixed;";
    string += "left:" + x + "px;";
    string += "top:" + y + "px;";
    string += "width:" + size + "px;";
    string += "height:" + size + "px;";
    return string;
}
let global_star_id = 0;
class Star {
    constructor(x, y, size, layer) {
        this.x = x;
        this.y = y;
        this.size = size;
        this.layer = layer;
        this.speed = 1 + this.layer + Math.random() * 5;
        this.id = global_star_id++;
        this.star = document.createElement("i");
        this.star.style.cssText = star_style(x, y, this.size, this.color, this.deg);
        this.star.id = "star_" + this.id;
        this.star.className = "star-dot star-" + layer;
        let translate = -($(window).scrollTop() / this.speed);
        let top = parseInt(this.star.style.top.substr(0, this.star.style.top.length - 3));
        this.offset = Math.floor((translate + top) / (window.outerHeight + 20)) * (window.outerHeight + 20) * -1;
        this.star.style.transform = 'translateY(' + (this.offset + translate) + 'px)';

        $("#background")[0].appendChild(this.star);
        this.g = e => {
            let translate = -($(window).scrollTop() / this.speed);
            let top = parseInt(this.star.style.top.substr(0, this.star.style.top.length - 3));
            this.star.style.transform = 'translateY(' + (this.offset + translate) + 'px)';

            if (top + (translate + this.offset) < -20) {
                this.offset += window.outerHeight + 20;

            }
            if ((top + translate + this.offset) > (window.outerHeight - 20)) {
                this.offset -= (window.outerHeight + 20);
            }

        }
        document.addEventListener('scroll', this.g, true);
    }
    update() {

    }
}

$().ready(function () {
            let scr_width = window.outerWidth;
            let scr_height = window.outerHeight;
            let star_array = [];
            for (let i = 0; i < 100; i++) {
                let star = new Star(Math.random() * scr_width, Math.random() * scr_height, 1 + Math.random() * (4 - i % 3), i % 3);
                star_array.push(star);
            }

            $('.pure-menu-horizontal').mousewheel(function (e, delta) {
                let old_scrollLeft = this.scrollLeft;
                this.scrollLeft -= (delta * 15);
                if (this.scrollLeft == 0) {
                    $("#navbar-dir-left").css("visibility", "hidden");
                } else {
                    $("#navbar-dir-left").css("visibility", "visible");
                }
                if (old_scrollLeft == this.scrollLeft && this.scrollLeft != 0) {
                    $("#navbar-dir-right").css("visibility", "hidden");
                } else {
                    $("#navbar-dir-right").css("visibility", "visible");
                }
                e.preventDefault();
            });
            $('.pure-menu-horizontal').scroll(function (e) {
                var maxScrollLeft = $(this).get(0).scrollWidth - $(this).get(0).clientWidth
                if (this.scrollLeft == 0) {
                    $("#navbar-dir-left").css("visibility", "hidden");
                } else {
                    $("#navbar-dir-left").css("visibility", "visible");
                }
                if (this.scrollLeft == maxScrollLeft) {
                    $("#navbar-dir-right").css("visibility", "hidden");
                } else {
                    $("#navbar-dir-right").css("visibility", "visible");
                }
            });



            let search_animation_flag = false;
            $('#btn-search-trigger').click(function name(e) {
                if (!search_animation_flag) {
                    search_animation_flag = true;
                    $("#search-input-field").css("width", "200px");
                    $('#focus-search-input').focus();
                    $('#focus-search-input').get(0).focus();
                } else {
                    //search_animation_flag = false;
                    //$("#search-input-field").css("width", "0");
                }

                e.preventDefault();
            });
            $('#search-input-field').focusout(function name(e) {
                search_animation_flag = false;
                $("#search-input-field").css("width", "0");
            })
            //let classAdded_sideburns = false;
            // document.addEventListener('scroll', function (e) {
            //     if ($(window).scrollTop() > 0) {
            //         if (!classAdded_sideburns) {
            //             console.log($(window).scrollTop());
            //             classAdded_sideburns = true;
            //             $("#top-tags-section").addClass( "animate-sideburn" );
            //             $("#top-posts-section").addClass( "animate-sideburn" );
            //             $(".hide-table").css("display", "none");
            //         }


            //     } else {
            //         console.log($(window).scrollTop());
            //         classAdded_sideburns = false;
            //         $("#top-tags-section").removeClass( "animate-sideburn" );
            //         $("#top-posts-section").removeClass( "animate-sideburn" );
            //         $(".hide-table").css("display", "block");
            //     }

            // }, true);


            //log-in-out

            function loginButton(e) {
                $("#log-in-out").css("display", "block");
                void $("#log-in-out")[0].offsetWidth;
                $("#log-in-out").addClass("animation-color-fade");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/view/login',
                    context: document.body,
                    type: "POST",
                    success: function (data) {
                        $("#log-in-out-animate").html(data);
                        void $("#log-in-out")[0].offsetWidth;
                        $("#log-in-out-animate").addClass("animation-dropdown");
                        $("#log-in-out-animate").click(function (e) {
                            toggle_log_in = true;
                        });
                        $("#register-toggle").click(registerButton);
                        $('.input100').each(refreshInput);
                    },
                    error: function (msg) {
                        console.log("_______")
                        console.log(msg)
                        console.log("_______")
                    }
                }) //-- end ajax

            };
            $(".log-in-toggle").click(loginButton);
            function registerButton(e) {
                void $("#log-in-out")[0].offsetWidth;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/view/register',
                    context: document.body,
                    type: "POST",
                    success: function (data) {
                        $("#log-in-out-animate").html(data);
                        void $("#log-in-out")[0].offsetWidth;
                        $("#log-in-out-animate").addClass("animation-dropdown");
                        $("#log-in-out-animate").click(function (e) {
                            toggle_log_in = true;
                        });
                        $("#login-toggle").click(loginButton);
                        $('.input100').each(refreshInput);
                    },
                    error: function (msg) {
                        console.log("_______")
                        console.log(msg)
                        console.log("_______")
                    }
                })

            };
            $("#log-in-out").click(function (e) {
                if (!toggle_log_in) {
                    $("#log-in-out").css("display", "none");
                    $("#log-in-out").removeClass("animation-color-fade");
                    $("#log-in-out-animate").html("");
                    $("#log-in-out-animate").removeClass("animation-dropdown");
                }
                toggle_log_in = false;
            });

            let toggle_log_in = false;

            $("#container-register").click(function (e) {
                toggle_log_in = true;
            });

            function refreshInput() {
                $(this).on('blur', function () {
                    if ($(this).val().trim() != "") {
                        $(this).addClass('has-val');
                    } else {
                        $(this).removeClass('has-val');
                    }
                })
            }




        });
        function failedAttempt(element, error){

            $(element).find('input[type="text"], input[type="password"]').addClass('background-error');
            $(element).find('.error-field').css('display', 'block');
            $(element).find('.error-field').text(error);
            $(element).find('input[type="text"], input[type="password"]').focus(function(e) {
                $(this).removeClass('background-error');
            })

        }
        /*==================================================================
        [ Validate ]*/
        /*
        var input = $('.validate-input .input100');

        $('.validate-form').on('submit',function(){
            var check = true;

            for(var i=0; i<input.length; i++) {
                if(validate(input[i]) == false){
                    showValidate(input[i]);
                    check=false;
                }
            }

            return check;
        });


        $('.validate-form .input100').each(function(){
            $(this).focus(function(){
               hideValidate(this);
            });
        });

        function validate (input) {
            if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
                if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                    return false;
                }
            }
            else {
                if($(input).val().trim() == ''){
                    return false;
                }
            }
        }

        function showValidate(input) {
            var thisAlert = $(input).parent();

            $(thisAlert).addClass('alert-validate');
        }

        function hideValidate(input) {
            var thisAlert = $(input).parent();

            $(thisAlert).removeClass('alert-validate');
        }
        */