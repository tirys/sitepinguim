$(document).ready(function() {
  var container = $('body');
  container.css('display', 'none');
  container.fadeIn(1000);
  //$('.loading').fadeOut(500);

  //$('a[href$=".php"').click(function() {
  $('a[data-link]:not([href*="#"])').click(function(e) {
    e.preventDefault();
    newLocation = this.href;
    if (e && (e.which == 2 || e.button == 4 ) || $(this).attr('target') == '_blank') {
      window.open(newLocation,'_blank');
    }
    else{
      //$('.loading').fadeIn(500);
      container.fadeOut(1000, newpage);
    }
  });
  function newpage() {
    window.location = newLocation;
  }
});