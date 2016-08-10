$(function() {
	var pxaBookmarkLinkPressed = false;
    $("#bookmark-link").on("click",function(e) {
    	e.preventDefault();
    	if(!pxaBookmarkLinkPressed) {
            var link = $(this);
    		var url = link.attr("href");
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
                        var textEl = link.find(".text");

                        if(textEl.length > 0) {
                            textEl.text(data.text);
                        }
                        var listLink = link.parent().find(".list-link");
                        if(listLink.length > 0) {
                            var nbr = listLink.find(".nmb"),
                                currentNbr = parseInt(nbr.text());

                            nbr.text(currentNbr + (link.hasClass("add") ? -1 : 1));
                        }
                    } else {
                        console.log('Error while adding/removing from bookmarks')
                    }

                    ajaxLoader.fadeOut('fast');
                }
            });
    	}
    });
});