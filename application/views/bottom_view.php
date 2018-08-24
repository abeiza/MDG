<script>
  $(function(){
    var role = '<?php echo $this->session->userdata('role');?>';
    if(role == '1'){
      $("#menu_ms_users").show();
    }else if(role == '0'){
      $("#menu_ms_users").hide();
    }

    if('<?php echo $this->uri->segment(2);?>' == 'get_inbox'){
      $("#menu_inbox").css({'background-color':'#f9f9f9', 'color':'#d14836 !important','border-top-right-radius': '20px','border-bottom-right-radius': '20px','margin-left': '-10px','font-weight': 'bold'});
    }else if('<?php echo $this->uri->segment(2);?>' == 'get_outbox'){
      $("#menu_outbox").css({'background-color':'#f9f9f9', 'color':'#d14836 !important','border-top-right-radius': '20px','border-bottom-right-radius': '20px','margin-left': '-10px','font-weight': 'bold'});
    }else if('<?php echo $this->uri->segment(2);?>' == 'get_draft'){
      $("#menu_draft").css({'background-color':'#f9f9f9', 'color':'#d14836 !important','border-top-right-radius': '20px','border-bottom-right-radius': '20px','margin-left': '-10px','font-weight': 'bold'});
    }else if('<?php echo $this->uri->segment(2);?>' == 'get_ms_vendor'){
      $("#menu_ms_vendor").css({'background-color':'#f9f9f9', 'color':'#d14836 !important','border-top-right-radius': '20px','border-bottom-right-radius': '20px','margin-left': '-10px','font-weight': 'bold'});
    }else if('<?php echo $this->uri->segment(2);?>' == 'get_ms_customer'){
      $("#menu_ms_customer").css({'background-color':'#f9f9f9', 'color':'#d14836 !important','border-top-right-radius': '20px','border-bottom-right-radius': '20px','margin-left': '-10px','font-weight': 'bold'});
    }
  });
</script>
</html>
