<script>
$(function(){
  var role = '<?php echo $this->session->userdata('role');?>';
  if(role == '1'){
    $("#menu_ms_users").show();
  }else if(role == '0'){
    $("#menu_ms_users").hide();
  }

});
</script>
</html>
