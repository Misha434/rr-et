<script>
  $(function() {
    $('#content').on('keyup', function(){
      let cnt = $(this).val().length
      $('.now_counter').text(cnt)

      if (cnt > 100){
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