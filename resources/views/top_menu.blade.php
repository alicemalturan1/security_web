<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid">
            <div class="float-end">



                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>
                <div class="dropdown d-inline-block">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input theme-choice" @if(Illuminate\Support\Facades\Cookie::get('panel_color')&&Illuminate\Support\Facades\Cookie::get('panel_color')=='dark') checked @endif id="dark-mode-switch"
                        />
                        <label class="form-check-label" for="dark-mode-switch">Karanlık Mod</label>
                    </div>

                </div>
                @if(isset($search))
                    <div class="dropdown d-lg-none d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 " aria-labelledby="page-header-search-dropdown" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 72px, 0px);" data-popper-placement="bottom-end">

                            <form class="p-3 panel-search">
                                <div class="m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control  search_panel" placeholder="{{$search["placeholder"]}}" data-searched="{{$search["searched"]}}" data-resp_class="{{$search["response_class"]}}">

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{\Illuminate\Support\Facades\Auth::user()->avatar}}"
                             alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->


                        <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i>
                            Kilitle</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="/logout"><i
                                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> Güvenli Çıkış</a>
                    </div>
                </div>




            </div>
            <div>
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="/admin-assets/assets/images/logo-sm.png" alt="" height="20">
                                </span>
                        <span class="logo-lg">
                                    <img src="/admin-assets/assets/images/logo-dark.png" alt="" height="17">
                                </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="/admin-assets/assets/images/logo-sm.png" alt="" height="20">
                                </span>
                        <span class="logo-lg">
                                    <img src="/admin-assets/assets/images/logo-light.png" alt="" height="19">
                                </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                        id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <!-- App Search-->
                @if(isset($search))
                    <form class="app-search d-none panel-search d-lg-inline-block">
                        <div class="position-relative">
                            <input type="text" class="form-control search_panel" placeholder="{{$search["placeholder"]}}" data-resp_class="{{$search["response_class"]}}" data-searched="{{$search["searched"]}}">
                            <span class="bx bx-search-alt"></span>
                        </div>
                    </form>
                @endif

            </div>

        </div>
    </div>
</header> <!-- ========== Left Sidebar Start ========== -->
