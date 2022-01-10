<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script type="text/javascript">
  $('ul.pagination').hide();
  $(function() {
    $('.infinite-scroll').jscroll({
      loadingHtml: '<div class="d-flex justify-content-center  text-secondary"><strong>Loading...</strong><div class="spinner-grow ml-auto" role="status"></div></div>',
      autoTrigger: true,
      padding: 0,
      nextSelector: '.pagination li.active + li a',
      contentSelector: 'div.infinite-scroll',
      callback: function() {
        $('ul.pagination').remove();
      }
    });
  });
</script>