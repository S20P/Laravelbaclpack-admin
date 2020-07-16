if ($(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        })
    }), sessionStorage.getItem("browser_session")) var last_session = sessionStorage.getItem("browser_session");
else {
    var new_session = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    sessionStorage.setItem("browser_session", new_session);
    last_session = new_session
}

function DoActionAnalytics(s, e, o, n, t) {
    if (console.log("Analytics function call"), sessionStorage.getItem("browser_session")) var r = sessionStorage.getItem("browser_session");
    else r = "null";
    var a = {
        slug: s,
        customer_id: e,
        supplier_services_id: o,
        analytics_event_type: n,
        image_url: t,
        browser_session: r
    };
    console.log("analytics-data", a), $.ajax({
        type: "POST",
        url: APP_URL + "/analytics/add",
        data: a,
        success: function(s) {
            console.log("success"), console.log(s)
        },
        error: function(s) {
            console.log("error"), console.log(s)
        }
    })
}
function DoActionSearch(c, s, e, l){
	if (console.log("Analytics function call"), sessionStorage.getItem("browser_session")) var r = sessionStorage.getItem("browser_session");
    else r = "null";
    var a = {
        customer_id: c,
        service_id: s,
        event_id: e,
        location_id: l,
        browser_session: r
    };
    console.log("analytics-data", a), $.ajax({
        type: "POST",
        url: APP_URL + "/analytics/search_add",
        data: a,
        success: function(s) {
            console.log("success"), console.log(s)
        },
        error: function(s) {
            console.log("error"), console.log(s)
        }
    })
}