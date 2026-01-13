$(document).ready(function () {


    //fancybox
    $('.fancybox_modal').fancybox({
        backFocus: false,
        keyboard: false,
        arrows: false,
        buttons: [
            'zoom',
            'close'
        ]
    });
    $('.fancybox_iframe').fancybox({
        type: 'iframe',
        iframe: {
            scrolling: 'auto',
            preload: true
        }
    });


    //add_wow_js
    new WOW({
        boxClass: 'wow',
        animateClass: 'my_animated',
        offset: 50,
        mobile: false,
        live: true
    }).init();


    $("table").wrap("<div class='table_box'></div>");


    //start_menu
    $('.bld__wrapper #header .burger__header .hamburger').click(function () {
        $('.bld__wrapper #header .burger__header').toggleClass('active');
        $('.bld__wrapper #header .burger__header .hamburger').toggleClass('active');
        $('.bld__wrapper #header .menu__header').toggleClass('active');
        $('body').toggleClass('hid_imp');
        $('body').addClass('vis_item');
    });

    //resize_menu
    function resizeMenu() {
        if ($(window).width() <= 1200) {
            //for_body
            if ($(".bld__wrapper #header .menu__header").hasClass("active")) {
                //code
                $('.bld__wrapper #header .burger__header').addClass('active');
                $('.bld__wrapper #header .burger__header .hamburger').addClass('active');
                $('body').addClass('hid_imp');
                $("#checkbox_menu").prop("checked", true);
            } else {
                $("#checkbox_menu").prop("checked", false);
                $('body').removeClass('hid_imp');
                $('.bld__wrapper #header .menu__header').removeClass('active');
                $('.bld__wrapper #header .burger__header').removeClass('active');
                $('.bld__wrapper #header .burger__header .hamburger').removeClass('active');
            }
        } else {
            //for_body
            $("#checkbox_menu").prop("checked", false);
            $('body').removeClass('hid_imp');
            $('.bld__wrapper #header .menu__header').removeClass('active');
            $('.bld__wrapper #header .burger__header').removeClass('active');
            $('.bld__wrapper #header .burger__header .hamburger').removeClass('active');
        }
    }

    resizeMenu();
    $(window).resize(function () {
        resizeMenu();
    });

    //check_for_changes
    function checkForChangesMenu() {
        if ($(".bld__wrapper #header .menu__header").hasClass("active")) {
            //code
            $('body').addClass('hid_imp');
            $("#checkbox_menu").prop("checked", true);
            $('.bld__wrapper #header .burger__header').addClass('active');
            $('.bld__wrapper #header .burger__header .hamburger').addClass('active');
        } else {
            $('body').removeClass('hid_imp');
            $("#checkbox_menu").prop("checked", false);
            $('.bld__wrapper #header .burger__header').removeClass('active');
            $('.bld__wrapper #header .burger__header .hamburger').removeClass('active');
        }

        //main_page__fixed_menu
        var height_of_header = $('.bld__wrapper #header').outerHeight();
        var pt_head = $('.bld__wrapper #main');

        pt_head.css('padding-top', height_of_header + 'px');

        setTimeout(checkForChangesMenu, 500);
    }

    checkForChangesMenu();

    //for_a
    $('.bld__wrapper #header .menu__header a').click(function () {
        $("#checkbox_menu").prop("checked", false);
        $('body').removeClass('hid_imp');
        $('.bld__wrapper #header .menu__header').removeClass('active');
        $('.bld__wrapper #header .burger__header').removeClass('active');
        $('.bld__wrapper #header .burger__header .hamburger').removeClass('active');
    });

    //on_scroll_menu
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 0) {
            $('.bld__wrapper #header').addClass('fixed__header');
        } else {
            $('.bld__wrapper #header').removeClass('fixed__header');
        }
    });
    //end_menu


    //modals
    $('.modal_callback-js').click(function () {
        $('#modal_callback').arcticmodal();
    });
    $('.city__header-js').click(function () {
        $('#modal_city').arcticmodal();
    });


    //scrooll_on_click
    $(".scroll_click").click(function () {
        var elementClick = $(this).attr("href");
        var destination = $(elementClick).offset().top;
        $('html, body').animate({scrollTop: destination - 50}, 600);
        return false;
    });


    //add_tabs__bld
    $(function () {
        $(".bld__wrapper #add_tabs__add_page").on("click", ".item__top", function () {

            var tabs = $(".bld__wrapper #add_tabs__add_page .item__top"),
                image_box = $(".bld__wrapper #add_tabs__add_page .bot__add_tabs");

            // Удаляем классы active
            tabs.removeClass("active__add_tabs");
            image_box.removeClass("active__add_tabs");
            // Добавляем классы active
            $(this).addClass("active__add_tabs");
            image_box.eq($(this).index()).addClass("active__add_tabs");

            return false;
        });
    });


    //slider_object
    var galleryThumbsObject = new Swiper('.bld__wrapper .gallery-thumbs-object', {
        spaceBetween: 10,
        slidesPerView: 5,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        loop: false,
        observer: true,
        observeParents: true,
        breakpoints: {
            0: {
                slidesPerView: 2,
            },
            701: {
                slidesPerView: 3,
            },
            1201: {
                slidesPerView: 5,
            }
        }
    });


    //click_phone
    $(".bld__wrapper .cart__site .phone__cart .front__phone").click(function () {
        $(this).fadeOut();
    });
    $(".bld__wrapper .fadeout_this_click-js").click(function () {
        $(this).fadeOut();
    });


    //scrollbar
    jQuery('.scrollbar-inner').scrollbar();


    //on_click_checked
    $('.bld__wrapper .on_click_checked_neighbour').click(function () {
        $(this).parent().find('input[type="radio"]').prop('checked', true);

        var checkBoxes = $(this).parent().find('input[type="checkbox"]');
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
    });


    //mobile_btn_filters
    $('.bld__wrapper .on_mobile_btn_bot__order').click(function () {
        $('.bld__wrapper .order_block__main_page .bot__order .catalog__bot .filtres__catalog').slideToggle();
    });

    function checkForChangesBtnFilters() {
        if ($(window).width() <= 700) {
            //nothing
        } else {
            $('.bld__wrapper .order_block__main_page .bot__order .catalog__bot .filtres__catalog').css('display', 'block');
        }

        setTimeout(checkForChangesBtnFilters, 500);
    }

    checkForChangesBtnFilters();


    //mobile_btn_filters__list_page
    $('.sub_page_bld__wrapper.bld__wrapper .filtres__list_page .on_mobile_btn__filtres').click(function () {
        $('.sub_page_bld__wrapper.bld__wrapper .filtres__list_page .filtres__catalog').slideToggle();
    });

    function checkForChangesBtnFiltersListPage() {
        if ($(window).width() <= 700) {
            //nothing
        } else {
            $('.sub_page_bld__wrapper.bld__wrapper .filtres__list_page .filtres__catalog').css('display', 'block');
        }

        setTimeout(checkForChangesBtnFiltersListPage, 500);
    }

    checkForChangesBtnFiltersListPage();


    //select
    $('select').niceSelect();


    //mask_phone
    $(function () {
        $(".mask_phone").mask("+7 (999) 999-99-99");
    });

    //city_tabs__modal
    $(function () {
        $("#tabs__modal").on("click", ".item__top", function () {

            var tabs = $("#tabs__modal .item__top"),
                image_box = $("#tabs__modal .item__bot");

            // Удаляем классы active
            tabs.removeClass("active_tab");
            image_box.removeClass("active_tab");
            // Добавляем классы active
            $(this).addClass("active_tab");
            image_box.eq($(this).index()).addClass("active_tab");

            return false;
        });
    });


});
