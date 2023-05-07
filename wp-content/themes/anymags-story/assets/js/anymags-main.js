jQuery(document).ready(function(){

    // featured-post-slider
jQuery('.category-post-slider-active').slick({
    dots: false,
    infinite: true,
    arrows: false,
    autoplay:true,
    autoplaySpeed:2500,
    speed: 2000,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

});