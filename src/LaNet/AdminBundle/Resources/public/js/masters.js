$(document).ready(function(){
   $('.users-filter').click(function(){
      event.preventDefault();
      var link = $(this);
      $.ajax({
        url: Routing.generate('la_net_admin_masters_ajax', {'filter':$(this).attr('data')}),
        success     : function(data) {
                $('#users-list').html(data);
                $('.active-link').removeClass('active-link');
                link.addClass('active-link');
             }
        });
   }); 
});
