function postForm( $form, callback ){
  var values = {};
  $.each( $form.serializeArray(), function(i, field) {
    values[field.name] = field.value;
  });
  $.ajax({
    type        : $form.attr( 'method' ),
    url         : $form.attr( 'action' ),
    data        : values,
    success     : function(data) {
      callback( data );
    }
  });
}

function clearResultsMessages() {
  $('.result').empty().removeClass('success').removeClass('error');
}

function bindRemoveAction(type)
{
  $('a.remove-' + type).click(function(e){
    e.preventDefault();
    clearResultsMessages();
    var el = $(this);
    
    console.log('1231');
    $.ajax({
      url         : el.attr( 'href' ),
      success     : function(data) {
        $('#' + type + '-wrapper .result.removing').html(data.msg);        
        if(data.success) {
          el.parent().remove();
          $('#' + type + '-wrapper .result.removing').addClass('success');
        } else
          $('#' + type + '-wrapper .result.removing').addClass('error');          
        }
    });
  });
}

function callbackNewCategory(response)
{
  $('#category-wrapper .result.creating').html(response.msg);
  if(response.success) {
    $('ul#category-list').append('<li>' + response.name + ' (<a href="'+ Routing.generate('la_net_back_admin_delete_master_category', {'id': response.id}, true) +'" class="remove-master-category">Удалить</a>)</li>')
    $('#category-wrapper .result.creating').addClass('success');
    $('#category-wrapper #master_category_name').val('');
    bindRemoveAction('master-category');
  } else {
   $('#category-wrapper .result.creating').addClass('error');
  }
}
function callbackNewPartnerType(response)
{
  $('#partner-type-wrapper .result.creating').html(response.msg);
  if(response.success) {
    $('ul#partner-type-list').append('<li>' + response.name + ' (<a href="'+ Routing.generate('sprout_back_admin_delete_partner_type', {'id': response.id}, true) +'" class="remove-partner-type">remove</a>)</li>')
    $('#partner-type-wrapper .result.creating').addClass('success');
    $('#partner-type-wrapper #partner_type_name').val('');
    bindRemoveAction('partner-type');
  } else {
   $('#partner-type-wrapper .result.creating').addClass('error');
  }
}

function hideShowInput () {
  if ($('select.category-list').val() == 'elseCategory') {
      $('input.new-category').parent().removeClass('hidden');
      $('input.new-category').prop('disabled', false);
    } else {
      $('input.new-category').parent().addClass('hidden');
      $('input.new-category').prop('disabled', true);
    }
}


$(document).ready(function(){
  
    $('a.remove-master').click(function() {
      var link = $(this);
      $.ajax({
        url: Routing.generate('la_net_admin_ajax_delete_master', {'id':link.attr('data')}),
        success     : function(data) {
                link.parents('.user-item').remove();
             }
        });
    });
   $('.users-filter').click(function(event){
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
   
   $('form[name="master_category"]').submit( function( e ){
    e.preventDefault();
    clearResultsMessages();
    postForm( $(this), callbackNewCategory );
    return false;
  });
  bindRemoveAction('master-category');
  
  $('form[name="partner_type"]').submit( function( e ){
    e.preventDefault();
    clearResultsMessages();
    postForm( $(this), callbackNewPartnerType );
    return false;
  });
  bindRemoveAction('partner-type');
  
  hideShowInput();
  $('select.category-list').change(function() {
    hideShowInput();
  });
});


