$(function () {
  var like = $('.js-like-toggle');
  var likeScriptId;

  like.on('click',(function () {
    var $this = $(this);
    likeScriptId = $this.data('scriptid');
    $.ajax({
      Headers: {
        'X-CSRF-TOKEN': $('META[name="csrf-token"]').attr('content')
      },
      url: '/scripts/ajaxlike',
      type: 'POST',
      data: {
        'script_id': likeScriptId
      },
    })
    .done(function(data){
      $this.toggleClass('liked');
      $this.next('.likesCount').html(data.scriptLikesCount)
    })
    .fail(function (data, xhr, err) {
      console.log('エラー');
      console.log(err);
      console.log(xhr);
    });

  return false;
  }));
});