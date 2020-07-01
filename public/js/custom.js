function subscription()
{
	return $.ajax(
	{
		type: "post",
		headers:
		{
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
		},
		url: "customer_subscribe",
		data:
		{
			email: $("#newsletter_email").val()
		},
		success: function (e)
		{
			return 1 == e.success && ($.toast(
			{
				heading: "Success",
				text: e.message,
				showHideTransition: "fade",
				icon: "success",
				position: "top-right"
			}), $("#newsletter_email").val(""), !1)
		}
	}), !1
}

function validate(e)
{
	var s = e.split(".");
	if (s = s[s.length - 1].toLowerCase(), -1 == ["jpg", "jpeg", "png", "bmp", "gif", "svg"].lastIndexOf(s)) return $.toast(
	{
		heading: "Error",
		text: "Wrong extension type! Please upload jpg, png, gif, svg, bmp, jpeg file.",
		showHideTransition: "fade",
		icon: "error",
		position: "top-right"
	}), !1;
	$("#upload_profile_picture_form").submit()
}
var x, i, j, selElmnt, a, b, c;
for ($(".nav-icon").on("click", function ()
	{
		return $("nav.menu-items,.offcanvas-overly").addClass("active"), $(".login-form-content").removeClass("active"), $(".signup-form-content").removeClass("active"), $(".burger-menu ul li").addClass("fade"), setTimeout(function ()
		{
			$(".menu-items").addClass("shape-animation")
		}, 100)
	}), $(".menu-close").on("click", function ()
	{
		$("nav.menu-items,.offcanvas-overly").removeClass("active"), $(".burger-menu ul li").removeClass("fade"), $(".menu-items").removeClass("shape-animation")
	}), $(".category-slider").slick(
	{
		dots: !1,
		infinite: !0,
		autoplay: !0,
		speed: 300,
		autoplaySpeed: 1500,
		slidesToShow: 6,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 1024,
			settings:
			{
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: !0
			}
		},
		{
			breakpoint: 767,
			settings:
			{
				slidesToShow: 3,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 480,
			settings:
			{
				slidesToShow: 2,
				slidesToScroll: 1
			}
		}]
	}), $(".client-slider").slick(
	{
		dots: !1,
		infinite: !1,
		autoplay: !1,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 992,
			settings:
			{
				slidesToShow: 2,
				slidesToScroll: 1,
				infinite: !0
			}
		},
		{
			breakpoint: 768,
			settings:
			{
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 480,
			settings:
			{
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	}), $(".vendor-slider").slick(
	{
		dots: !1,
		infinite: !1,
		autoplay: !1,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 992,
			settings:
			{
				slidesToShow: 2,
				slidesToScroll: 1,
				infinite: !0
			}
		},
		{
			breakpoint: 768,
			settings:
			{
				slidesToShow: 2,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 480,
			settings:
			{
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	}), $(".company-slider").slick(
	{
		dots: !1,
		infinite: !0,
		speed: 500,
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: !0,
		autoplaySpeed: 2e3,
		arrows: !0
	}), $(".reviews-slider").slick(
	{
		dots: !1,
		infinite: !0,
		speed: 500,
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: !0,
		autoplaySpeed: 2e3,
		arrows: !0
	}), $(".gallery-slider").slick(
	{
		dots: !1,
		infinite: !1,
		autoplay: !1,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 992,
			settings:
			{
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: !0
			}
		},
		{
			breakpoint: 768,
			settings:
			{
				slidesToShow: 2,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 480,
			settings:
			{
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	}), $(".articles-slider").slick(
	{
		dots: !1,
		infinite: !1,
		autoplay: !1,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 992,
			settings:
			{
				slidesToShow: 2,
				slidesToScroll: 1,
				infinite: !0
			}
		},
		{
			breakpoint: 768,
			settings:
			{
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 480,
			settings:
			{
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	}), $(".offcanvas-overly").on("click", function (e)
	{
		return $(".signup-form-content, .offcanvas-overly").removeClass("active"), $(".login-form-content").removeClass("active"), $(".menu-items").removeClass("active"), $(".burger-menu ul li").removeClass("fade"),$(".email").val(""), $(".password").val(""), $('.error_login_main').empty(), $('.error_login_facebook').empty(), !1
	}), $(".sign-up").on("click", function ()
	{
		return $(".signup-form-content, .offcanvas-overly").addClass("active"), $(".login-form-content").removeClass("active"),$("nav.menu-items").removeClass("active"), !1
	}), $(".menu-close").on("click", function ()
	{
		$(".signup-form-content, .offcanvas-overly").removeClass("active")
	}), $(".login").on("click", function ()
	{
		return $(".login-form-content, .offcanvas-overly").addClass("active"), $(".signup-form-content").removeClass("active"),$("nav.menu-items").removeClass("active"), !1
	}), $(".menu-close").on("click", function ()
	{
		$(".login-form-content, .offcanvas-overly").removeClass("active"), $(".email").val(""), $(".password").val(""), $('.error_login_main').empty(), $('.error_login_facebook').empty()
	}), wow = new WOW(
	{
		boxClass: "wow",
		animateClass: "animated",
		offset: 0,
		mobile: !0,
		live: !0
	}), wow.init(), $(".upload_profile").off().on("click", function ()
	{
		$("#upload_profile").click()
	}), $(document).on("click",'.account_inquiry_submit', function ()
	{
		var e = $(this),
			s = $(this).parent().find(".customer_id").val(),
			i = $(this).parent().find(".message_account_reply").val(),
			t = $(this).parent().find(".supplier_service_id").val();
		if (0 != $(this).parent().find(".customer_reply").length) var o = APP_URL + "/customer/customer_addreply";
		else o = APP_URL + "/supplier/supplier_addreply";
		if ("" == i) return $.toast(
		{
			heading: "Error",
			text: "Please enter your message",
			showHideTransition: "fade",
			icon: "error",
			position: "top-right"
		}), !1;
		$(".loader").removeClass("hide"), $.ajax(
		{
			type: "post",
			url: o,
			headers:
			{
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
			},
			data:
			{
				customer_id: s,
				supplier_service_id: t,
				message: i
			},
			success: function (s)
			{
				if ($(".message_account_reply").val(""), 1 != s.success) return $.toast(
				{
					heading: "Error",
					text: "Something went to wrong.",
					showHideTransition: "fade",
					icon: "error",
					position: "top-right"
				}), $(".loader").addClass("hide"), !1;
				e.parents(".card-body").children(".conversion").append(s.html), $(".loader").addClass("hide")
			}
		})
	}), $(document).on("click",".invoice_form_btn", function (e)
	{
		$(".sendinvoicefrom").validate().resetForm(), $(".sendinvoicefrom").trigger("reset"), $(this);
		var s = $(this).parent().find(".supplier_service_id").val(),
			i = $(this).parent().find(".service_id").val(),
			t = $(this).parent().find(".service_name").val(),
			o = $(this).parent().find(".customer_id").val();
		$(".sendinvoicefrom").find(".supplier_service_id").val(s), $(".sendinvoicefrom").find(".service_id").val(i), $(".sendinvoicefrom").find(".service_name").val(t), $(".sendinvoicefrom").find(".customer_id").val(o), $("#invoice").modal("show")
	}), $("#confirm-delete-booking").on("show.bs.modal", function (e)
	{
		$(this).find(".btn-ok").attr("href", $(e.relatedTarget).data("href")), $("#delete_booking_form").attr("action", $(this).find(".btn-ok").attr("href"))
	}), $("#confirm-delete-wish").on("show.bs.modal", function (e)
	{
		$(this).find(".btn-ok").attr("href", $(e.relatedTarget).data("href")), $("#delete_wish_form").attr("action", $(this).find(".btn-ok").attr("href"))
	}), $(document).on('click','#account_email_edit',function ()
	{
		$(this).parent().find("input").removeAttr("disabled"), $("#account_email_save").removeClass("hide"), $(this).addClass("hide"), $("#customer_account_change_email_form").children(".account-input").addClass("focus-block"), $("#customer_account_change_email_form").children(".account-input").children("#email").focus(), $("#supplier_account_change_email_form").children(".account-input").addClass("focus-block"), $("#supplier_account_change_email_form").children(".account-input").children("#email").focus()
	}), $(document).on('click','#account_pass_edit',function ()
	{
		$(this).parent().find("input").removeAttr("disabled"), $("#account_pass_save").removeClass("hide"), $(this).addClass("hide"), $("#customer_account_change_password_form").children(".account-input").addClass("focus-block"), $("#customer_account_change_password_form").children(".account-input").children("#password").focus(), $("#supplier_account_change_password_form").children(".account-input").addClass("focus-block"), $("#supplier_account_change_password_form").children(".account-input").children("#password").focus()
	}), $(document).on('click','#account_mob_edit',function ()
	{
		$(this).parent().find("input").removeAttr("disabled"), $("#account_mob_save").removeClass("hide"), $(this).addClass("hide"), $("#customer_account_change_phone_form").children(".account-input").addClass("focus-block"), $("#customer_account_change_phone_form").children(".account-input").children("#phone").focus(), $("#supplier_account_change_phone_form").children(".account-input").addClass("focus-block"), $("#supplier_account_change_phone_form").children(".account-input").children("#phone").focus()
	}), $(document).on('click','.wishlist_tab',function ()
	{
		$(".tab-pane").removeClass("active show"), $("#wishlist").addClass("active show"), $(".nav-link").removeClass("active"), $("#wishlist_tab_btn").addClass("active"),$('#accordion_dashboard .panel-collapse').removeClass('show'),$(".customer_dashboard").find(".panel-default:nth-child(5)").children('.panel-collapse').addClass('show'), getCustomerWishlist("add"),$(".customer_dashboard").find(".panel-default:nth-child(5)").find('.panel-title').addClass('active_panel')
	}), $(document).on('click','#edit_account_profile',function ()
	{
		$(".tab-pane").removeClass("active show"), $("#profile").addClass("active show"), $(".nav-link").removeClass("active"), $(".profile").children(".nav-link").addClass("active"),$('#accordion_dashboard .panel-collapse').removeClass('show'),$("#accordion_dashboard").find(".panel-default:nth-child(1)").children('.panel-collapse').addClass('show'),$("#accordion_dashboard").find(".panel-default:nth-child(1)").find('.panel-title').addClass('active_panel')
	}), "FrontEnd_pages_BrowseSuppliers" == $("body").attr("class") && $(".browse_suppliers").addClass("active"), "FrontEnd_pages_BecomeSupplier" == $("body").attr("class") && $(".becomesupplier").addClass("active"), "FrontEnd_pages_Help" == $("body").attr("class") && $(".help_page").addClass("active"), "FrontEnd_pages_OurStory" == $("body").attr("class") && $(".our_story").addClass("active"), "FrontEnd_pages_OurSuppliers" == $("body").attr("class") && $(".our_suppliers").addClass("active"), "FrontEnd_pages_contacts" == $("body").attr("class") && $(".contact_us").addClass("active"), "FrontEnd_pages_Blog" == $("body").attr("class") && $(".blog_page").addClass("active"), "FrontEnd_pages_Faq" == $("body").attr("class") && $(".faq_page").addClass("active"), "FrontEnd_pages_SupplierTackandCare" == $("body").attr("class") && $(".tak_care_page").addClass("active"), $(".js-example-tokenizer").select2(
	{
		tags: !0,
		tokenSeparators: [",", " "]
	}), $("#booking_supplier_service_id").on("change", function (e)
	{
		var s = e.target.value;
		console.log("booking_supplier_service_id", s), $.get(APP_URL + "/events-by-supplier-service/" + s, function (e)
		{
			if (console.log("events---", e.length), e.length > 0)
				for (var s = 0; s < e.length; s++) $("#event_id").empty(), $("#event_id").append('<option value="' + e[s].event_id + '">' + e[s].event_name + "</option>");
			else $("#event_id").append('<option value="">Event Not Found !</option>')
		})
	}), $("body").on("click", "#add_booking", function ()
	{
		console.log("Add Booking Manual form"), $(".booking_add_form").validate().resetForm(), $(".booking_add_form").trigger("reset"),
		$("#status_1").attr('checked', 'checked');
		$("#status_2").attr('checked', false);
		$("#status_3").attr('checked', false);
		$("#booking_add_model").modal("show")
	}), $("body").on("click", "#edit_booking", function ()
	{
		var e = $(this).data("id");
		$(".booking_update").validate().resetForm(), $.get(APP_URL + "/booking/edit/" + e, function (e)
		{
			  
			var status_1_val = $("#status_1_edit").val();
			var status_2_val = $("#status_2_edit").val();
			var status_3_val = $("#status_3_edit").val();
			
               if(e.status==status_2_val){
				console.log("hold",e.status);	
				$("#status_2_edit").attr('checked', 'checked');
			   }
			   else if(e.status==status_3_val){
				console.log("complete",e.status);	
				$("#status_3_edit").attr('checked', 'checked');
			   }
			   else{
				console.log("pending",e.status);	
				$("#status_1_edit").attr('checked', 'checked');
				}


			$(".edit_booking_id").val(e.id), $(".edit_booking_date").val(e.booking_date), $(".edit_event_address").val(e.event_address), $(".edit_amount").val(e.amount), $(".edit_supplier_services_id").val(e.service_name), $(".edit_event_id").val(e.event_name)
		}), $("#booking_edit_model").modal("show")
	}), $("body").on("click", "#delete_booking", function ()
	{
		var e = $(this).data("id");
		$(".booking_deleted_id").val(e), $("#confirm-delete-booking").modal("show")
	}), $("body").on("click", "#delete_wish", function ()
	{
		var e = $(this).data("id");
		$(".wish_deleted_id").val(e), $("#confirm-delete-wish").modal("show")
	}), $(document).on('submit','#delete_booking_form',function (e)
	{
		e.preventDefault();
		var s = $(".booking_deleted_id").val(),
			i = APP_URL + "/booking/remove/" + s;
		$.ajax(
		{
			type: "POST",
			url: i,
			success: function (e)
			{
				$("#booking_id_" + s).remove(), $("#confirm-delete-booking").modal("hide"), getCustomerBooking("add"), e.success ? $.toast(
				{
					heading: "Success",
					text: e.success,
					position: "top-right",
					stack: !1,
					icon: "success"
				}) : $.toast(
				{
					heading: "Success",
					text: e.error,
					position: "top-right",
					stack: !1,
					icon: "error"
				})
			}
		})
	}), 
	$(document).on('submit','#delete_wish_form',function (e)
	{
		e.preventDefault();
		var s = $(".wish_deleted_id").val(),
			i = APP_URL + "/customer/wishlist_remove/" + s;
		$.ajax(
		{
			type: "POST",
			url: i,
			success: function (e)
			{
				$("#wishlist_id_" + s).remove(), $("#confirm-delete-wish").modal("hide"), getCustomerWishlist("add"), e.success ? $.toast(
				{
					heading: "Success",
					text: e.success,
					position: "top-right",
					stack: !1,
					icon: "success"
				}) : $.toast(
				{
					heading: "Success",
					text: e.error,
					position: "top-right",
					stack: !1,
					icon: "error"
				})
			}
		})
	}), $(document).on("click", "#edit_supplier_services", function ()
	{
		var e = $(this).data("id");
		$(".supplier_services_update_form").validate().resetForm(), $.get(APP_URL + "/supplier-services/edit/" + e, function (e)
		{

			location_api = APP_URL + "/locations";
			var locations = [];
			$.ajax(
			{
				type: "GET",
				url: location_api,
				success: function (data)
				{
					
					
					var l = e.location;
					if(l){
						l = JSON.parse(l);
					}
					else{
						l = [];
					}
			
						if(l.length>0){
							
							for (var i = data, dom = '<select name="location[]" id="locations" multiple=""><option disabled="disabled" selected>Select location</option>', o = 0; o < i.length; o++)
				         	{
								 var temp;
								for(var l_index=0;l_index<l.length;l_index++){
					         	if(i[o].id == l[l_index]){
							    		 temp = l[l_index];
								dom += '<option value="' + i[o].id + '" ' + (i[o].id == l[l_index] ? "selected" : "") + " >" +i[o].location_name + "</option>"
								}
								}
								if(i[o].id !=temp){

									dom += '<option value="' + i[o].id + '" '  + " >" + i[o].location_name + "</option>";
									
								}
						  }
						}
					
						dom += "</select>", $("#locations").html(dom)
				}
			});

			console.log("location",e.location);
			console.log("supplier_services_edit-data", e), $(".edit_supplier_service_id").val(e.id), $(".edit_service_name").val(e.service_name), $(".edit_event_name").val(e.event_name), $(".edit_business_name").val(e.business_name), $(".edit_service_description").val(e.service_description), $(".edit_facebook_title").val(e.facebook_title), $(".edit_facebook_link").val(e.facebook_link), $(".edit_instagram_title").val(e.instagram_title), $(".edit_instagram_link").val(e.instagram_link);
			var s = e.price_range;
			console.log("price_range", s);
			for (var i = ["Low", "Medium", "High"], t = '<select name="price_range" id="price_range" ><option disabled="disabled" selected>Select Price Range</option>', o = 0; o < i.length; o++)
			{
				var n = o + 1;
				t += '<option value="' + n + '" ' + (n == s ? "selected" : "") + " >" + i[o] + "</option>"
			}
			t += "</select>", $("#price_range").html(t)

		}), $("#edit_supplier_services_model").modal("show")
	}), $("body").on("click", "#delete_supplier_services", function ()
	{
		var e = $(this).data("id");
		$(".supplier_service_deleted_id").val(e), $("#confirm-delete-supplierService").modal("show")
	}), $(document).on('submit','#delete_supplier_services_form',function (e)
	{
		e.preventDefault();
		var s = $(".supplier_service_deleted_id").val(),
			i = APP_URL + "/supplier_services/remove/" + s;
		$.ajax(
		{
			type: "POST",
			url: i,
			success: function (e)
			{
				$("#supplier_services_crud_id_" + s).remove(), $("#confirm-delete-supplierService").modal("hide"), e.success ? $.toast(
				{
					heading: "Success",
					text: e.success,
					position: "top-right",
					stack: !1,
					icon: "success"
				}) : $.toast(
				{
					heading: "Success",
					text: e.error,
					position: "top-right",
					stack: !1,
					icon: "error"
				})
			}
		})
	}), $("body").on("click", "#edit_services_slider", function ()
	{
		var e = $(this).data("id");
           
           serviceSliderData(e);

		   $("#add_slide_section").hide();
		$("#edit_services_slider_model").modal("show")

	}), $("#remember2").change(function ()
	{
		this.checked ? ($("#desk_submit_supplier").removeAttr("disabled"), $("#desk_submit_supplier").removeClass("disabled")) : ($("#desk_submit_supplier").attr("disabled", "disabled"), $("#desk_submit_supplier").addClass("disabled"))
	}), $.validator.setDefaults(
	{
		ignore: ":hidden:not(select)"
	}), $("#remember").change(function ()
	{
		this.checked ? ($("#mobile_submit_supplier").removeAttr("disabled"), $("#mobile_submit_supplier").removeClass("disabled")) : ($("#mobile_submit_supplier").attr("disabled", "disabled"), $("#mobile_submit_supplier").addClass("disabled"))
	}), $("#remember_customer").change(function ()
	{
		this.checked ? ($("#customer_signup_submit").removeAttr("disabled"), $("#customer_signup_submit").removeClass("disabled")) : ($("#customer_signup_submit").attr("disabled", "disabled"), $("#customer_signup_submit").addClass("disabled"))
	}), x = document.getElementsByClassName("custom-select"), i = 0; i < x.length; i++)
{
	for (selElmnt = x[i].getElementsByTagName("select")[0], (a = document.createElement("DIV")).setAttribute("class", "select-selected"), a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML, x[i].appendChild(a), (b = document.createElement("DIV")).setAttribute("class", "select-items select-hide"), j = 1; j < selElmnt.length; j++)(c = document.createElement("DIV")).innerHTML = selElmnt.options[j].innerHTML, c.addEventListener("click", function (e)
	{
		var s, i, t, o, n;
		for (o = this.parentNode.parentNode.getElementsByTagName("select")[0], n = this.parentNode.previousSibling, i = 0; i < o.length; i++)
			if (o.options[i].innerHTML == this.innerHTML)
			{
				for (o.selectedIndex = i, n.innerHTML = this.innerHTML, s = this.parentNode.getElementsByClassName("same-as-selected"), t = 0; t < s.length; t++) s[t].removeAttribute("class");
				this.setAttribute("class", "same-as-selected");
				break
			} n.click()
	}), b.appendChild(c);
	x[i].appendChild(b), a.addEventListener("click", function (e)
	{
		e.stopPropagation(), closeAllSelect(this), this.nextSibling.classList.toggle("select-hide"), this.classList.toggle("select-arrow-active")
	})
}

function closeAllSelect(e)
{
	var s, i, t, o = [];
	for (s = document.getElementsByClassName("select-items"), i = document.getElementsByClassName("select-selected"), t = 0; t < i.length; t++) e == i[t] ? o.push(t) : i[t].classList.remove("select-arrow-active");
	for (t = 0; t < s.length; t++) o.indexOf(t) && s[t].classList.add("select-hide")
}
document.addEventListener("click", closeAllSelect), getAccordion("#dashboard-tabs", 768);
$(document).ready(function () {
	getCustomerWishlist("add");
});




function serviceSliderData(e){
console.log("1",e);
$(".edit_service_slide_id").val(e);
	$(".services_slider_form").validate().resetForm(), $("#image-upload").val(""), $.get(APP_URL + "/service-slider/edit/" + e, function (data)
	{
		console.log("supplier_services_slider-edit-data", data);
		if(data.length>0){
			var SliderData = "";
			var status = '';
			var content = "";
			for(var i=0;i<data.length;i++){
				
				if(data[i].content){
					content = truncate(data[i].content,6);
				}		

			  SliderData += '<tr id="slide_id_' + data[i].id + '"><td>' + data[i].heading + '</td><td>' + content + '</td><td><img width="150px" src="'+ APP_URL+data[i].image +'"></td>';
			  SliderData += '<td colspan="2"><a href="javascript:void(0)" id="delete_slide" data-id="' + data[i].id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>';
		  
			}
			$("#slider-crud").html(SliderData);
		  
		  } else{
			$("#slider-crud").html('<tr><td colspan="6"><p class="text-danger">No Slide available.</p></td></tr>');
		  }
	
		
		
	});
}


function truncate(str, no_words) {
    return str.split(" ").splice(0,no_words).join(" ");
}




$(function() {
     var path = window.location.href;
     var pathSub = path.substring(path.lastIndexOf("/") + 1, path.length)

     if(pathSub == "#messenger"){
			$("a#messenger-tab-menu").trigger("click");
    }else if(window.location.hash=="#messenger"){
		$("a#messenger-tab-menu").trigger("click");
	}

	$("body").on("click", "#add_slide_btn", function ()
	{
	console.log("add slide form open");
	$("#add_slide_section").show();
	});

	$("body").on("click", "#delete_slide", function ()
	{
		var slide_id = $(this).data("id");
		console.log("Delete-slide-id",slide_id);

		i = APP_URL + "/service_slider/delete/" + slide_id;
		$.ajax(
		{
			type: "POST",
			url: i,
			success: function (e)
			{
				$("#slide_id_" + slide_id).remove(),$("#edit_services_slider_model").modal("hide"),e.success ? $.toast(
				{
					heading: "Success",
					text: e.success,
					position: "top-right",
					stack: !1,
					icon: "success"
				}) : $.toast(
				{
					heading: "Success",
					text: e.error,
					position: "top-right",
					stack: !1,
					icon: "error"
				})
			}
		})

	});


}) 