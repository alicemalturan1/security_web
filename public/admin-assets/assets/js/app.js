!function(t){"use strict";function s(){for(var e=document.getElementById("topnav-menu-content").getElementsByTagName("a"),t=0,n=e.length;t<n;t++)"nav-item dropdown active"===e[t].parentElement.getAttribute("class")&&(e[t].parentElement.classList.remove("active"),e[t].nextElementSibling.classList.remove("show"))}function n(e){var color= '';if(t("#"+e).prop("checked")==true)color='dark';else color='light';axios.post('/admin/setPanelColor',{"color":color});if(t("#"+e).prop("checked")==true){t("#bootstrap-style").attr("href","/admin-assets/assets/css/bootstrap-dark.min.css");t("#app-style").attr("href","/admin-assets/assets/css/app-dark.min.css");}else{t("#bootstrap-style").attr("href","/admin-assets/assets/css/bootstrap.min.css");t("#app-style").attr("href","/admin-assets/assets/css/app.min.css");}}function e(){document.webkitIsFullScreen||document.mozFullScreen||document.msFullscreenElement||(console.log("pressed"),t("body").removeClass("fullscreen-enable"))}var a;t("#side-menu").metisMenu(),t("#vertical-menu-btn").on("click",function(e){e.preventDefault(),t("body").toggleClass("sidebar-enable"),992<=t(window).width()?t("body").toggleClass("vertical-collpsed"):t("body").removeClass("vertical-collpsed")}),t("#sidebar-menu a").each(function(){var e=window.location.href.split(/[?#]/)[0];this.href==e&&(t(this).addClass("active"),t(this).parent().addClass("mm-active"),t(this).parent().parent().addClass("mm-show"),t(this).parent().parent().prev().addClass("mm-active"),t(this).parent().parent().parent().addClass("mm-active"),t(this).parent().parent().parent().parent().addClass("mm-show"),t(this).parent().parent().parent().parent().parent().addClass("mm-active"))}),t(".navbar-nav a").each(function(){var e=window.location.href.split(/[?#]/)[0];this.href==e&&(t(this).addClass("active"),t(this).parent().addClass("active"),t(this).parent().parent().addClass("active"),t(this).parent().parent().parent().addClass("active"),t(this).parent().parent().parent().parent().addClass("active"),t(this).parent().parent().parent().parent().parent().addClass("active"),t(this).parent().parent().parent().parent().parent().parent().addClass("active"))}),t('[data-toggle="fullscreen"]').on("click",function(e){e.preventDefault(),t("body").toggleClass("fullscreen-enable"),document.fullscreenElement||document.mozFullScreenElement||document.webkitFullscreenElement?document.cancelFullScreen?document.cancelFullScreen():document.mozCancelFullScreen?document.mozCancelFullScreen():document.webkitCancelFullScreen&&document.webkitCancelFullScreen():document.documentElement.requestFullscreen?document.documentElement.requestFullscreen():document.documentElement.mozRequestFullScreen?document.documentElement.mozRequestFullScreen():document.documentElement.webkitRequestFullscreen&&document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT)}),document.addEventListener("fullscreenchange",e),document.addEventListener("webkitfullscreenchange",e),document.addEventListener("mozfullscreenchange",e),t(".right-bar-toggle").on("click",function(e){t("body").toggleClass("right-bar-enabled")}),t(document).on("click","body",function(e){0<t(e.target).closest(".right-bar-toggle, .right-bar").length||t("body").removeClass("right-bar-enabled")}),function(){if(document.getElementById("topnav-menu-content")){for(var e=document.getElementById("topnav-menu-content").getElementsByTagName("a"),t=0,n=e.length;t<n;t++)e[t].onclick=function(e){"#"===e.target.getAttribute("href")&&(e.target.parentElement.classList.toggle("active"),e.target.nextElementSibling.classList.toggle("show"))};window.addEventListener("resize",s)}}(),[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function(e){return new bootstrap.Tooltip(e)}),[].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function(e){return new bootstrap.Popover(e)}),window.sessionStorage&&((a=sessionStorage.getItem("is_visited"))?(t(".right-bar input:checkbox").prop("checked",!1),t("#"+a).prop("checked",!0),n(a)):sessionStorage.getItem("is_visited")),t("#light-mode-switch, #dark-mode-switch, #rtl-mode-switch").on("change",function(e){n(e.target.id)}),t(window).on("load",function(){t("#status").fadeOut(),t("#preloader").delay(350).fadeOut("slow")}),Waves.init();$(".reset-file-content").click((e)=>{e.preventDefault();$("#inputGroupFile03").val(null);});}(jQuery);$(document).ready(function(){$(".cnt_dcinput").change(function(){

        $(".cnt_dcinput").parent().removeClass("border-primary");
        $(this).parent().addClass("border-primary");

});
     window.Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    $(".default_axiosform").submit(function(e){
       e.preventDefault();
       let url = $(this).data("url");
       let data = new FormData(this);
       let callback = $(this).data("callback");
       axios.post(url,data).then(function(e){
           if(callback){
               console.log("running callback function");
               window[callback](e);
           }else{
               console.log("callback function not found");
           }
       }).catch(function(){
           Toast.fire({
               icon:"error",
               title:"Bir hata olu??tu"
           })
       });
    });

});
