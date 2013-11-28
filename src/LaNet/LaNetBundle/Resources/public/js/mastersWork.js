function hideShowInput () {
  if ($('select.category-list').val() == 'elseCategory') {
      $('input.new-category').parent().removeClass('hidden');
      $('input.new-category').prop('disabled', false);
    } else {
      $('input.new-category').parent().addClass('hidden');
      $('input.new-category').prop('disabled', true);
    }
}
$(document).ready(function() {
  hideShowInput();
  $('select.category-list').change(function() {
    hideShowInput();
  });
});