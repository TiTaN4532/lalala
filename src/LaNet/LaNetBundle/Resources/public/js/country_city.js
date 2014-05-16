$(document).ready(function() {
  $(document).on('change', '.country-list', function(e) {
      var divCounrty = $(this).parent('div');
      $('.region-list').parent('div').remove();
      $('.city-list').parent('div').remove();
      $.ajax({
        url: Routing.generate('la_net_lanet_location_regions', {'id':$(this).val()}),
        success     : function(data) {
              var regions = $('<select></select>').addClass('region-list').attr('name', 'fos_user_registration_form[userInfo][location][region]').attr('required','required');
              var html = '<option value="0">Выберите область</option>';
              
              for(var i = 0; i < data.length; i++) {
                html+= '<option value="' + data[i]['id'] + '">' + data[i]['name'] + '</option>';
              }
              regions.html(html);
              
              divCounrty.after(regions);
              regions.wrap('<div></div>').before('<label>Область:</label>');
             }
        });
  })
  
  $(document).on('change', '.region-list', function(e) {
      var divRegion = $(this).parent('div');
      $('.city-list').parent('div').remove();
      $.ajax({
        url: Routing.generate('la_net_lanet_location_cities', {'id':$(this).val()}),
        success     : function(data) {
              var cities = $('<select></select>').addClass('city-list').attr('name', 'fos_user_registration_form[userInfo][location][city]').attr('required','required');
              var html = '<option value="0">Выберите город</option>';
              
              for(var i = 0; i < data.length; i++) {
                html+= '<option value="' + data[i]['id'] + '">' + data[i]['name'] + '</option>';
              }
              cities.html(html);
              
              divRegion.after(cities);
              cities.wrap('<div></div>').before('<label>Город:</label>');
             }
        });
  })
  
});