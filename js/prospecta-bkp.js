$(document).ready(function(){
  if ($(window).width() > 1280) {
    var wow = new WOW(
      {
        boxClass:     'wow',      // animated element css class (default is wow)
        animateClass: 'animated', // animation css class (default is animated)
        offset:       250,          // distance to the element when triggering the animation (default is 0)
        mobile:       false,       // trigger animations on mobile devices (default is true)
        live:         true,       // act on asynchronously loaded content (default is true)
        callback:     function(box) {
          // the callback is fired every time an animation is started
          // the argument that is passed in is the DOM node being animated
        },
        scrollContainer: null // optional scroll container selector, otherwise use window
      }
    );
    wow.init();
  }
  else{
    var wow = new WOW(
      {
        boxClass:     'wow',      // animated element css class (default is wow)
        animateClass: 'animated', // animation css class (default is animated)
        offset:       100,          // distance to the element when triggering the animation (default is 0)
        mobile:       false,       // trigger animations on mobile devices (default is true)
        live:         true,       // act on asynchronously loaded content (default is true)
        callback:     function(box) {
          // the callback is fired every time an animation is started
          // the argument that is passed in is the DOM node being animated
        },
        scrollContainer: null // optional scroll container selector, otherwise use window
      }
    );    
    wow.init();
  }

  /* TOPO FIXO */
  var topo = $("#topo");
  var botaoTopo = $("#totop");
  var windowScroll_t;

  if($(window).scrollTop() > 0 && topo.hasClass('topo-normal')){
    topo.addClass('topo-fixo');
  }

  $(window).scroll(function(){
    //TOTOP
    clearTimeout(windowScroll_t);
    windowScroll_t = setTimeout(function(){
        if($(this).scrollTop() > 0){
            botaoTopo.addClass('ativo');
        }else{
            botaoTopo.removeClass('ativo');
        }
    }, 300);

    //TOPO
    if($(this).scrollTop() > 0 && topo.hasClass('topo-normal')){
      topo.addClass('topo-fixo');
    } else if($(this).scrollTop() <= 0 && topo.hasClass('topo-fixo')){
      topo.removeClass('topo-fixo');
    }
  });

  botaoTopo.click(function(){
      $('html, body').animate({scrollTop: 0}, 600, 'easeInOutExpo');
      return false;
  });

  $('.fundo-interna').parallax({
    relativeInput: true,
    clipRelativeInput: true,
    invertX: true,
    invertY: true,
    scalarX: 10,
    originX: -0.2,
    originY: -0.2,
    frictionY: .1
  });
  

  //muda a cor do topo quando for fundo branco
  // altura topo
  var hTopo = topo.height() 
function topoBranco () {
    $('.fundo-branco').each(function(index, el) {
        var tWindow = $(window).scrollTop(); 
        // scroll top do elemento menos altura do topo
        var tElement = $(el).offset().top - hTopo;
        var inicio = tElement;
        var fim = tElement + $(el).height();
        console.log(index, inicio, fim);
        // enquanto o scroll for maior que o começo da el e menor que o final
        if (tWindow > inicio && tWindow < fim && !$('#toggle-nav').is(':checked')) {
            topo.addClass('topo-branco');
        }
        else if(topo.hasClass('topo-branco') && tWindow < inicio) {
            topo.removeClass('topo-branco');
        }
        if (tWindow > tElement - ($(window).height() / 2) + $('.side-nav').height()){
            $('.side-nav').addClass('side-nav--vermelho');
        }
        else if($('.side-nav').hasClass('side-nav--vermelho')){
            $('.side-nav').removeClass('side-nav--vermelho');
        }
    });
}
        topoBranco();
        $(window).scroll(function() {
          topoBranco();
        });
        $(document).ready(function() {
          topoBranco();  
        });
        
        $('#toggle-nav').change(function() {
            if($(this).is(':checked') && topo.hasClass('topo-branco')){
              setTimeout(function () {
                topo.removeClass('topo-branco');
              }, 200);
            } else if($('.ativo').hasClass('fundo-branco')){
              topo.addClass('topo-branco');
            }
        });

  // SMOOTH SCROLLING - Code stolen from css-tricks for smooth scrolling:
  $(function() {
    $('a[href*=#]:not([href=#]):not([data-toggle="collapse"]):not([data-toggle="modal"])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html,body').animate({
            scrollTop: target.offset().top //- $("#topo").outerHeight() //ALTURA DO TOPO
          }, 1000, 'easeInOutExpo');
          return false;
        }
      }
    });
  });
    


  // I know that the code could be better.
  // If you have some tips or improvement, please let me know.
  $('.img-parallax').each(function(){
    var img = $(this);
    var imgParent = $(this).parent();
    imgParent.css({
      position: 'relative',
      overflow: 'hidden'
    });
    function parallaxImg () {
      var speed = img.data('speed');
      var imgY = imgParent.offset().top;
      var winY = $(this).scrollTop();
      var winH = $(this).height();
      var parentH = imgParent.innerHeight();
      
      
      // The next pixel to show on screen      
      var winBottom = winY + winH;
      
      // If block is shown on screen
      if (winBottom > imgY && winY < imgY + parentH) {
        // Number of pixels shown after block appear
        var imgBottom = ((winBottom - imgY) * speed);
        // Max number of pixels until block disappear
        var imgTop = winH + parentH;
        // Porcentage between start showing until disappearing
        var imgPercent = ((imgBottom / imgTop) * 100) + (50 - (speed * 50));
      }
      img.css({
        top: imgPercent + '%',
        transform: 'translate3d(-50%, -' + imgPercent + '%, 0)'
      });
    }
    $(document).on({
      scroll: function () {
          parallaxImg();
      },
      ready: function () {
          parallaxImg();
      }
    });
  });
    

  $('#telefone, #celular').focusout(function(){
      var phone, element;
      element = $(this);
      element.unmask();
      phone = element.val().replace(/\D/g, '');
      if(phone.length > 10) {
          element.mask("(99) 99999-999?9");
      } else {
          element.mask("(99) 9999-9999?9");
      }
  }).trigger('focusout');

  $('#data').focusout(function(){
      var date, element;
      element = $(this);
      element.unmask();
      date = element.val().replace(/\D/g, '');
      element.mask("99/99/9999");
      
  }).trigger('focusout');


  // floating label
  function updateText(){
    var input=$(this);
    setTimeout(function(){
      var val=input.val();
      if(val!="")
        input.parent().addClass("floating-placeholder-float");
      else
        input.parent().removeClass("floating-placeholder-float");
    },1)
  }
  $(".floating-placeholder input, .floating-placeholder textarea").keydown(updateText);
  $(".floating-placeholder input, .floating-placeholder textarea").change(updateText);
  $(".floating-placeholder input, .floating-placeholder textarea").on('click', updateText);
  $(".floating-placeholder input, .floating-placeholder textarea").on('focus', updateText);

     //  Fancybox Gallery Images    
       $('.fancybox').fancybox({
          fitToView : true,
          width  : '100%',
          height  : '100%',
          autoSize : false,
          closeClick : true,
          cyclic: true,
          helpers : {
            media : {}
          }
       });

    if ($('.slick-interna').length) {
      $('.slick-interna').slick({
        dots: true,
        arrows: false,
        infinite: true,
        loop: true,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,
        swipeToSlide: true,
        autoplay: false,
        autoplaySpeed: 2000,
        adaptiveHeight: true
      }); 
    }
    // GALERIA DETALHE
    if ($('.slick-detalhe-grande').length) {
      $('.slick-detalhe-grande').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: false,
        autoplay: false,
        arrows: true,
        autoplaySpeed: 2000,
        responsiveHeight: true,
        asNavFor: '.slick-detalhe-thumb'
      });
    }
    if ($('.slick-detalhe-thumb').length) {
      $('.slick-detalhe-thumb').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slick-detalhe-grande',
        arrows: false,
        autoplay: true,
        autoplaySpeed: 2000,
        centerMode: true,
        focusOnSelect: true
      });
    }
    // se só tiver 1 thumb, remove o slick-thumb
    var qtd_slide = 0;
    $('.slick-detalhe-thumb').find('.slick-slide').each(function() {
      qtd_slide++;
    });
    if(qtd_slide <= 1){
      $('.slick-detalhe-thumb').css('display', 'none');
    }

    if ($('.slick-6itens').length) {
      $('.slick-6itens').slick({
        dots: false,
        arrows: true,
        infinite: true,
        loop: true,
        speed: 1400,
        slidesToShow: 6,
        slidesToScroll: 1,
        swipeToSlide: true,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 4
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 3
            }
          },
          {
            breakpoint: 670,
            settings: {
              slidesToShow: 2
            }
          },
          {
            breakpoint: 420,
            settings: {
              slidesToShow: 1
            }
          }
        ]
      });     
    }

    if ($('.slick-5itens').length) {
      $('.slick-5itens').slick({
        dots: false,
        arrows: true,
        infinite: true,
        loop: true,
        speed: 1400,
        slidesToShow: 5,
        slidesToScroll: 1,
        swipeToSlide: true,
        autoplay: true,
        autoplaySpeed: 10000,
        responsive: [
          {
            breakpoint: 1450,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 2
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1
            }
          }
        ]
      }); 
    }

    if ($('.slick-4itens').length) {
      $('.slick-4itens').slick({
        dots: true,
        arrows: false,
        infinite: true,
        loop: true,
        speed: 1400,
        slidesToShow: 4,
        slidesToScroll: 2,
        swipeToSlide: true,
        autoplay: true,
        autoplaySpeed: 5000,
        pauseOnHover: false,
        responsive: [
          {
            breakpoint: 1450,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1
            }
          }
        ]
      });
    }

    if ($('.slick-3itens').length) {
      $('.slick-3itens').slick({
        dots: false,
        arrows: true,
        infinite: true,
        loop: true,
        speed: 1400,
        slidesToShow: 3,
        slidesToScroll: 1,
        swipeToSlide: true,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
          {
            breakpoint: 670,
            settings: {
              slidesToShow: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1
            }
          }
        ]
      });
    }

    if ($('.slick-2itens').length) {
      $('.slick-2itens').slick({
        dots: true,
        arrows: false,
        infinite: true,
        loop: true,
        speed: 1400,
        slidesToShow: 2,
        slidesToScroll: 1,
        swipeToSlide: true,
        autoplay: false,
        autoplaySpeed: 2000,
        adaptiveHeight: true,
        responsive: [
          {
            breakpoint: 500,
            settings: {
              slidesToShow: 1
            }
          }
        ]
      }); 
    }

    if ($('.slick-1item').length) {
      $('.slick-1item').slick({
        dots: false,
        arrows: true,
        infinite: true,
        loop: true,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,
        swipeToSlide: true,
        autoplay: false,
        autoplaySpeed: 2000,
        adaptiveHeight: true
      }); 
    }
});