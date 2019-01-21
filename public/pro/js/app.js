function divide(str, ats, elm) {
    let subIndex = str.indexOf('/');
    if (subIndex != -1) {
        let cat = str.substr(0, subIndex);
        let subStr = str.substr(subIndex + 1);
        if (subStr.indexOf('/') == -1 && ats[cat] == undefined) {
            ats[cat] = [];
        } else if (ats[cat] == undefined)
            ats[cat] = {};
        divide(subStr, ats[cat], elm);
    } else {
        if (ats == {})
            ats = [];
        ats.push({
            name: str,
            elm: elm
        });
    }
}

const copyToClipboard = str => {
    navigator.clipboard.writeText(str)
    // const el = document.createElement('textarea');
    // el.value = str;
    // document.body.appendChild(el);
    // el.select();
    // document.execCommand('copy');
    // document.body.removeChild(el);
};

function resize_ui(target, new_width, new_height) {
    var $wrapper = $(target).resizable('widget'),
        $element = $wrapper.find('.ui-resizable'),
        dx = new_width,
        dy = new_height;

    $element.width(new_width);
    $wrapper.width(dx);
    $element.height(new_height);
    $wrapper.height(dy);
}

function position_ui(target, new_x, new_y) {
    var $wrapper = $(target).resizable('widget'),
        $element = $wrapper.find('.ui-resizable');
    $element.css("left", new_x);
    $wrapper.css("left", new_x);
    $element.css("top", new_y);
    $wrapper.css("top", new_y);
}
let folderTree = [];
if(folder.length < 1){
    divide(projectName + "/", folderTree, undefined);
}else{

    folder.forEach(element => {
        divide(projectName + "/" + element.path, folderTree, element);
    });
}
let editorRefrence = [];
let editorControl = [];
let test_id = 0;
let test_zIndex = 10;

function toolbarButton(options, handle) {
    let button = document.createElement('button');
    button.options = options;

    if (options.name != undefined)
        button.name = options.name;

    if (options.id != undefined)
        button.id = options.id;

    if (options.innerHTML != undefined)
        button.innerHTML = options.innerHTML;

    button.onclick = handle;
    button.classList.add('textEditor-button');
    return button;
}
class textEditor {
    focus() {
        if (this.main_container.style.display == "none") {
            $(this.main_container).toggle("fade", {
                percent: 50
            }, 320);
        }
        this.editor.focus();
    }
    save() {
        console.log(this)

        $.ajax({
            url: this.href.replace("project", "save"),
            data: {
                data: this.editor.getValue(),
                self: this.obj != undefined ? this.obj.id : -1
            },
            success: function (data) {
                console.log(data)

            }
        })
    }
    constructor(href, file, parent, created = false, obj = undefined) {
        this.obj = obj;
        this.href = href;
        //this.file = file;
        this.name = href.substr(href.lastIndexOf('/') + 1);
        this.type = this.name.substr(this.name.indexOf('.') + 1);
        if (this.type == 'js') this.type = "javascript";
        this.parent = parent;
        this.originalSize = {
            width: 0,
            height: 0,
            left: 0,
            top: 0,
            fullscreen: false
        };
        this.main_container = document.createElement("div");
        this.main_container.classList.add('textEditor-containter', 'fullscreen-editor');
        this.main_container.id = test_id++;

        let text_editor = document.createElement("div");
        text_editor.id = href;
        text_editor.classList.add('editor');
        text_editor.textContent = file;
        let text_editor_name = document.createElement("div");
        text_editor_name.textContent = this.name;
        text_editor_name.classList.add('textEditor-name');

        let button_holder = document.createElement("div");
        button_holder.classList.add('button-holder');

        button_holder.append(toolbarButton({
            innerHTML: "&times;",
            editor: this
        }, function (e) {
            let ref = this.options.editor;
            if (ref.editor.flags.edited) {

                if (confirm("File is unsaved, you still want to close?")) {
                    if (confirm("Save your file before leaving?")) {
                        // code here for save then leave (Yes)
                        ref.save();
                        ref.main_container.parentNode.removeChild(ref.main_container);
                        ref.footer_button.parentNode.removeChild(ref.footer_button);
                        delete(editorControl[ref.href]);
                        editorControl[ref.href] = undefined;
                    } else {
                        //code here for no save but leave (No)
                        //editorControl
                        ref.main_container.parentNode.removeChild(ref.main_container);
                        ref.footer_button.parentNode.removeChild(ref.footer_button);
                        console.log(ref.footer_button)
                        delete(editorControl[ref.href]);
                        editorControl[ref.href] = undefined;
                    }
                } else {
                    //code here for don't leave (Cancel)
                }
            } else {
                ref.main_container.parentNode.removeChild(ref.main_container);
                ref.footer_button.parentNode.removeChild(ref.footer_button);
                delete(editorControl[ref.href]);
                editorControl[ref.href] = undefined;
            }
            //console.log(this.options.editor.editor.flags.edited)
        }));
        button_holder.append(toolbarButton({
            name: this.main_container.id,
            innerHTML: "&#10697;"
        }, function (e) {
            $("#" + this.name)[0].classList.remove('left-editor-fullscreen', 'right-editor-fullscreen', 'top-editor-fullscreen', 'bottom-editor-fullscreen');
            $("#" + this.name).toggleClass("fullscreen-editor");
            editorRefrence[this.name].editor.resize();
        }));
        button_holder.append(toolbarButton({
            name: this.main_container.id,
            innerHTML: "&#10515;"
        }, function (e) {
            $("#" + this.name).toggle("fade", {
                percent: 50
            }, 320);
        }));




        this.main_container.append(button_holder);
        this.main_container.append(text_editor);
        this.main_container.append(text_editor_name);
        parent.appendChild(this.main_container);

        $(this.main_container).draggable({
            cancel: ".textEditor-containter>div",
            //stack: "#app-main-container div",
            snap: true,
            snapMode: "outer",
            //containment: "parent",
            opacity: 0.7,
            start: function (event, ui) {
                this.style.zIndex = test_zIndex++;
                let ref = $(this);
                if (ref.hasClass('fullscreen-editor') || ref.hasClass('right-editor-fullscreen') ||
                    ref.hasClass('left-editor-fullscreen') ||
                    ref.hasClass('top-editor-fullscreen') ||
                    ref.hasClass('bottom-editor-fullscreen')) {
                    this.name = "start";
                }
            },
            drag: function (event, ui) {
                this.focus();
                if (this.name == "start") {
                    this.classList.remove('fullscreen-editor');
                    //this.name = "";
                    ui.position.left = event.clientX - ui.helper.width() / 2;
                    ui.position.top = event.clientY - 11;
                    //ui.helper.css({top: event.clientY, left: event.clientX});
                }
                if (event.clientX > document.documentElement.clientWidth - 22) {
                    this.classList.add('right-editor-fullscreen');
                } else {
                    this.classList.remove('right-editor-fullscreen');
                }
                if (event.clientX < 22) {
                    this.classList.add('left-editor-fullscreen');
                } else {
                    this.classList.remove('left-editor-fullscreen');
                }


                if (event.clientY > document.documentElement.clientHeight - 22) {
                    this.classList.add('bottom-editor-fullscreen');
                } else {
                    this.classList.remove('bottom-editor-fullscreen');
                }
                if (event.clientY < 22) {
                    this.classList.add('top-editor-fullscreen');
                } else {
                    this.classList.remove('top-editor-fullscreen');
                }



                // if (this.classList.contains('fullscreen-editor')) {
                //     this.classList.remove('fullscreen-editor');
                //     // ui.position = editorRefrence[this.id].origin;
                //     // ui.offset = editorRefrence[this.id].origin;
                //     // ui.originalPosition = editorRefrence[this.id].origin;
                //     // this.style.left = "820px";
                //     // this.style.top = "820px";
                //     // do some stuff
                // }
                //
                //ui.position = editorRefrence[this.id].origin;
            },
            stop: function (event, ui) {
                editorRefrence[this.id].focus();
                this.name = "";
            }
        });
        $(this.main_container).resizable({
            helper: "ui-resize-helper",
            minWidth: 22 * 4,
            containment: "body",
            minHeight: 22 * 4,
            stop: function (event, ui) {
                editorRefrence[this.id].editor.resize();
                editorRefrence[this.id].editor.focus();
            }
        });
        $(this.main_container).focusin(function () {
            this.style.zIndex = test_zIndex++;
            this.classList.add("container-focus");
            document.getElementById("button_" + this.id).classList.add("container-focus");

        });
        $(this.main_container).focusout(function () {
            this.classList.remove("container-focus");
            document.getElementById("button_" + this.id).classList.remove("container-focus");
        });
        $(this.main_container).click(function () {
            editorRefrence[this.id].editor.focus();
        });
        this.editor = ace.edit(href);
        editorRefrence[this.main_container.id] = this;
        this.editor.setTheme("ace/theme/monokai");

        this.editor.session.setMode("ace/mode/" + this.type);
        this.editor.setAutoScrollEditorIntoView(true);
        //this.editor.setValue(file, -1);

        this.footer_button = document.createElement('li');
        this.footer_button.classList.add('footer-button');
        this.footer_button.innerText = this.name;
        this.footer_button.id = "button_" + this.main_container.id;
        this.footer_button.name = this.main_container.id;

        $(this.footer_button).click(function (e) {
            let ref = editorRefrence[this.name];
            if (ref.main_container.style.display == "none") {
                $(ref.main_container).toggle("fade", {
                    percent: 50
                }, 320);
            }
            editorRefrence[this.name].editor.focus();
            e.preventDefault();
        });
        $(this.footer_button).dblclick(function (e) {
            $("#" + this.name).toggle("fade", {
                percent: 50
            }, 320);
            //editorRefrence[this.name].editor.focus();
            e.preventDefault();
        });
        //footer_li.appendChild(footer_button);
        document.getElementById('footer-sortable').appendChild(this.footer_button);

        // <button class="footer-button">
        //     <div>Logout</div>
        // </button>


        $(this.main_container).dblclick(function (e) {
            if (e.target == this) {
                this.classList.remove('left-editor-fullscreen', 'right-editor-fullscreen', 'top-editor-fullscreen', 'bottom-editor-fullscreen');
                $(this).toggleClass("fullscreen-editor");
                editorRefrence[this.id].editor.resize();
            }
        })
        this.editor.components = {
            "header-text": text_editor_name
        }
        this.editor.flags = {
            edited: created
        }
        this.editor.on("change", function (e) {
            let ref = this[0]();
            ref.flags.edited = true;
            ref.components["header-text"].classList.add("editor-change")
            //console.log(this[0]());
        });
        // $(this.main_container).dblclick(function (e) {

        // });


        this.focus();

    }
}
let activeEditors = [];

function contextmenu_tree_file(e, obj) {
    let obsolete = document.createElement("div");

    let main = document.createElement("div");
    obsolete.id = "contextmenu";
    obsolete.classList.add("contextmenu-tree-container");
    main.classList.add("contextmenu-tree");
    let background = document.createElement("div");
    background.classList.add("contextmenu-tree-background");
    background.name = obsolete.id;
    main.addEventListener('contextmenu', function (e) {
        e.preventDefault()
    });
    background.addEventListener('contextmenu', function (e) {
        let elm = document.getElementById(this.name);
        elm.parentNode.removeChild(elm);
        e.preventDefault()
    });
    $(background).click(function (e) {
        let elm = document.getElementById(this.name);
        elm.parentNode.removeChild(elm);
    });
    main.style.left = e.clientX + "px";
    main.style.top = e.clientY + "px";
    let copy_button = document.createElement("button");
    copy_button.classList.add("contextmenu-button");
    copy_button.innerText = "Copy";
    let copyPath_button = document.createElement("button");
    copyPath_button.classList.add("contextmenu-button");
    copyPath_button.innerText = "Copy Path";
    let rename_button = document.createElement("button");
    rename_button.classList.add("contextmenu-button");
    rename_button.innerText = "Rename"
    let delete_button = document.createElement("button");
    delete_button.classList.add("contextmenu-button");
    delete_button.innerText = "Delete"

    let seperator = document.createElement("div");
    seperator.classList.add("contextmenu-button-seperator");
    delete_button.onclick = function (e) {
        let elm = document.getElementById("contextmenu");
        elm.parentNode.removeChild(elm);
        obj.parentNode.removeChild(obj);
        $.ajax({
            url: obj.href.replace("project", "delete"),
            data: {
                id: obj.uniqueObject != undefined ? obj.uniqueObject.id : -1
            },
            success: function (data) {}
        })
    }
    rename_button.onclick = function (e) {
        let elm = document.getElementById("contextmenu");
        elm.parentNode.removeChild(elm);
        let ref = obj.parentNode;
        obj.style.display = 'none';
        let input = document.createElement('input');
        //let li_el = document.createElement('li');
        input.type = 'text';
        input.value = obj.innerText;
        input.originalValue = obj.innerText;
        input.name = this.name;

        input.classList.add("input-tree-editor");

        function simpleControl(obj) {
            let ref = obj.uniqueObject != undefined ? obj.uniqueObject.path : "";
            let path = ref.substr(0, ref.lastIndexOf('/') + 1);
            $.ajax({
                url: obj.href.replace("project", "rename"),
                data: {
                    data: path + input.value,
                    self: obj.uniqueObject != undefined ? obj.uniqueObject.id : -1
                },
                success: function (data) {
                    obj.style.display = 'block';
                }
            })
        }
        $(input).focusout(function (e) {
            if (this.value == this.originalValue) {
                this.parentNode.removeChild(this);
                obj.style.display = 'block';
            } else {
                simpleControl(obj);
                obj.text = this.value;
                this.parentNode.removeChild(this);
                obj.style.display = 'block';
                console.log(obj)
            }
        })
        input.addEventListener("keyup", function (e) {
            if (e.key === "Enter") {
                if (this.value == this.originalValue) {
                    this.parentNode.removeChild(this);
                    obj.style.display = 'block';
                } else {
                    simpleControl(obj);
                    obj.text = this.value;
                    this.parentNode.removeChild(this);
                    obj.style.display = 'block';
                    console.log(obj)
                }
            }
        });
        ref.append(input);

        input.focus();

        e.preventDefault();
        //li_el.append(input);

        // let parent = document.getElementById(this.name).parentNode.childNodes;
        // for (let i = 0; i < parent.length; i++) {
        //     if (parent[i].nodeName == "UL") {
        //         parent[i].insertBefore(input, parent[i].firstChild);
        //         break;
        //     }
        // }

    }
    copyPath_button.onclick = function (e) {
        let ref = obj.uniqueObject;
        if (ref != undefined) {
            copyToClipboard(projectName + '/' + ref.path)
            let elm = document.getElementById("contextmenu");
            elm.parentNode.removeChild(elm);
        } else {
            copyToClipboard(obj.href)
            let elm = document.getElementById("contextmenu");
            elm.parentNode.removeChild(elm);
        }
    }
    copy_button.onclick = function (e) {
        let ref = obj.uniqueObject;
        if (ref != undefined) {
            $.ajax({
                url: obj.href,
                success: function (data) {
                    let elm = document.getElementById("contextmenu");
                    elm.parentNode.removeChild(elm);
                    copyToClipboard(data)
                }
            })
        }
    }

    main.append(copy_button);
    main.append(copyPath_button);
    main.append(seperator.cloneNode(true));
    main.append(rename_button);
    main.append(delete_button);
    obsolete.append(background);
    obsolete.append(main);
    document.body.append(obsolete);
}

function contextmenu_tree_container(e, obj) {
    let obsolete = document.createElement("div");

    let main = document.createElement("div");
    obsolete.id = "contextmenu";
    obsolete.classList.add("contextmenu-tree-container");
    main.classList.add("contextmenu-tree");
    let background = document.createElement("div");
    background.classList.add("contextmenu-tree-background");
    background.name = obsolete.id;
    main.addEventListener('contextmenu', function (e) {
        e.preventDefault()
    });
    background.addEventListener('contextmenu', function (e) {
        let elm = document.getElementById(this.name);
        elm.parentNode.removeChild(elm);
        e.preventDefault()
    });
    $(background).click(function (e) {
        let elm = document.getElementById(this.name);
        elm.parentNode.removeChild(elm);
    });
    main.style.left = e.clientX + "px";
    main.style.top = e.clientY + "px";
    let newFile_button = document.createElement("button");
    newFile_button.classList.add("contextmenu-button");
    newFile_button.innerText = "New File";
    let newFolder_button = document.createElement("button");
    newFolder_button.classList.add("contextmenu-button");
    newFolder_button.innerText = "New Folder";
    let find_button = document.createElement("button");
    find_button.classList.add("contextmenu-button");
    find_button.innerText = "Find in Folder";
    find_button.disabled = true;
    let copy_button = document.createElement("button");
    copy_button.classList.add("contextmenu-button");
    copy_button.innerText = "Copy";
    let paste_button = document.createElement("button");
    paste_button.classList.add("contextmenu-button");
    paste_button.innerText = "Paste";
    paste_button.disabled = true;
    let copyPath_button = document.createElement("button");
    copyPath_button.classList.add("contextmenu-button");
    copyPath_button.innerText = "Copy Path";
    let rename_button = document.createElement("button");
    rename_button.classList.add("contextmenu-button");
    rename_button.innerText = "Rename"
    rename_button.disabled = true;
    let delete_button = document.createElement("button");
    delete_button.classList.add("contextmenu-button");
    delete_button.innerText = "Delete"
    delete_button.disabled = true;
    newFile_button.name = obj.id;
    newFolder_button.name = obj.id;
    newFile_button.onclick = treeEditor;
    newFolder_button.onclick = treeEditor;
    let seperator = document.createElement("div");
    seperator.classList.add("contextmenu-button-seperator");

    main.append(newFile_button);
    main.append(newFolder_button);
    main.append(seperator.cloneNode(true));
    main.append(find_button);
    main.append(seperator.cloneNode(true));
    main.append(copy_button);
    main.append(paste_button);
    main.append(copyPath_button);
    main.append(seperator.cloneNode(true));
    main.append(rename_button);
    main.append(delete_button);
    obsolete.append(background);
    obsolete.append(main);
    document.body.append(obsolete);
}

function treeControl(file, name = []) {
    let arr = name.slice(0, 1);
    if (arr.length > 0) {

        return treeControl(file[arr[0]], name.slice(1, name.length))
    } else {
        return file;
    }
}

function treeEditor(e) {
    let elm = document.getElementById("contextmenu");
    elm.parentNode.removeChild(elm);

    let input = document.createElement('input');
    //let li_el = document.createElement('li');
    input.type = 'text';
    input.value = '';
    input.name = this.name;
    input.classList.add("input-tree-editor");
    //li_el.append(input);

    let parent = document.getElementById(this.name).parentNode.childNodes;
    for (let i = 0; i < parent.length; i++) {
        if (parent[i].nodeName == "UL") {
            parent[i].insertBefore(input, parent[i].firstChild);
            break;
        }
    }

    input.focus();

    function simpleControl(elm) {
        let ref = document.getElementById(elm.name);
        let toEdit = treeControl(folderTree, ref.name.split('/'));
        if (elm.value.split('.').length > 1) {
            let isFile = true;
            for (let i = 0; i < toEdit.length; i++) {
                if (toEdit[i] == elm.value) {
                    isFile = false;
                    break;
                }
            }
            if (isFile) {
                toEdit.push(elm.value);
                //elm.parentNode.append(createTreeFile(ref.name, elm.value));
                //elm.parentNode.removeChild(elm);
                let test = createTreeFile(ref.name, {
                    name: elm.value,
                    elm: undefined
                });
                elm.parentNode.insertBefore(
                    test,
                    elm.parentNode.firstChild);
                elm.parentNode.removeChild(elm);
                let a_dump = document.createElement('a');

                a_dump.href = getHref(ref.name, elm.value);
                let href = a_dump.href;
                editorControl[href] =
                    new textEditor(href, "", document.getElementById("app-main-container"), true);
                $(editorControl[href].main_container).focusin(function (e) {
                    if (currentTab != undefined) {
                        $("#navigator-tree-container").removeClass('tab-active');
                        currentTab = undefined;
                    }
                })
            }
        } else {
            let isFolder = true;
            for (let i = 0; i < toEdit.length; i++) {
                if (toEdit[i] == elm.value) {
                    isFolder = false;
                    break;
                }
            }
            if (isFolder) {
                toEdit[elm.value] = [];
                elm.parentNode.insertBefore(
                    createTreeFolder(ref.name + "/" + elm.value,
                        elm.value, []), elm.parentNode.firstChild);
                elm.parentNode.removeChild(elm);
            }
        }
    }
    $(input).focusout(function (e) {
        if (this.value == '') {
            this.parentNode.removeChild(this);
        } else {
            simpleControl(this);
        }
    })
    input.addEventListener("keyup", function (e) {
        if (e.key === "Enter") {
            if (this.value == '') {
                this.parentNode.removeChild(this);
            } else {
                simpleControl(this);
            }
        }
    });
    e.preventDefault();
};

function createTreeFolder(path, name, arr) {
    path_ = path.split('/').join('_');
    name_ = name.split('/').join('_');
    let li_el = document.createElement('li');
    let ul_el = document.createElement('ul');
    ul_el.id = "container_tree_" + path_;
    let a_el = document.createElement('a');
    a_el.text = name_;
    a_el.id = "button_tree_" + path_;
    a_el.name = path;
    a_el.onclick = function (e) {

        $("#" + ul_el.id).toggle("blind", {}, 360);
        e.preventDefault();
    };
    a_el.addEventListener('contextmenu', function (e) {
        contextmenu_tree_container(e, this);
        e.preventDefault();
    });
    li_el.appendChild(a_el);
    if (arr != []) {
        for (var key in arr) {
            generateTree(ul_el, arr[key], isNaN(key) ? path + "/" + key : path, isNaN(key) ? key : "");
        }
    }
    li_el.appendChild(ul_el);
    return li_el;
}

function getHref(path, name) {
    return path + (path != "" ? "/" : "") + name;
}

function createTreeFile(path, obj) {
    let li_el = document.createElement('li');
    let a_el = document.createElement('a');
    a_el.href = getHref(path, obj.name); // projectName + '/' + path + (path != "" ? "/" : "") + name;

    a_el.text = obj.name;
    a_el.uniqueObject = obj.elm;
    a_el.addEventListener('contextmenu', function (e) {
        contextmenu_tree_file(e, this);
        e.preventDefault();
    });
    a_el.onclick = function (e) {
        let href = this.href;
        if (editorControl[href] != undefined) {
            editorControl[href].focus();
        } else {

            $.ajax({
                url: a_el.href,
                success: function (data) {
                    editorControl[href] =
                        new textEditor(href, data, document.getElementById("app-main-container"), false, a_el.uniqueObject);
                    $(editorControl[href].main_container).focusin(function (e) {
                        if (currentTab != undefined) {
                            $("#navigator-tree-container").removeClass('tab-active');
                            currentTab = undefined;
                        }
                    })

                }
            })

        }
        e.preventDefault();
    };
    li_el.appendChild(a_el);
    return li_el;
}

function generateTree(obj, arr, path, pathName) {
    if (Array.isArray(arr)) {

        obj.appendChild(createTreeFolder(path, pathName, arr));
    } else {

        obj.appendChild(createTreeFile(path, arr));
    }
}

let currentTab = $("#navigator-tree-container");
$().ready(function () {
    let test_obj = $("#navigator-tree")[0];
    // let test_ul = document.createElement('ul');
    $("#footer-sortable").sortable();
    $("#button-file-nav").click(function(e) {

        console.log(this)
    })
    
    for (var key in folderTree) {
        generateTree(test_obj, folderTree[key], isNaN(key) ? key : "", isNaN(key) ? key : "");
    }




    // function divide(array = "") {
    //     if(array.length != 1){
    //         array.forEach(element => {

    //             let subIndex = element.indexOf('/');
    //             if(subIndex != -1){
    //                 let cat = element.substr(0, subIndex);
    //                 let subStr = element.substr(subIndex);
    //                 return {cat : divide(subStr)};
    //             }else{
    //                 return element;
    //             }
    //         });
    //     }else{
    //         return array[0];
    //     }
    // }
    // let final_ = {
    //     "root": divide(arrayTest)
    // };
    $(".sidebar-button").click(function (e) {
        e.preventDefault();
        let tab = $(this.name);
        if (currentTab == undefined) {
            currentTab = tab;
            tab.addClass('tab-active');
            tab.focus();
        } else {


            if (tab[0] != currentTab[0]) {
                currentTab.removeClass('tab-active');
                tab.addClass('tab-active');
                tab.focus();
                currentTab = tab;
            } else {
                tab.removeClass('tab-active');
                currentTab = undefined;
            }
        }
    });
    let test = 0;
    $("#explorer-tabs").tabs().addClass("ui-tabs-vertical ui-helper-clearfix");
    $("#explorer-tabs li").removeClass("ui-corner-top").addClass("ui-corner-left");
    $("#navigator-tree-container").resizable({
        helper: "ui-resize-helper-x",
        handles: 'e',
        minWidth: 22 * 3,
        maxWidth: 22 * 20,
        resize: function (event, ui) {
            if (ui.size.width < 22 * 7) {
                ui.size.width = 22 * 7;
                if (event.clientX < 22 * 5) {
                    $(this).removeClass('tab-active');
                } else {
                    $(this).addClass('tab-active');
                }
            } else {
                $(this).addClass('tab-active');
            }
        },
        stop: function (event, ui) {
            if (!$(this).hasClass('tab-active')) {
                currentTab = undefined;
            }
        }
        //grid: 22
    });


    // var editor = ace.edit("editor-spawn-x2");
    // editor.setTheme("ace/theme/monokai");
    // editor.session.setMode("ace/mode/c_cpp");


    // document.addEventListener("keydown", function (event) {
    //     if (event.which == 81) {
    //         $("#navigator-tree-container").resizable({
    //             grid: false
    //         });
    //     }

    //     if (event.which == 87) {
    //         $("#navigator-tree-container").resizable({
    //             grid: 22
    //         });
    //     }
    // });
    // $(document).mousemove(function(e) {
    //     if(navControl.mouseClicked)
    //         navControl.update(e)
    // });
    // $(document).mouseup(function(e) {
    //     navControl.mouseClicked = false;
    // });
    // $("#navigator-tree-resize-bar").click(function(e) {
    //     navControl.click(e)
    // });
});