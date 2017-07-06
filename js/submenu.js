$(document).ready(function() {
    $("#topo li:has(.submenu)").mouseenter(function(){
        var qtd_submenu = 0;
        var altura_submenu = 0;
        var submenu = $(this).children('.submenu');

        submenu.children('li').each(function() {
          qtd_submenu++;
          altura_submenu += $(this).height();
        });
        
        submenu.addClass('ativo').css('height', altura_submenu);

    }).mouseleave(function(){
        $(this).children('.submenu').removeClass('ativo').css('height', '0');
    });

		// MENU MOBILE
    if($(window).width() < 992){
      var menu = $('#topo .nav');
      var logo = $('#topo .logo');
      var botao_mobile = $('.botao-mobile');
      
      botao_mobile.click(function(){
        menu.toggleClass('ativo');
        logo.toggleClass('ativo');
        $(this).toggleClass('ti-menu');
      });
    }

});