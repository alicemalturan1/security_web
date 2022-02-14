<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Topluluk | Panel</title>
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

                @include('page_header',['title'=>'Topluluk'])

                <div class="row list_contentpanel px-xxl-5 px-xl-3">

                    @foreach(\App\Models\CommunityLog::orderBy('id','desc')->get() as $item)
                        @php
                            if($item->type=="call_normal"){
                                $code_title="CN";
                                $icon="fas fa-map-marker-alt";
                            }else if($item->type=="call_gathering"){
                                $code_title="GC";
                                $icon="bx bx-group";
                            }else if($item->type=="going_location"){
                              $code_title="GL";
                              $icon="bx bxs-navigation";
                            }else if($item->type=="cancelled"){
                                $code_title="CC";
                                $icon="fas fa-times";
                            }else if($item->type=="arrived"){
                                $code_title="LA";
                                $icon="bx bx-check-circle";
                            }

                        @endphp
                        <div class="col-xxl-3 col-xl-4 px-1 col-lg-4 col-md-6 col-sm-6">
                            <div class="card border task-box " style="border-radius: .95rem;height: 300px;">
                                <div class="card-body">
                                    <div class="float-start">
                                        <div class="alert alert-primary p-1" >
                                            {{$code_title.$item->id}}
                                        </div>
                                    </div>
                                    <div class="dropdown float-end">



                                        <a href="#" style="z-index: 999;" class="dropdown-toggle position-relative arrow-none" data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @if($item->type=="call_gathering"||$item->type=="call_normal")

                                            <a class="dropdown-item show_locationbtn"  data-id="{{$item->id}}" target="_blank" href="http://maps.google.com/maps?z=13&t=p&q=loc:{{json_decode($item->location)->coords->latitude}},{{json_decode($item->location)->coords->longitude}}" >Konumu Görüntüle</a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="p-3 pt-5 pb-xl-5 pb-0 text-center">
                                        <div style="font-size: 3.2rem;" class=" text-center text-primary">
                                            <i class="{{$icon}}"></i>
                                        </div>
                                        <h3 class="font-size-14 pb-xl-3 pt-xl-2"><a href="javascript: void(0);"
                                                                                    class="text-dark">{{$item->title}}</a></h3>
                                        <h5 class="font-size-14 pb-xl-3 pt-xl-2"><a href="javascript: void(0);"
                                                                                    class="text-dark">{{$item->description}}</a></h5>






                                    </div>






                                </div>

                            </div>

                        </div>

                    @endforeach


                </div>
                <!-- end row -->

            </div>
            <!-- End Page-content -->

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

</div>
<!-- end container-fluid -->
<div class="modal fade" id="remove_content_modal" tabindex="-1" role="dialog"
     aria-labelledby="composemodalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-3" style="border-radius:1rem;">
            <div class="modal-header" style="border:none;">
                <h5 class="modal-title" id="composemodalTitle">  İçeriği silmek istediğine emin misin ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    İçerik ile beraber şunlar da silinecek;
                </p>

                <div class="plan-features p-4 text-muted mt-2">
                    <p><i class="mdi mdi-check-bold text-primary me-4"></i>İçeriğe ait değerlendirmeler</p>
                    <p><i class="mdi mdi-check-bold text-primary me-4"></i>Kullanıcı favorisi</p>
                    <p><i class="mdi mdi-check-bold text-primary me-4"></i>İndirme Kayıtları</p>
                    <p><i class="mdi mdi-check-bold text-primary me-4"></i>Beğeni Kayıtları</p>
                </div>

            </div>
            <div class="modal-footer" style="border:none;">
                <button type="button" class="btn btn-success removelink_confirm-btn" >Sil</button>
                <button type="button" class="btn btn-danger close_removelinkmodal-btn" data-bs-dismiss="modal">İptal </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="show_location_modal" tabindex="-1" role="dialog"
     aria-labelledby="composemodalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-3" style="border-radius:1rem;">
            <div class="modal-header" style="border:none;">
                <h5 class="modal-title" id="composemodalTitle">  İçeriği silmek istediğine emin misin ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0"></iframe>

            </div>
            <div class="modal-footer" style="border:none;">
                <button type="button" class="btn btn-success removelink_confirm-btn" >Sil</button>
                <button type="button" class="btn btn-danger close_removelinkmodal-btn" data-bs-dismiss="modal">İptal </button>
            </div>
        </div>
    </div>
</div>
<!-- JAVASCRIPT -->
<!-- JAVASCRIPT -->

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

        const cmn_c = pusher.subscribe('private-support');
        cmn_c.bind('new_support',(val)=>{
            console.log(val);
            let dropwdown = val.data.type=="call_normal"||"call_gathering"? '<a class="dropdown-item show_locationbtn" href="http://maps.google.com/maps?z=13&t=p&q=loc:'+JSON.parse(val.data.location).coords.latitude+','+JSON.parse(val.data.location).coords.longitude+'"   target="_blank" >Konumu Görüntüle</a>':"";
            let code  = "",icon="";
            if(val.data.type=="call_normal"){
                code="CN";
                icon="fas fa-map-marker-alt";
            }else if(val.data.type=="call_gathering"){
                code="GC";
                icon="bx bx-group";
            }else if(val.data.type=="going_location"){
                code="GL";
                icon="bx bxs-navigation";
            }else if(val.data.type=="cancelled"){
                code="CC";
                icon="fas fa-times";
            }else if(val.data.type=="arrived"){
                code="LA";
                icon="bx bx-check-circle";
            }
            $(".list_contentpanel").prepend('<div class="col-xxl-3 col-xl-4 px-1 col-lg-4 col-md-6 col-sm-6">' +
                ' <div class="card border task-box " style="border-radius: .95rem;height: 300px;">' +
                ' <div class="card-body"> <div class="float-start">' +
                ' <div class="alert alert-primary p-1" >'+code+val.data.id+'</div> </div> <div class="dropdown float-end">' +
                ' <a href="#" style="z-index: 999;" class="dropdown-toggle position-relative arrow-none" data-bs-toggle="dropdown" aria-expanded="false"> ' +
                '<i class="mdi mdi-dots-vertical m-0 text-muted h5"></i> </a> ' +
                '<div class="dropdown-menu dropdown-menu-end"> ' +
                  dropwdown+
                ' </div> </div> <div class="p-3 pt-5 pb-xl-5 pb-0 text-center"> <div style="font-size: 3.2rem;" class=" text-center text-primary"> <i class="'+icon+'"></i> </div> ' +
                '<h3 class="font-size-14 pb-xl-3 pt-xl-2"><a href="javascript: void(0);" class="text-dark">'+val.data.title+'</a></h3> <h5 class="font-size-14 pb-xl-3 pt-xl-2"><a href="javascript: void(0);" class="text-dark">' +
                ''+val.data.description+'</a></h5> </div> </div> </div> </div>');
        });
    });
</script>
</body>

</html>
