/* accordion.js */
function getAccordion(a, e) {
    if ($(window).width() < e) {
        var o = "";
        obj_tabs = $(a + " li").toArray(), obj_cont = $(".tab-content .tab-pane").toArray(), jQuery.each(obj_tabs, function(a, e) {
            o += '<div id="' + a + '" class="panel panel-default">', o += '<div class="panel-heading" role="tab" id="heading' + a + '">', o += '<h4 class="panel-title main_acc"><a role="button" data-toggle="collapse" data-parent="#accordion_dashboard" href="#collapse' + a + '" aria-expanded="false" aria-controls="collapse' + a + '">' + e.innerText + "</a></h4>", o += "</div>", o += '<div id="collapse' + a + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + a + '">', o += '<div class="panel-body">' + obj_cont[a].innerHTML + "</div>", o += "</div>", o += "</div>"
        }), $("#accordion_dashboard").html(o), $("#accordion_dashboard").find(".panel-collapse:first").addClass("in"), $("#accordion_dashboard").find(".panel-default:nth-child(3)").addClass("bookingrefresh"),$("#accordion_dashboard").find(".panel-title a:first").attr("aria-expanded", "true"), $(a).remove(), $(".tab-content").remove()
      	// $(document).on('click','.panel-default',function(){$('#accordion_dashboard .panel-collapse').removeClass('show');});
      	$(document).on('click','.main_acc',function(){ 
			if($(this).attr('class') == 'panel-title main_acc'){
			  $('.main_acc').removeClass('active_panel');
			  $(this).toggleClass('active_panel');
			}else{
			   $(this).toggleClass('active_panel');
			   $('.main_acc').removeClass('active_panel');
			}
			$('#accordion_dashboard .panel-collapse').removeClass('show');
		});
    }
}