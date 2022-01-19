<script>
  $(function() {
    $('#name').on('keyup', function(){
      let count_int = $(this).val().length
      $('.now_counter').text(count_int)

      if (count_int > 30){
        $('.btn-primary').prop('disabled', true);
        $('.btn-success').prop('disabled', true);
        $('#count_area').addClass('text-danger');
      } else {
        $('.btn-primary').prop('disabled', false);
        $('.btn-success').prop('disabled', false);
        $('#count_area').removeClass('text-danger');
      }
    })
  })
</script>