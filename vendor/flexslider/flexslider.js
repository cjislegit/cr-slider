jQuery(window).load(function () {
  jQuery('.flexslider').flexslider({
    animation: 'slide',
    touch: true,
    directionNav: false,
    smoothHeight: true,
    //Var is being sent over from the functions page
    controlNav: SLIDER_OPTIONS.controlNav,
  });
});
