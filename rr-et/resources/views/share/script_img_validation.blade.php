<script>
  $("#script_img").on("change", function sizeVaridation() {
    const sizeInMegaBytes = this.files[0].size / 1024 / 1024;
    if (sizeInMegaBytes > 5) {
      alert("画像の容量は5MBまでです。他の画像を選択してください。");
      $("#script_img").val("");
    }
  });
</script>