/*
 * based on fadeSlideShow v.2.2.0
 * Copyright (c) 2010 Pascal Bajorat (http://www.pascal-bajorat.com)
 * Dual licensed under the MIT and GPL (http://www.gnu.org/licenses/gpl.txt) licenses.
 * http://plugins.jquery.com/project/fadeslideshow
 */
jQuery.fn.fadeSlideShow=function(d){return this.each(function(){settings=jQuery.extend({width:250,height:230,speed:"slow",interval:3E3,autoplay:!0},d);jQuery(this).css({width:settings.width,height:settings.height,position:"relative",overflow:"hidden", margin:"auto"});jQuery("> *",this).css({position:"absolute",width:settings.width,height:settings.height});var b=jQuery("> *",this).length,a=b-=1,c=jQuery("> *",this);settings.autoplay&&function(){setInterval(function(){c.eq(a).fadeOut(settings.speed);0>=a?(c.fadeIn(settings.speed), a=b):a-=1},settings.interval)}()})};
jQuery.fn.justtext = function() {
    return jQuery(this).clone().children().remove().end().text();
};

function getsvn(){
	jQuery.ajax({
		url: "./svn_handler.php",
		dataType: "text",
		success: function (data){
			jQuery("#ros_svn_box").html(data);
		}
	});
}

jQuery(document).ready(function ($) {
	if($("#share_ros").length){
	$("#share_ros").socialSharePrivacy({perma_option: 0,order:["facebook","gplus","twitter","tumblr","reddit"],path_prefix:"/sites/all/themes/zen_reactos/ssp/",uri:"http://reactos.org",services:{flattr:{uid: "reactos"},twitter:{via: "reactos"},fbshare:{status:!1},pinterest:{status:!1},stumbleupon:{status:!1},mail:{status:!1}}});
	}
	if($("#block-views-random-screenshot-block").length){
	var slide;
    var i = 0;
    $('#block-views-random-screenshot-block > div').append('<div id="slideshow_window"></div>');
    $('#block-views-random-screenshot-block > div > div > div div').each(function () {
        slide = $(this).html();
        $("#slideshow_window").append('<div style="background-color: #fff">' + slide + '</div>');
        $(this).remove();
        i++;
    });
    $("#slideshow_window").fadeSlideShow();
	}
	if($("#quicktabs-reactos_news").length){
	$("#quicktabs-reactos_news").tabs({
	fx: [{},{opacity:'toggle', duration:'normal'}]
	}).tabs("rotate", 3000, true);
	$("#quicktabs-reactos_news").mouseover(function(){
            $(this).tabs('rotate', 0, false);
    });
    $("#quicktabs-reactos_news").mouseout(function(){
            $(this).tabs('rotate', 3000, true);
    });
	}
	if($("#ros_svn_box").length) getsvn();
});
