<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Genel Chat | Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/admin-assets/assets/images/favicon.ico">
    <!-- DataTables -->
    <link href="/admin-assets/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin-assets/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
          type="text/css" />
    <!-- datepicker css -->
    <link href="/admin-assets/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">


    <!-- Icons Css -->
    <link href="/admin-assets/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    @include('panelstyle')

</head>

<body data-layout="detached" data-topbar="colored">



<!-- <body data-layout="horizontal" data-topbar="dark"> -->

<div class="container-fluid">
    <!-- Begin page -->
    <div id="layout-wrapper">

    @include('top_menu')
    @include('left_menu')

    <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">

                @include('page_header',['title'=>'Genel Chat'])

                <div class="row list_contentpanel ">

                        <div class="col-12">
                            <div class="card row border position-relative task-box " style="border-radius: .95rem;">
                                <div class="card-body chat_list pb-5" style="max-height: 800px;overflow-y: scroll;">

                                @foreach(  \App\Models\Chat::orderBy('id','desc')->limit(50)->get()->reverse() as $item)
                                        <div class="row {{json_decode($item->from_id)->id==\Illuminate\Support\Facades\Auth::id()?'justify-content-end':""}}">
                                            <div class="col-lg-8 col-11">
                                                <div class="alert alert-light border">
                                                    <h5 class="font-size-14 text-success">{{json_decode($item->from_id)->name_surname}}</h5>
                                                    <p>
                                                        {{$item->message}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                @endforeach






                                </div>
                                <div class="row position-absolute justify-content-center" style="bottom:0;">
                                    <div class="col-9">
                                        <input class="form-control w-100" placeholder="Mesajınız..." type="text" name="message" />
                                    </div>
                                    <div class="col-1">
                                        <button class="btn btn-success font-size-16 sendChatMessage align-middle me-1 btn-rounded">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>




                </div>
                <!-- end row -->

            </div>
            <!-- End Page-content -->

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

</div>

<div id="fullscreenModal" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" >
        <div class="modal-content" >
            <div class="modal-header" style="border:none;">

                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow:hidden;">

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="edit_content_modal" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" >
        <div class="modal-content" >
            <div class="modal-header" style="border:none;">

                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow:hidden;overflow-y:scroll;">

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- JAVASCRIPT -->
<!-- JAVASCRIPT -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/admin-assets/assets/libs/jquery/jquery.min.js"></script>
<script src="/admin-assets/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/admin-assets/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="/admin-assets/assets/libs/simplebar/simplebar.min.js"></script>
<script src="/admin-assets/assets/libs/node-waves/waves.min.js"></script>
<script src="/admin-assets/assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

<!-- bootstrap datepicker -->
<script src="/admin-assets/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!--tinymce js-->
<script src="/admin-assets/assets/libs/tinymce/tinymce.min.js"></script>

<!-- form repeater js -->
<script src="/admin-assets/assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

<script src="/admin-assets/assets/js/pages/task-create.init.js"></script>

<!-- App js -->
<script src="/admin-assets/assets/js/app.js"></script>
<script>
    $(document).ready(function(){
        const current_id = "{{\Illuminate\Support\Facades\Auth::id()}}";
        const pusher = new Pusher("{{env("PUSHER_APP_KEY")}}", {
            cluster: "{{env("PUSHER_APP_CLUSTER")}}",
            authEndpoint: "/laravel-websockets/auth",
            wssPort:6001,
            wsPort:6001,
            forceTLS:false,
            wsHost:window.location.hostname,

            auth: {
                headers: {
                    'X-App-ID': "{{env("PUSHER_APP_ID")}}",
                }
            },
            enabledTransports:['ws','wss','flash']
        });

        const chat_c = pusher.subscribe('private-chat');
        chat_c.bind('new_message',(val)=>{
            let from_id = JSON.parse(val.from_id);
            let flex = from_id.id==current_id?'justify-content-end':'';

            $(".chat_list").append('<div class="row '+flex+' "> <div class="col-lg-8 col-11"> <div class="alert alert-light border"> <h5 class="font-size-14 text-success">'+from_id.name_surname+'</h5> <p> '+val.message+' </p> </div> </div> </div>');
            $(".chat_list").animate({
                scrollTop: 99999999999999,
            }, 900);


        })
        $(".sendChatMessage").click(function(){
            let msg = $("input[name=message]").val();
            if(msg){
                axios.post('/chatMessage',{message:msg}).then(()=>{
                    $("input[name=message]").val("");
                });
            }
        })
    });
</script>
</body>

</html>
