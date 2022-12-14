@php $roadMap = json_decode($roadmap->roadmap); @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{strtoupper($booklet->topic)}}</title> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
    <link rel="icon" type="image/x-icon" href="{{url('imgs/pngs/fav1.png')}}">
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- BS4 | ANIMATE | FONT-AWESOME | VANTA.JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">

    <!-- <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.11/lib/draggable.bundle.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <link rel="stylesheet" href="{{url('/richtexteditor/rte_theme_default.css')}}" />  
    <script type="text/javascript" src="{{url('/richtexteditor/rte.js')}}"></script>  
    <script type="text/javascript" src='{{url('/richtexteditor/plugins/all_plugins.js')}}'></script>  
    <!-- MYCSS -->
    <link rel="stylesheet" href="{{url('/css/btns.css')}}?{{uniqid()}}">
    <link rel="stylesheet" href="{{url('/css/booklet_view.css')}}?{{uniqid()}}">
    <link rel="stylesheet" href="{{url('/css/editbook.css')}}?{{uniqid()}}">
</head>
<body>
    <input type="hidden" id="bookletHtml" value="{{$booklet->content}}">
    <div class="roadmap-sidebar animate__animated hide" id="roadmapBar">
        <div class="roadmap position-relative h-100 w-100">
            <button class="position-absolute closeme btn" onclick="toggleBar()"><a class="f-20 text-white"><i class="fa-regular fa-circle-xmark"></i></a></button>
            <div class="p-3 mt-4">
                <ul class="list-group">
                    @foreach($roadMap as $step)
                        <li class="list-group-item mt-2 pt-1 pb-1 bg-transparent text-white">{{$step}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 bg-green text-white">
                <div class="top-bar d-flex align-items-center">
                    <a href="/home" class="text-white f-20"><i class="fa-solid fa-circle-left"></i></a>
                    <h4 class="book-name mb-0 ml-3">{{$booklet->topic}}</h4>
                    <div class="ml-3">
                        <button class="button-70" bookid="{{$booklet->uniq_id}}" id="savebook">Save</button>
                    </div>
                    <div class="d-flex justify-content-end flex-grow-1">
                        <button class="button-70 bar-btn" id="roadmapSidebar" onclick="toggleBar()"><i class="fa-solid fa-list-ul mr-2"></i> Roadmap</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12 col-12 pl-0 border pt-2">
                <div class="elements-bar p-2 h-100vh">
                    <div class="bar-heading mb-3">
                        <h4 align="center">Elements</h4>
                    </div>
                    <x-elements />
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12 pt-3">
                <div id="dropboxContainer" class="canvas-wrapper p-2 d-flex justify-content-center">
                    <div id="dropbox" class="canvas"></div>
                </div>
            </div>
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 border-left props-main-wrapper">
                <div class="props-wrapper">
                    <div class="pt-3 fm-ubuntu">
                        <h6>Properties</h6>
                    </div>
                    <div class="props p-2">
                        <div class="">
                            <div>
                                <p align="center" for="">Bg color</p>
                                <input id="component-bg-color" type="color" class="form-control" disabled>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <button onclick="delComp()" class="btn btn-sm border shadow-sm bg-del button-15 disabled text-white" id="delcomp" disabled>Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="pt-3 pb-3">
                    <form action="/pdf" method="post" class="p-2 d-flex justify-content-end">
                        @csrf
                        <input id="html_content" type="hidden" name="html" class="form-control">
                        <input type="submit" value="IMG" class="btn btn-sm btn-dark mr-3">
                        <input type="submit" value="PDF" class="btn btn-sm btn-danger">
                      </form>
                </div>
            </div>
            <x-footer />
        </div>
    </div>
</body>
<script src="{{url('/js/interact.js')}}"></script>
<script src="{{url('/js/zombie.js')}}?{{uniqid()}}"></script>
<script>
    function toggleBar(){
        let sideBar = document.getElementById("roadmapBar");
        sideBar.classList.toggle("hide");
        sideBar.classList.toggle("animate__fadeInRight");
    }
    //Save Booklet
    saveBtn.addEventListener('click',(event)=>{
        var sendhtml = $("#html_content").val();
        var id = $(event.target).attr("bookid");
        token = document.querySelector('meta[name="csrf-token"]').content;
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST","http://localhost:8000/savebook",true);
        xhttp.setRequestHeader("X-CSRF-TOKEN", token); 
        xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhttp.onload = ()=>{
            if(xhttp.response){
            alert("Saved successfully!");
            }else{
            alert("Error occured!");
            }
        }
        xhttp.send(`id=${id}&html=${sendhtml}`);
    })

</script>
</html>