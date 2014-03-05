include('js/jquery.easing.1.3.js');
include('js/jquery-ui-1.8.11.custom.min.js');
include('js/jquery.transform-0.9.3.min.js');
include('js/jquery.animate-colors-min.js');
include('js/jquery.backgroundpos.min.js');
include('js/mathUtils.js');
include('js/superfish.js');
include('js/switcher.js');
include('js/jquery.mousewheel.js');
include('js/sprites.js');
include('js/hoverSprite.js');
include('js/spin.js');
include('js/bgStretch.js');
include('js/sImg.js');
include('js/forms.js');
include('js/googleMap.js');
include('js/jquery.jqtransform.js');
include('js/jcarousellite_1.0.1.min.js');
include('js/jquery.fancybox-1.3.4.pack.js');

//----Include-Function----
function include(url){ 
  document.write('<script src="'+ url + '" type="text/javascript"></script>'); 
}
//--------global-------------
var isSplash = true;
var isAnim = true;
var isFirst = true;
var spinner;
var mapSpinner;
var MSIE = ($.browser.msie) && ($.browser.version <= 8)

//------DocReady-------------
$(document).ready(function(){ 
    if(location.hash.length == 0){
        location.hash="!/"+$('#content > ul > li:first-child').attr('id');
    }
    ///////////////////////////////////////////////////////////////////
        loaderInit();
function loaderInit(){
        var opts = {
              lines: 8,
              length: 0, 
              width: 16, 
              radius: 17, 
              rotate: 0, 
              color: '#fff', 
              speed: 1.3, 
              trail: 60, 
              shadow: false,
              hwaccel: false, 
              className: 'spinner', 
              zIndex: 2e9, 
              top: 'auto', 
              left: 'auto' 
        };
        var target = $(".page_spinner > span");
        spinner = new Spinner(opts).spin();
        target.append(spinner.el) 
        ///////////////////////////////////////    
            var opts2 = {
              lines: 8,
              length: 0, 
              width: 12, 
              radius: 18, 
              rotate: 10, 
              color: '#000', 
              speed: 1.3, 
              trail: 60, 
              shadow: false,
              hwaccel: false, 
              className: 'spinner', 
              zIndex: 2e9, 
              top: 'auto', 
              left: 'auto' 
        };
        var target2 = $(".google_map > span");
        mapSpinner = new Spinner(opts2).spin();
        target2.append(mapSpinner.el)  
} 
///////////////////////////////////////////////////////////////////

     $('ul#menu').superfish({
          delay:       500,
          animation:   {height:'show'},
          speed:       600,
          autoArrows:  false,
         dropShadows: false,
         	onInit: function(){
  				$("#menu > li > a").each(function(index){
  					var conText = $(this).find('.mText').text();
                    // $(this).append("<div class='_area'></div><div class='mTextOver'>"+conText+"</div>"); 
                    $(this).append("<div class='_area'></div><div class='_overPl'></div><div class='mText_over'>"+conText+"</div>");   
                    
  				})
  	 		}
        });
});
  
 //------WinLoad-------------  
$(window).load(function(){  

$(".followHolder > ul > li > a").hoverSprite({onLoadWebSite: true});
$(".btnHolder1 a").hoverSprite({onLoadWebSite: true});
$(".btnHolder2 a").hoverSprite({onLoadWebSite: true});
$(".btnHolder3 a").hoverSprite({onLoadWebSite: true});

$('.more').sprites({method:'gStretch', hover:true})

$('#form1').jqTransform({imgPath:'images/'});

     $("#jcarousel_1").jCarouselLite({
            btnNext: ".btnHolder1 > .nextBtn",
            btnPrev: ".btnHolder1 > .prevBtn",
            speed: 800,
            visible: 3
        });
    
     $("#jcarousel_2").jCarouselLite({
        btnNext: ".btnHolder2 > .nextBtn",
        btnPrev: ".btnHolder2 > .prevBtn",
        speed: 800,
        visible: 3
    });
    
     $("#jcarousel_3").jCarouselLite({
        btnNext: ".btnHolder3 > .nextBtn",
        btnPrev: ".btnHolder3 > .prevBtn",
        speed: 800,
        visible: 3
    });
    
    
 $('.pic').fancybox({'titlePosition': 'inside', 'overlayColor':'#000'}); 
$('.zoomSp').fadeTo(500, 0)
    $('.zoomSp').hover(function(){ $(this).stop().fadeTo(500, 0.6)	}, function(){$(this).stop().fadeTo(500, 0)})


  $('#bgStretch').bgStretch({
    align:'leftTop',
    navs:$('.navGall').navs()
    }).sImg({
            sleep: 1000,
            spinner:$('<div class="spinner_bg"></div>').css({opacity:1}).stop().hide(1000)
        }) 


 
var menuItems = $('#menu >li'); 

var currentIm = 0;
var lastIm = 0;

//setTimeout(navInit, 3000)
navInit();
function navInit(){
        var _curr = 0;
      $('.navGall > ul > li a').bind('click',function(e){
        if(isFirst==true){isFirst = false; loaderCreate();}
            if(!MSIE){
                $('.navGall > ul > li').eq(_curr).find('._over_marker').fadeOut(300);
                $('.navGall > ul > li').eq(_curr).find('._over').fadeIn(300);
            }else{
                $('.navGall > ul > li').eq(_curr).find('._over_marker').css({display:'none'});
                $('.navGall > ul > li').eq(_curr).find('._over').css({display:'block'});
            }
        
         
        _curr = $(this).parent().index(); 
        if(!MSIE){
            $('.navGall > ul > li').eq(_curr).find('._over_marker').fadeIn(300);
            $('.navGall > ul > li').eq(_curr).find('._over').fadeOut(300);
         }else{
            $('.navGall > ul > li').eq(_curr).find('._over_marker').css({display:'block'})
            $('.navGall > ul > li').eq(_curr).find('._over').css({display:'none'});
         }
    });
    
    if(!MSIE){
        $('.navGall > ul > li').find('._over_marker').fadeOut(1)
        $('.navGall > ul > li').eq(0).find('._over_marker').fadeIn(300)
        $('.navGall > ul > li').eq(0).find('._over').fadeOut(300)
    }else{
        $('.navGall > ul > li').find('._over_marker').css({display:'none'})
        $('.navGall > ul > li').eq(0).find('._over_marker').css({display:'block'})
        $('.navGall > ul > li').eq(0).find('._over').css({display:'none'})
    }
    
    $('.navGall > ul > li').hover(
        function(){
            if(_curr !== $(this).index()){
                if(!MSIE){
                    $(this).find('._over').fadeOut(300)
                    $(this).find('._over_marker').fadeIn(300)
                }else{
                    $(this).find('._over').css({display:'none'})
                    $(this).find('._over_marker').css({display:'block'})
                }
            }
        },
        function(){
            if(_curr !== $(this).index()){
                if(!MSIE){
                    $(this).find('._over').fadeIn(300)
                    $(this).find('._over_marker').fadeOut(300)
                }else{
                    $(this).find('._over').css({display:'block'})
                    $(this).find('._over_marker').css({display:'none'})
                }
            }
        }
    )
}

function loaderCreate(){
            var opts3 = {
                lines: 10,
              length: 0, 
              width: 20, 
              radius: 24, 
              rotate: 0, 
              color: '#1c1c1c', 
              speed: 1.3, 
              trail: 60, 
              shadow: false,
              hwaccel: false, 
              className: 'spinner', 
              zIndex: 2e9, 
              top: 'auto', 
              left: 'auto' 
        };
        var target3 = $(".spinner_bg");
        bgSpinner = new Spinner(opts3).spin();
        target3.append(bgSpinner.el)   
}

///////////////////////////////////////////////
    var navItems = $('.menu > ul >li');

    //$('.menu > ul >li').eq(0).css({'display':'none'});
	var content=$('#content'),
		nav=$('.menu');

    	$('#content').tabs({
		preFu:function(_){
			_.li.css({left:"-1700px",'display':'none'});
		}
		,actFu:function(_){			
			if(_.curr){
				_.curr.css({'display':'block', left:'1700px'}).stop().delay(200).animate({left:"0px"},700,'easeOutCubic');
                
                cont_resize(_.n);
                if ((_.n == 0) && ((_.pren>0) || (_.pren==undefined))){splashMode();}
                if (((_.pren == 0) || (_.pren == undefined)) && (_.n>0) ){contentMode(); }
            }
			if(_.prev){
			     _.prev.stop().animate({left:'-1700px'},700,'easeInOutCubic',function(){_.prev.css({'display':'none'});} );
             }
		}
	})
    

    function splashMode(){
        isSplash = true;
       //  $(".splash_menu > li").each( function(index){
         //   _delay = (index*100)+200;
         //   $(this).css({left:"1700px"}).stop().delay(_delay).animate({left:"0px"}, 900, 'easeOutCubic');
        // });
        $("header").animate({left:"330px"}, 800, 'easeInOutCubic')
      
    }
    
    function contentMode(){  
        isSplash = false;
         $("header").animate({left:"0px"}, 800, 'easeInOutCubic')
    }
    
    function cont_resize(_page){
        var li_W = $('#content > ul > li').eq(_page).find('.containerContent').innerHeight();
        if(li_W < 990){li_W = 990}
           // $('#content').stop().animate({height:li_W+"px"}, 400, 'easeInOutCubic').css({'overflow':'visible'}) 
            $('body').animate({'min-height':li_W+'px'},400)
    }		
    
    
	nav.navs({
			useHash:true,
             hoverIn:function(li){
                        $(".mText", li).stop(true).animate({top:'100px'}, 400, 'easeOutCubic');
                        $(".mText_over", li).stop(true).animate({top:'15px'}, 400, 'easeOutCubic');
                        $("._overPl", li).stop(true).animate({top:'0px'}, 400, 'easeOutCubic');
             },
                hoverOut:function(li){
                    if ((!li.hasClass('with_ul')) || (!li.hasClass('sfHover'))) {
                        $(".mText", li).stop(true).animate({top:'0px'}, 400, 'easeInOutCubic');
                        $(".mText_over", li).stop(true).animate({top:'-50px'}, 400, 'easeInOutCubic');
                        $("._overPl", li).stop(true).animate({top:'-110px'}, 400, 'easeInOutCubic');
                    } 
                } 
		}).navs(function(n){			
			$('#content').tabs(n);
		})
        
   

//////////////////////////////////////////
    
   	var h_cont;
  
	function centrRepos() {
         h_cont = $('.center').height();
        // $('body').animate({'min-height':h_cont+'px'},400)
		var h=$(window).height();
		if (h>(h_cont+40)) {
			m_top=~~(h-h_cont)/2;
			h_new=h;
		} else {
			m_top=20;
			h_new=h_cont+40;
		}
		//$('.center').stop().animate({'margin-top':m_top},600,'easeOutCubic');

	}
	centrRepos();
    ///////////Window resize///////
    
    function windowW() {
        return (($(window).width()>=parseInt($('body').css('minWidth')))?$(window).width():parseInt($('body').css('minWidth')));
    }
    
    
	$(window).resize(function(){
        centrRepos();
         
        }
    );

    } //window function
) //window load