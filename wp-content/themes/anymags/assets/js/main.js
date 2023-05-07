   // When the user clicks on the button, scroll to the top of the document
            function topFunction(){
              document.body.scrollTop = 0; // For Safari
              document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            }
          jQuery(document).ready(function(){
            mybutton = document.getElementById("myBtn");

            // When the user scrolls down 20px from the top of the document, show the button
            window.onscroll = function() {scrollFunction()};

                function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    mybutton.style.display = "block";
                } else {
                    mybutton.style.display = "none";
              }
          }

  });


  // Navbar Area sticky

  jQuery(window).on('scroll', function() {
      if (jQuery(this).scrollTop() >200){  
          jQuery('.anymags-sticky').addClass("sticky-nav");
      }
      else{
          jQuery('.anymags-sticky').removeClass("sticky-nav");
      }
    });


/* ===================================================================
 * Count - Main JS
 *
 * ------------------------------------------------------------------- */
(function($) {
    "use strict";
   

    var menu_toggle         = $('.anymags-menu-toggle');
    var nav_menu            = $('.anymags-main-navigation ul.nav-menu');

    /*------------------------------------------------
            MAIN NAVIGATION
------------------------------------------------*/

    menu_toggle.click(function(){
        $(this).toggleClass('close-menu');
        nav_menu.slideToggle();
    });

    $('.anymags-main-navigation .nav-menu .menu-item-has-children > a').after( $('<button class="dropdown-toggle"><i class="fa fa-angle-down"></i></button>') );

    $('button.dropdown-toggle').click(function() {
        $(this).toggleClass('active');
       $(this).parent().find('.sub-menu').first().slideToggle();
    });


    $('.anymags-menu-toggle').click(function () {
        $(this).next('.nav-menu').slideToggle();
        totalKeyboardLoop($('.anymags-main-navigation'));
        return false;
    });

    var totalKeyboardLoop = function (elem) {

        var tabbable = elem.find('select, input, textarea, button, a').filter(':visible');

        var firstTabbable = tabbable.first();
        var lastTabbable = tabbable.last();
        /*set focus on first input*/
        firstTabbable.focus();

        /*redirect first shift+tab to last input*/
        firstTabbable.on('keydown', function (e) {
            if ((e.which === 9 && e.shiftKey)) {
                e.preventDefault();
                lastTabbable.focus();
            }
        });

        /* allow escape key to close insiders div */
        elem.on('keyup', function (e) {
            if (e.keyCode === 27) {
                elem.hide();
            }
            ;
        });
    };

})(jQuery);

jQuery(document).ready(function() {
        jQuery('.skip-link-menu-end-skip').focus(function(){
            jQuery('.close-menu').focus();
        });
});