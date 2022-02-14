<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Üyeler | Panel</title>
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

                @include('page_header',['title'=>'Üyeler'])
                <div class="row justify-content-end pt-1 pt-lg-0 pt-sm-5 pb-sm-3">
                    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#new_user_modal" style="width: 100%;" class="m-1 btn  btn-outline-success waves-effect waves-light">
                            <i class="fas fa-angle-double-right font-size-16 align-middle me-1"></i>
                            Üye Oluştur
                        </button>

                    </div>
                </div>
                <div class="row list_contentpanel px-xxl-5 px-xl-3">

                    @foreach(\App\Models\User::orderBy('id','desc')->get() as $item)
                        @php
                            if($item->is_admin){
                                $code_title="Admin";
                                $icon="fas fa-map-marker-alt";
                            }else if($item->is_client){
                                $code_title="Müşteri";
                                $icon="bx bx-group";
                            }else if($item->is_worker){
                              $code_title="Çalışan";
                              $icon="bx bxs-navigation";
                           }

                        @endphp
                        <div class="col-xxl-3 col-xl-4 px-1 col-lg-4 col-md-6 col-sm-6">
                            <div class="card border task-box " style="border-radius: .95rem;height: 500px;">
                                <div class="card-body">
                                    <div class="float-start">
                                        <div class="alert font-size-12 alert-primary p-1" >
                                            {{$code_title}}
                                        </div>
                                    </div>


                                    <div class="p-3 pt-5 pb-xl-5 pb-0 text-center">
                                        <div style="font-size: 3.2rem;" class=" text-center text-primary">
                                            @if($item->avatar)
                                                <div class="user-img">
                                                    <img src="{{$item->avatar}}" alt="" class="avatar-md mx-auto rounded-circle">
                                                </div>
                                                @else
                                                <i class="bx bx-user"></i>
                                            @endif

                                        </div>
                                        <h3 class="font-size-14 pb-xl-3 pt-xl-2"><a href="javascript: void(0);"
                                                                                    class="text-dark">{{$item->name_surname}}</a></h3>
                                        <h5 class="font-size-11 pb-3 pt-2 p-0 "><a href="javascript: void(0);"
                                                                                    class="text-dark alert alert-success p-2">{{$item->notif_platform?$item->notif_platform:"Bilinmiyor"}}</a></h5>
                                        <h6 class="font-size-12 pb-3 pt-2">
                                            {{$item->about?$item->about:"Hakkında bilgisi bulunamadı."}}
                                        </h6>
                                        <h5 class="font-size-11 pb-3 pt-2"><a href="javascript: void(0);"
                                                                                    class=" alert alert-success p-1">Eklenme tarihi: {{\App\Http\Controllers\Controller::encode_date($item->created_at)}}</a></h5>
                                        <h5 class="font-size-11 pb-3 pt-2"><a href="javascript: void(0);"
                                                                                    class=" alert alert-success p-1 m-0">Güncellenme tarihi: {{\App\Http\Controllers\Controller::encode_date($item->updated_at)}}</a></h5>

                                        <div class="col-12">
                                            <a href="tel:{{$item->phone_number}}" class="w-100 btn btn-primary">{{$item->phone_number}}</a>
                                        </div>


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
<!-- end container-fluid -->
<div class="modal fade px-0" id="new_user_modal" tabindex="-1" role="dialog"
     aria-labelledby="composemodalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 1rem;">
            <div class="modal-header" style="border:none;">
                <h5 class="modal-title" id="composemodalTitle"> Kullanıcı Oluştur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <form class="default_axiosform" data-url="/register" data-callback="register_callback" method="post">
                <div class="modal-body">

                    <div>

                        <div class="mb-3 ">
                            <input name="avatar" type="text"
                                   class="form-control" value="" placeholder="Avatar">
                        </div>
                        <div class="mb-3 ">
                            <input name="name_surname" type="text"
                                   class="form-control" value="" placeholder="Ad Soyad">
                        </div>
                        <div class="mb-3">
                            <input name="phone_number" type="text"
                                   class="form-control " value="" placeholder="Telefon Numarası">
                        </div>
                        <div class="mb-3">
                            <select name="degree" class="form-control">
                                <option value="0">Admin</option>
                                <option value="1">Çalışan</option>
                                <option value="2">Müşteri</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="description" placeholder="Hakkında" rows="8"></textarea>
                        </div>

                        <div class="mb-3">
                            <input name="username" type="text"
                                   class="form-control" placeholder="Kullanıcı adı">
                        </div>
                        <div class="mb-3">
                            <input name="password" type="password"
                                   class="form-control " value="" placeholder="Şifre">
                        </div>


                    </div>


                </div>
                <div class="modal-footer" style="border:none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Oluştur <i
                            class="fab fa-telegram-plane ms-1"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- JAVASCRIPT -->
<!-- JAVASCRIPT -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    $(document).ready(function (){
        window.register_callback = function(e){

            if(e.data.success){
                Toast.fire({
                    icon:"success",
                    title:"Başarıyla kullanıcı oluşturuldu"
                });
                setTimeout(function (){window.location.reload();},300);
            }else{
                Toast.fire({
                    icon:"error",
                    title:"Giriş yapılamadı"
                });

            }
        }
        $(".custom-file-input-dashed").click(function(e){
            e.preventDefault();
            let name = $(this).data("name");
            $("input[name="+name+"]").click();
            $("input[name="+name+"]").change(function(e){
                $(".custom-file-input-dashed[data-name="+name+"] .current_file").text($(this).val());
            });
        });

    });
</script>
</body>

</html>
