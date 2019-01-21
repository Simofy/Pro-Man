@extends('pro.layout')
@section('javascript')
<script>
    var projects = {!!$projects!!};
    console.log(projects)

    $().ready(function () {
        $("#new-project").click(function (e) {
            let div = document.createElement('div');
            let input = document.createElement('input');
            input.type = 'text';
            input.classList.add("project-container-input");

            function simpleControl(obj) {
                let a = document.createElement('a');
                a.href = 'app/new/' + obj.value;
                console.log(a.href)
                $.ajax({
                    url: a.href,
                    success: function (data) {
                        let a_ = document.createElement('a');
                        a_.innerText = obj.value;
                        a_.href = 'project/' + obj.value;
                        obj.parentNode.appendChild(a_);
                        
                        obj.parentNode.removeChild(obj);
                        console.log(obj)
                    }
                })
            }

            $(input).focusout(function (e) {
                if (this.value == "") {
                    this.parentNode.parentNode.removeChild(this.parentNode);
                } else {
                    simpleControl(this)
                }
            })
            input.addEventListener("keyup", function (e) {
                if (e.key === "Enter") {
                    if (this.value == "") {
                        this.parentNode.parentNode.removeChild(this.parentNode);
                    } else {
                        simpleControl(this);

                    }
                }
            });
            div.appendChild(input);
            $(div).insertBefore($("#last-button-camp"))
            input.focus();
            //$("#ref-to-add").insertBefore(input, $("#last-button-camp"));
            //console.log($("#ref-to-add").insertBefore(input, $("#last-button-camp")))
        })
    })
</script>
@endsection
@section('main')
<div class="project-container">
    <div>

        <h3 style="text-align: center">
            Projects:
        </h3>
    </div>
    <div id="ref-to-add">
        @foreach($projects as $project)
            <div><a href="app/project/{{ $project->name }}">{{ $project->name }}</a></div>
        @endforeach
        <div id="last-button-camp">
            <div><button style="width: 100%; text-align: center; border: none" id="new-project">
                    <div>New project</div>
                </button></div>
        </div>
    </div>
</div>
@endsection