$(function () {

    // menu

    $("body").click(function (e) {
        if (e.target.className !== "main-menu-wrapper") {
            $("body").removeClass("menu-is-open");
            $("#openMenu").removeClass("active");
        }
    });

    $("#openMenu").on("click", function (e) {

        $(this).toggleClass("active");
        $("body").toggleClass("menu-is-open");

        e.stopPropagation();

    });

    // carousel


    // home
    $(".projects-list-block").each(function (index) {
        $(this).attr("data-aos-delay", 100 * index);
    });

    // detail 
    $("#openDetail").on("click", function () {

        $(this).toggleClass("active");
        $(this).parent().toggleClass("open");

    });



    // Images loaded is zero because we're going to process a new set of images.
    var imagesLoaded = 0;
    // Total images is still the total number of <img> elements on the page.
    var totalImages = $('.project-detail-img').length;

    // Step through each image in the DOM, clone it, attach an onload event
    // listener, then set its source to the source of the original image. When
    // that new image has loaded, fire the imageLoaded() callback.
    $('.project-detail-img').each(function (idx, img) {
        $('<img>').on('load', imageLoaded).attr('src', $(img).attr('src'));
    });

    // Do exactly as we had before -- increment the loaded count and if all are
    // loaded, call the allImagesLoaded() function.
    function imageLoaded() {
        imagesLoaded++;
        if (imagesLoaded == totalImages) {
            allImagesLoaded();
        }
    }

    function allImagesLoaded() {
        $('.project-detail-carousel').slick({
            infinite: true,
            appendArrows: $(".project-detail-arrows"),
            prevArrow: '<button type="button" class="slick-prev"><img src="/assets/img/arrow-left.svg" alt="<"></button>',
            nextArrow: '<button type="button" class="slick-next"><img src="/assets/img/arrow-right.svg" alt=">"></button>'
        });
    }


    // effects
    AOS.init();

});