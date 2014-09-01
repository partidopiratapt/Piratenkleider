jQuery(document).ready(function(){
  jQuery(".titulo_pre").click(function(){
    jQuery(".pre").toggle(1000, function() {
    if (jQuery(this).is(':visible')) {
          jQuery(".img_pre").rotate(90);
        } else {
          jQuery(".img_pre").rotate(0);
        }
    });
  });
  jQuery(".titulo_pt").click(function(){
    jQuery(".pt").toggle(1000, function() {
    if (jQuery(this).is(':visible')) {
          jQuery(".img_pt").rotate(90);
        } else {
          jQuery(".img_pt").rotate(0);
        }
    });
  });
  jQuery(".titulo_pp_lrvp").click(function(){
    jQuery(".lrvp").toggle(1000, function() {
    if (jQuery(this).is(':visible')) {
          jQuery(".img_pp_lrvp").rotate(90);
        } else {
          jQuery(".img_pp_lrvp").rotate(0);
        }
    });
  });
  jQuery(".titulo_pp_levp").click(function(){
    jQuery(".levp").toggle(1000, function() {
    if (jQuery(this).is(':visible')) {
          jQuery(".img_pp_levp").rotate(90);
        } else {
          jQuery(".img_pp_levp").rotate(0);
        }
    });
  });
  jQuery(".titulo_pc_da").click(function(){
    jQuery(".da").toggle(1000, function() {
    if (jQuery(this).is(':visible')) {
          jQuery(".img_pc_da").rotate(90);
        } else {
          jQuery(".img_pc_da").rotate(0);
        }
    });
  });
  jQuery(".titulo_pc_pa").click(function(){
    jQuery(".pa").toggle(1000, function() {
    if (jQuery(this).is(':visible')) {
          jQuery(".img_pc_pa").rotate(90);
        } else {
          jQuery(".img_pc_pa").rotate(0);
        }
    });
  });
  jQuery(".titulo_pc_mc").click(function(){
    jQuery(".mc").toggle(1000, function() {
    if (jQuery(this).is(':visible')) {
          jQuery(".img_pc_mc").rotate(90);
        } else {
          jQuery(".img_pc_mc").rotate(0);
        }
    });
  });
  jQuery(".titulo_pc_ca").click(function(){
    jQuery(".ca").toggle(1000, function() {
    if (jQuery(this).is(':visible')) {
          jQuery(".img_pc_ca").rotate(90);
        } else {
          jQuery(".img_pc_ca").rotate(0);
        }
    });
  });
});