$(document).ready(function(e){var width_menu=$('.slide_menu').width();$('.slide_button').on('click',function(){if($('.slide').hasClass('slide_left')){$('body').css('overflow-x','none');$('.slide').animate({left:'0px'},"slow",function(){$('.slide').removeClass('slide_left');$('.slide_menu').css('left','-'+width_menu+'px');});}else{$('body').css('overflow-x','hidden');$('.slide_menu').css('left','0').css('height',$(document).height()+'px');$('.slide').addClass('slide_left');$('.slide').animate({left:width_menu+'px'},"slow",function(){});}});$(document).on('click',".shop-like",function(e){var self=this;if($(this).hasClass("active"))$(this).removeClass("active").removeClass("animate")
else{$(this).addClass("animate");setTimeout(function(){$(self).addClass("active")},50);};});$(".items-scroller").each(function(index,element){var time=700;var itemsPane=$(this);var itemPerScreen=itemsPane.data("item-per-screen");var controls=itemsPane.data("controls");if(!itemPerScreen)itemPerScreen=5;var currentItem=0;var totalItems=$(this).find(".item").length;$(".control-next"+"."+controls).click(function(e){e.preventDefault();currentItem=currentItem+itemPerScreen;if(currentItem>totalItems-1||totalItems-1-currentItem<itemPerScreen)currentItem=totalItems-1;itemsPane.scrollTo('.item:eq('+currentItem+')',time)});$(".control-prev"+"."+controls).click(function(e){e.preventDefault();if(currentItem==totalItems-1)currentItem=currentItem-itemPerScreen*2+1;else
currentItem=currentItem-itemPerScreen;if(currentItem<=0){currentItem=0;itemsPane.scrollTo(0,time)}else
itemsPane.scrollTo('.item:eq('+currentItem+')',time)});});var delay=4000;var slides=$("#mp-slider .slide");var dotsContainer=$('<div class="dots-container"> </div>');$("#mp-slider").append(dotsContainer);slides.each(function(index,element){var dot=$('<span class="dot">&nbsp;</div>');dotsContainer.append(dot);dot.click(function(e){if(slideShowInterval)clearInterval(slideShowInterval);showSlide(index);});});var dots=$("#mp-slider .dots-container .dot");dots.eq(0).addClass("active");slides.eq(0).addClass("active");var slideShowInterval=setInterval(function(){var n=$("#mp-slider .slide.active").next().index();if(n>slides.length-1)n=0;showSlide(n);},delay)
function showSlide(n){slides.removeClass("active");dots.removeClass("active");slides.eq(n).addClass("active");dots.eq(n).addClass("active");}function showNext(){echo($("#mp-slider .slide.active").next().index());}});function echo(text){var debugWindow=$("#debug-window");if(!debugWindow.length){debugWindow=$('<div id="debug-window"></div>');$("body").append($('<div id="debug-window-container"></div>').append(debugWindow)).append("<style>\
		 #debug-window-container{ \
			position: fixed; \
			right: 10px; \
			bottom:0px; \
			width: 390px; \
			height: 200px; \
			z-index: 100000;\
			background-color: #000; \
			display: table-cell; \
			padding: 20px; \
			overflow:scroll; \
		} \
		\
		\
		#debug-window {\
			position:absolute;\
			bottom:0;\
			padding:20px;\
		}\
		 \
	</style>");}$("#debug-window").append(text+"<br>");}function getRandomInt(min,max){return Math.floor(Math.random()*(max-min+1))+min;}