
$(document).ready(function(){

  setTimeout(function(){
    shave('.breadcrumb a, .breadcrumb span', 20, {character: '...'});
  }, 100);

  if ($(window).width() > 768) {
    $('.bg-parallax').bgParallax();
    
   /* $('#sociais').parallax({
        relativeInput: true,
        clipRelativeInput: true,
        invertX: true,
        invertY: true,
        scalarX: 10,
        originX: -0.2,
        originY: -0.2,
        frictionY: .1
    });*/
  }

  
  var wowOffset = 250;
  if ($(window).width() < 1280) {
    wowOffset = 100;
  }
  var wow = new WOW(
    {
      boxClass:     'wow',      // animated element css class (default is wow)
      animateClass: 'animated', // animation css class (default is animated)
      offset:       wowOffset,  // distance to the element when triggering the animation (default is 0)
      mobile:       false,      // trigger animations on mobile devices (default is true)
      live:         true,       // act on asynchronously loaded content (default is true)
      callback:     function(box) {
        // the callback is fired every time an animation is started
        // the argument that is passed in is the DOM node being animated
      },
      scrollContainer: null // optional scroll container selector, otherwise use window
    }
  );    
  wow.init();

  /* TOPO FIXO */
  var topo = $("#topo");
  //topo.sticky();
  var botaoTopo = $("#totop");
  var windowScroll_t;


  function topoFixo () {
    if($(this).scrollTop() > 0 && topo.hasClass('topo-normal')){
      topo.removeClass('topo-normal').addClass('topo-fixo');
    } else if($(this).scrollTop() <= 0 && topo.hasClass('topo-fixo')){
      topo.removeClass('topo-fixo').addClass('topo-normal');
    }
  }
  //TOTOP
  $(window).scroll(function(){
    clearTimeout(windowScroll_t);
    windowScroll_t = setTimeout(function(){
        if($(this).scrollTop() > 0){
            botaoTopo.addClass('ativo');
        }else{
            botaoTopo.removeClass('ativo');
        }
    }, 300);
    //TOPO
    topoFixo();
  });
  botaoTopo.click(function(){
      $('html, body').animate({scrollTop: 0}, 600, 'easeInOutExpo');
      return false;
  });
  topoFixo();

  // SMOOTH SCROLLING - Code stolen from css-tricks for smooth scrolling:
  $('a[href*=#]:not([href=#]):not([data-toggle="collapse"]):not([data-toggle="modal"]):not([data-toggle="tab"]), a[data-link]').click(function(e) {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - $("#topo").outerHeight() //ALTURA DO TOPO
        }, 1000, 'easeInOutExpo');
        if ($('#toggle-nav').is(':checked')) {
          $('#toggle-nav').click();
        }
        return false;
      }
    }
    // else{
    //   e.preventDefault();
    //   newLocation = this.href;
    //   console.log(newLocation);
    //   if (e && (e.which == 2 || e.button == 4 ) || $(this).attr('target') == '_blank') {
    //     window.open(newLocation,'_blank');
    //   }
    //   else{
    //     $('.loading').fadeIn(500);
    //     container.fadeOut(1000, newpage);
    //   }
    // }
  });
  $('.rodape-mapa label').click(function(e) {
      $('html,body').animate({
        scrollTop: $('.rodape-mapa').offset().top - $(".header-menu").outerHeight() //ALTURA DO TOPO
      }, 1000);
      var text = $(this).text();
      $(this).text(text == "ver mapa ampliado" ? "diminuir mapa" : "ver mapa ampliado");
  });
    
  // fecha  popup no esc
  $(document).keyup(function(e) {
      if (e.keyCode == 27) {
        $('[id^="check-popup"]:checked').click();
        $('#toggle-nav:checked').click();
      }
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

  $('#data, #nascimento').focusout(function(){
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
  $(".floating-placeholder input, .floating-placeholder textarea").click(updateText);
  $(".floating-placeholder input, .floating-placeholder textarea").focus(updateText);

     //  Fancybox Gallery Images    
     $('.fancybox').fancybox({
        fitToView: true,
        width: '100%',
        height: '100%',
        autoSize: false,
        closeClick: true,
        cyclic: true,
        padding: 0
     });

    // GALERIA DETALHE
    if ($('.slick-detalhe-grande').length) {
      $('.slick-detalhe-grande').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: false,
        autoplay: false,
        arrows: true,
        autoplaySpeed: 2000,
        adaptiveHeight: true,
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
        focusOnSelect: true,
        adaptiveHeight: true,
        responsive: [
          {
            breakpoint: 767,
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
    // se só tiver 1 thumb, remove o slick-thumb
    var qtd_slide = 0;
    $('.slick-detalhe-thumb').find('.slick-slide').each(function() {
      qtd_slide++;
    });
    if(qtd_slide <= 1){
      $('.slick-detalhe-thumb').css('display', 'none');
    }

    if ($('.slick-7itens').length) {
      $('.slick-7itens').slick({
        dots: false,
        arrows: true,
        infinite: true,
        loop: true,
        speed: 1400,
        slidesToShow: 7,
        slidesToScroll: 1,
        swipeToSlide: true,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 5
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 4
            }
          },
          {
            breakpoint: 670,
            settings: {
              slidesToShow: 3
            }
          },
          {
            breakpoint: 420,
            settings: {
              slidesToShow: 2
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
        infinite: false,
        loop: false,
        speed: 1400,
        slidesToShow: 4,
        slidesToScroll: 2,
        swipeToSlide: true,
        autoplay: true,
        autoplaySpeed: 8000,
        pauseOnHover: true,
        responsive: [
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
            breakpoint: 700,
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
            breakpoint: 992,
            settings: {
              slidesToShow: 2
            }
          },
          {
            breakpoint: 768,
            settings: {
              dots: true,
              arrows: false,
              infinite: false,
              loop: false,
              slidesToShow: 1
            }
          }
        ]
      });
    }

    if ($('.slick-2itens').length) {
      $('.slick-2itens').slick({
        dots: false,
        arrows: true,
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
            breakpoint: 768,
            settings: {
              dots: true,
              arrows: false,
              infinite: false,
              loop: false,
              slidesToShow: 1
            }
          }
        ]
      }); 
    }

    if ($('.slick-1item').length) {
      $('.slick-1item').slick({
        dots: true,
        arrows: false,
        infinite: false,
        loop: false,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,
        swipeToSlide: true,
        fade: true,
        autoplay: false,
        adaptiveHeight: true,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              dots: true,
              arrows: false,
              infinite: false,
              loop: false
            }
          }
        ]
      }); 
    }
});