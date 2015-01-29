$(function() {
	var pxaBookmarkLinkPressed = false;
    $("#bookmark-link").on("click",function(e) {
    	e.preventDefault();
    	if(!pxaBookmarkLinkPressed) {
            var link = $(this);
    		var url = link.attr("href");
            var className = link.attr("class");
            var ajaxLoader = link.parent().find(".ajax-loader");

            pxaBookmarkLinkPressed = true;
            ajaxLoader.fadeIn('fast');
    		$.ajax({
                type: "GET",
                url: url,
                dataType:"json",  
                success: function(data) {
                    if(data.status){
                        if(link.hasClass("add")) {
                            link.removeClass('add').addClass("remove").addClass("done");
                        } else {
                            link.removeClass("remove").addClass("add").addClass("done");
                        }
                        link.find(".text").text(data.text);
                    } else {
                        console.log('Error while adding/removing from bookmarks')
                    }

                    ajaxLoader.fadeOut('fast');
                }
            });
    	}
    });
});