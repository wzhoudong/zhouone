//html root的字体计算应该放在最前面，这样计算就不会有误差了/
 //2016.3.23 wjq update 之所以要加个判断返回一个20.5，是因为当用户在谷歌等浏览器直接输入手机端网站网址时，如果用户设置模块自定义样式的高度比较小，由于这时候的clientWidth为1920px，及返回的_htmlFontSize为40，这时候就会使模块太小，展示不完全，因此先取一个较为准确的值去展示。Mobi.resetHtmlFontSize()顺便也加了
 var _htmlFontSize = (function() {
     var clientWidth = document.documentElement ? document.documentElement.clientWidth : document.body.clientWidth;
     if (clientWidth > 640) clientWidth = 640;
     document.documentElement.style.fontSize = clientWidth * 1 / 16 + "px";
     return clientWidth * 1 / 16;
 })();
function getQueryString(key){
    var reg = new RegExp("(^|&)"+key+"=([^&]*)(&|$)");
    var result = window.location.search.substr(1).match(reg);
    return result?decodeURIComponent(result[2]):null;
  }
 //imgshow.html  banner
if($('div').hasClass('imgshow')){ 
var cid = getQueryString("cid");
var name = getQueryString("name");
$(".titlename").text(name);
$.ajax({
type:"GET", 
url:"http://m.pc6.sjhiis.jf95.com/ajax.asp?action=990&cid="+cid+"", 
dataType:"json", 
success:function(data){ 
var music=""; 
//i表示在data中的索引位置n表示包含的信息的对象
$.each(data.list,function(i, n) {
//获取对象中属性optionsValue的值
music+="<li> <img src='"+n.path+"'></li>"; 
}); 
$('.imgshow ul').append(music);
banner()
} 
}); 
}
 //banner
function banner(){
if($('div').hasClass('bag_show')){swipe(".bag_show", 0)}
if($('div').hasClass('imgshow')){swipe(".imgshow", 0)}
function swipe(o, loop) {
    var o = $(o),
        ul = o.find("ul"),
        li = ul.find("li"),
        olen = li.length,
        loop = (loop == 1) ? true : false,      
        start = 0,
        end = 0;
    ul.css({"transition-duration": "0.5s"});
    li.css("width", o.width());
    // 点
    o.append("<div class='swipe-pagenation'>1/" + olen + "</div>");
    var page = $(".swipe-pagenation");
    //循环
    if (loop) {
        ul.append(ul.html());
        olen = olen * 2;
    }
    var li = ul.find("li");
    li.eq(0).addClass('active');
    len = olen;
    //自动
   var timer = setInterval(auto, 3000)
    function auto() {

        index = o.find("li.active").index();
        index = ((index + 1) >= len) ? index : index + 1;
        swipe_scroll(index);
    }
    //滑动

    o.bind('touchstart', function(e) {
        start = (e.changedTouches || e.originalEvent.changedTouches)[0].pageX;
    });
    o.bind('touchend', function(e) {

        end = (e.changedTouches || e.originalEvent.changedTouches)[0].pageX;
        var diff = end - start;
        if (diff < 0) { //左
            //当前显示的下标
            var index = o.find("li.active").index();
            index = ((index + 1) >= len) ? index : index + 1;
            clearInterval(timer);
            swipe_scroll(index);



        } else if (diff > 0) {
            //当前显示的下标
            var index = o.find("li.active").index();
            index = ((index - 1) < 0) ? index : index - 1;
            clearInterval(timer);
            swipe_scroll(index);
        }
    });
    function swipe_scroll(index) {
        $('div').removeClass('active')
        ul.css("transform", "translate3d(" + (-(li.width() * index)) + "px,0,0)");
        li.eq(index).addClass('active').siblings().removeClass('active');
        page.text((index + 1) + "/" + olen);
    }
}
}
 
//加载
! function(a) {
    "use strict";

    function g(a) { a.touches || (a.touches = a.originalEvent.touches) }

    function h(a, b) { b._startY = a.touches[0].pageY, b.touchScrollTop = b.$scrollArea.scrollTop() }

    function i(b, c) {
        c._curY = b.touches[0].pageY, c._moveY = c._curY - c._startY, c._moveY > 0 ? c.direction = "down" : c._moveY < 0 && (c.direction = "up");
        var d = Math.abs(c._moveY);
        "" != c.opts.loadUpFn && c.touchScrollTop <= 0 && "down" == c.direction && !c.isLockUp && (b.preventDefault(), c.$domUp = a("." + c.opts.domUp.domClass), c.upInsertDOM || (c.$element.prepend('<div class="' + c.opts.domUp.domClass + '"></div>'), c.upInsertDOM = !0), n(c.$domUp, 0), d <= c.opts.distance ? (c._offsetY = d, c.$domUp.html(c.opts.domUp.domRefresh)) : d > c.opts.distance && d <= 2 * c.opts.distance ? (c._offsetY = c.opts.distance + .5 * (d - c.opts.distance), c.$domUp.html(c.opts.domUp.domUpdate)) : c._offsetY = c.opts.distance + .5 * c.opts.distance + .2 * (d - 2 * c.opts.distance), c.$domUp.css({ height: c._offsetY }))
    }

    function j(b) {
        var c = Math.abs(b._moveY);
        "" != b.opts.loadUpFn && b.touchScrollTop <= 0 && "down" == b.direction && !b.isLockUp && (n(b.$domUp, 300), c > b.opts.distance ? (b.$domUp.css({ height: b.$domUp.children().height() }), b.$domUp.html(b.opts.domUp.domLoad), b.loading = !0, b.opts.loadUpFn(b)) : b.$domUp.css({ height: "0" }).on("webkitTransitionEnd mozTransitionEnd transitionend", function() { b.upInsertDOM = !1, a(this).remove() }), b._moveY = 0)
    }

    function k(a) { a.opts.autoLoad && a._scrollContentHeight - a._threshold <= a._scrollWindowHeight && m(a) }

    function l(a) { a._scrollContentHeight = a.opts.scrollArea == b ? e.height() : a.$element[0].scrollHeight }

    function m(a) { a.direction = "up", a.$domDown.html(a.opts.domDown.domLoad), a.loading = !0, a.opts.loadDownFn(a) }

    function n(a, b) { a.css({ "-webkit-transition": "all " + b + "ms", transition: "all " + b + "ms" }) }
    var f, b = window,
        c = document,
        d = a(b),
        e = a(c);
    a.fn.dropload = function(a) {
        return new f(this, a)
    }, f = function(a, b) {
        var c = this;
        c.$element = a, c.upInsertDOM = !1, c.loading = !1, c.isLockUp = !1, c.isLockDown = !1, c.isData = !0, c._scrollTop = 0, c._threshold = 0, c.init(b)
    }, f.prototype.init = function(f) {
        var l = this;
        l.opts = a.extend(!0, {}, { scrollArea: l.$element, domUp: { domClass: "dropload-up", domRefresh: '<div class="dropload-refresh">↓下拉刷新</div>', domUpdate: '<div class="dropload-update">↑释放更新</div>', domLoad: '<div class="dropload-load"><span class="loading"></span>加载中...</div>' }, domDown: { domClass: "dropload-down", domRefresh: '↑上拉加载更多', domLoad: '<div class="dropload-load"><span class="loading"></span>加载中...</div>', domNoData: '暂无数据' }, autoLoad: !0, distance: 50, threshold: "", loadUpFn: "", loadDownFn: "" }, f), "" != l.opts.loadDownFn && (l.$element.append('<div class="' + l.opts.domDown.domClass + '">' + l.opts.domDown.domRefresh + "</div>"), l.$domDown = a("." + l.opts.domDown.domClass)), l._threshold = l.$domDown && "" === l.opts.threshold ? Math.floor(1 * l.$domDown.height() / 3) : l.opts.threshold, l.opts.scrollArea == b ? (l.$scrollArea = d, l._scrollContentHeight = e.height(), l._scrollWindowHeight = c.documentElement.clientHeight) : (l.$scrollArea = l.opts.scrollArea, l._scrollContentHeight = l.$element[0].scrollHeight, l._scrollWindowHeight = l.$element.height()), k(l), d.on("resize", function() { l._scrollWindowHeight = l.opts.scrollArea == b ? b.innerHeight : l.$element.height() }), l.$element.on("touchstart", function(a) { l.loading || (g(a), h(a, l)) }), l.$element.on("touchmove", function(a) { l.loading || (g(a, l), i(a, l)) }), l.$element.on("touchend", function() { l.loading || j(l) }), l.$scrollArea.on("scroll", function() { l._scrollTop = l.$scrollArea.scrollTop(), "" != l.opts.loadDownFn && !l.loading && !l.isLockDown && l._scrollContentHeight - l._threshold <= l._scrollWindowHeight + l._scrollTop && m(l) })
    }, f.prototype.lock = function(a) {
        var b = this;
        void 0 === a ? "up" == b.direction ? b.isLockDown = !0 : "down" == b.direction ? b.isLockUp = !0 : (b.isLockUp = !0, b.isLockDown = !0) : "up" == a ? b.isLockUp = !0 : "down" == a && (b.isLockDown = !0, b.direction = "up")
    }, f.prototype.unlock = function() {
        var a = this;
        a.isLockUp = !1, a.isLockDown = !1, a.direction = "up"
    }, f.prototype.noData = function(a) {
        var b = this;
        void 0 === a || 1 == a ? b.isData = !1 : 0 == a && (b.isData = !0)
    }, f.prototype.resetload = function() {
        var b = this;
        "down" == b.direction && b.upInsertDOM ? b.$domUp.css({ height: "0" }).on("webkitTransitionEnd mozTransitionEnd transitionend", function() { b.loading = !1, b.upInsertDOM = !1, a(this).remove(), l(b) }) : "up" == b.direction && (b.loading = !1, b.isData ? (b.$domDown.html(b.opts.domDown.domRefresh), l(b), k(b)) : b.$domDown.html(b.opts.domDown.domNoData))
    }
}(window.Zepto || window.jQuery);
$(function() {
    ////index.html列表页 加载处
    function images_down(main_c, img_d) {
        var omain_c = $(main_c);
        var oimg_d = $(img_d);
        var counter = 0;
        // 每页展示4个
        var num = 9;
        var pageStart = 0,
            pageEnd = 0;

        // dropload
        omain_c.dropload({
            scrollArea: window,
            loadDownFn: function(me) {
                $.ajax({
                    type: 'GET',
                    url: 'http://m.pc6.sjhiis.jf95.com/ajax.asp?action=990&rid=4',
                    dataType: 'json',
                     success: function(data) {
                        var result = '';
                        counter++;
                        pageEnd = num * counter;
                        pageStart = pageEnd - num;
                        for (var i = pageStart; i < pageEnd; i++) {
                            result += '<li><a href="imgshow.html?cid=' + data.list[i].cid + '&name='+data.list[i].title+'">' + '<img src="' + data.list[i].path + '" >' + '<p class="bag_head_tit">' + data.list[i].title + '</p></a></li>'
                            if ((i + 1) >= data.list.length) {
                                // 锁定
                                me.lock();
                                // 无数据
                                me.noData();
                                break;
                            }
                        }
                        // 为了测试，延迟1秒加载
                        setTimeout(function() {
                            oimg_d.append(result);
                            // 每次数据加载完，必须重置
                            me.resetload();
                        }, 10);
                    },
                    error: function(xhr, type) {
                        alert('Ajax error!');
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
                });
            }
        });
    };
//bag.html列表页 加载处
    function images_bag(main_c, img_d) {
        var omain_c = $(main_c);
        var oimg_d = $(img_d);
        var counter = 0;
        // 每页展示4个
        var num = 9;
        var pageStart = 0,
            pageEnd = 0;

        // dropload
        omain_c.dropload({
            scrollArea: window,
            loadDownFn: function(me) {
                $.ajax({
                    type: 'GET',
                    url: 'http://m.pc6.sjhiis.jf95.com/ajax.asp?action=990&rid=4',
                    dataType: 'json',
                    success: function(data) {
                        var result = '';
                        counter++;
                        pageEnd = num * counter;
                        pageStart = pageEnd - num;

                        for (var i = pageStart; i < pageEnd; i++) {
                            result += '<li><img src="' + data.list[i].path + '" >' + '<p class="bag_head_tit">' + data.list[i].title + '</p></li>'
                            if ((i + 1) >= data.list.length) {
                                // 锁定
                                me.lock();
                                // 无数据
                                me.noData();
                                break;
                            }
                        }

                        // 为了测试，延迟1秒加载
                        setTimeout(function() {
                            oimg_d.append(result);
                            // 每次数据加载完，必须重置
                            me.resetload();
                            bag_list()
                        }, 10);
                    },
                    error: function(xhr, type) {
                        alert('Ajax error!');
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
                });
                
            }
        });
    };
     if ($("ul").hasClass('img_down')) {
        images_down('.web_main', '.img_down') //index.html
    }
     if ($("ul").hasClass('bag_list_up')) {
        images_bag('.bag_list', '.bag_list_up') //bag.html
     }
 bag_list()//bag.html img 距上
 //加载bag.html banner 数据
    function bag_list() {
         $(".bag_list_up li").each(function() {
            $(this).on('click', function() {
            var index=$(this).index();
            bag_banner(index)   
            if ($(".bag_show").css("display") == "none") {
          $(".bag_show").show()
                }
            });
        })
     }
  $(".bag_show").on('click', function() {
    $('.bag_show ul,.swipe-pagenation').remove();
        $(this).hide()
 });
 
 //bag.html  banner
function bag_banner(that){
$.ajax({
type:"GET", 
url:"json/more.json", 
dataType:"json", 
success:function(data){ 
var music="<ul>"; 
  for (j = 0; j < data.list[that].length; j++) {
                    music += "<li> <img src='" + data.list[that][j].path + "'></li>";
                }
music+="</ul>";  
$('.bag_show').append(music);
banner()
aa()
}
});
}
function aa(){//bag.html中图片据上
var bag_img_h = parseInt($(".bag_show img").eq(0).height())
var window_h = parseInt(window.screen.height);
$(".bag_show ul").css("padding-top", (window_h - bag_img_h) / 2 + "px");
}

//改变banner图
    $("#changebg").bind("change", function() {

        var ochangebg = $("#changebg option:selected").val();

        if (ochangebg != 0) {
            $(".wushen_banner").attr("src","images/" + ochangebg + ".jpg")
        }

    })
//随机生成名字
function name(){
var arr = ["腐朽","轨迹","grievance","暗里着迷","旧情歌","邪惡太陽 ","Palma","爱不完","卑微暗恋 ","黑暗lucifer","Cute✖ 寂寥","You are my eyes 你是我的眼","The.End ﹏"];
var index_role_name = Math.floor((Math.random()*arr.length));
 $(".role_fz_text").attr("value",arr[index_role_name])
$(".newsusername").prepend("<span>"+arr[index_role_name]+"</span>")
 if($(".newsusername span").length>5){
    $(".newsusername span:gt(4)").detach()
    }
    }
name()
$(".name_sc").on('click', function() {

name()

    
 newname() 

        
    })
//随机生成情侣名字
$(".name_ql").on('click', function() {
var arr = ["【落日孤城】【独怜幽草】","【逗比，快来打怪兽】【媳妇，打不过快跑】","【小笨蛋爱你】【小傻瓜疼你】","【从老公到老公公】【从老婆到老婆婆】","【泪不尽鸟空啼】【藕不断心亦乱】","【沧海】【巫山】 ","【大头大头下雨不愁】【别人有伞我有大头】","【如来哥哥】【观音姐姐】","【つ颜小旭】【つ蓝小颖】","【逗逼女王范】【二逼暖男范】","【你瞅啥】【我瞅你咋滴】","【一个是夏天丶】【一个是秋天丶】","【始于心动°】【止于枯骨°】"
];

var index_role_name = Math.floor((Math.random()*arr.length));
    
 $(".role_fz_text").attr("value",arr[index_role_name])
$(".newsusername").prepend("<span>"+arr[index_role_name]+"</span>")
     if($(".newsusername span").length>5){
    $(".newsusername span:gt(4)").detach()
    }   
newname()
    })
 
function newname(){
    
    $(".newsusername span").on("click",function(){
    var namesole=$(this).text()
    $(".role_fz_text").attr("value",namesole)
    })

    
    }

})




//复制
 function copyUrl2()
  {
  $('.role_fz_text').select();  
  document.execCommand("Copy");  
  }