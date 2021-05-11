/*
Скрипт dialog (диалоговые окна): 15.11.2014
Автор: Алексей Конан
Документация: http://akonan.ru/?id=7
*/
if(!("konan" in window))konan={};
konan.dialog={};
konan.Dialog=function(id){
this.type=function(){
  if(typeof(this.url)!="string"||document.getElementById(this.url))return 2;
  var p=this.url.substring(this.url.lastIndexOf(".")+1).toLowerCase();
  return (p=="jpg"||p=="png"||p=="jpeg"||p=="gif")?1:0;
  }
this.inc=function(a){
  var s=document.createElement("script");
  s.src=a;
  document.getElementsByTagName("head")[0].appendChild(s);
  }
this.path=function(){
  var p, r="", s=document.getElementsByTagName('script');
  for(var i in s)if(s[i].src&&s[i].src.indexOf('dialog.js')>0)p=s[i].src.split("/").slice(0,-1);
  var d=location.href.split("/").slice(0,-1);
  for(var i in d)if(d[i]!=p[i])r+="../";
  for(var i in p)if(d[i]!=p[i])r+=p[i]+"/";
  return r;
  }
this.style=function(d){
  var l=document.getElementsByTagName('link');
  var e=document.createElement("link");
  e.setAttribute("type","text/css");
  e.setAttribute("rel","stylesheet");
  e.setAttribute("href",d.path()+d.css);
  for(var i in l)if(l[i].rel=="stylesheet"&&e.href==l[i].href)return l[i];
  document.body.appendChild(e);
  return e;
  }
this.client=function(){
  var b=document.body;
  var d=document.documentElement;
  return {
    'scrollTop':d.scrollTop>b.scrollTop?d.scrollTop:b.scrollTop,
    'scrollLeft':d.scrollLeft>b.scrollLeft?d.scrollLeft:b.scrollLeft,
    'height':d.scrollHeight>b.scrollHeight?d.scrollHeight:b.scrollHeight,
    'width':d.scrollWidth>b.scrollWidth?d.scrollWidth:b.scrollWidth,
    'clientHeight':d.clientHeight>0&&d.clientHeight<b.clientHeight?d.clientHeight:b.clientHeight,
    'clientWidth':d.clientWidth>0&&d.clientWidth<b.clientWidth?d.clientWidth:b.clientWidth
    };
  }
this.open=function(tpl,d){
  if(d.window&&d.window.style.display=="none")return d.show();
  if(d.window)d.close();
  d.tpl=tpl;
  var b=['<iframe id="'+d.id+'_data" frameborder="0" onload="konan.dialog[\''+d.id+'\'].onload()" src="'+d.url+'"></iframe>',
  '<img id="'+d.id+'_data" onload="konan.dialog[\''+d.id+'\'].onload()" src="'+d.url+'">',
  '<div id="'+d.id+'_data"></div>'];
  tpl=tpl.replace("[--body--]",b[d.type()]);
  tpl=tpl.replace(/\[--id--\]/g,d.id);
  tpl=tpl.replace("[--title--]",d.title);
  tpl=tpl.replace("[--caption--]",d.caption);
  var c=d.client();
  b=document.body;
  var a=document.createElement("a");
  a.style.width=c.width+"px";
  a.style.height=c.height+"px";
  a.className="dialog-bg";
  a.href="javascript:konan.dialog['"+d.id+"'].delete()";
  b.appendChild(a);
  d.bg=a;
  a=document.createElement("a");
  s=a.style;
  s.width=c.clientWidth+"px";
  s.height=c.clientHeight+"px";
  s.left=c.scrollLeft+"px";
  s.top=c.scrollTop+"px";
  a.className="dialog-load";
  a.href="javascript:konan.dialog['"+d.id+"'].delete()";
  b.appendChild(a);
  d.load=a;
  var e=document.createElement("div");
  e.innerHTML=tpl;
  s=e.style;
  s.display="none";
  s.top=c.scrollTop;
  s.left=c.scrollLeft;
  s.position="absolute";
  b.appendChild(e);
  d.window=e;
  if(d.type()==2){
    if(typeof(d.url)=="string")d.url=document.getElementById(d.url);
    document.getElementById(d.id+"_data").appendChild(d.url);
    d.url.style.display="block";
    setTimeout(function(){d.onload()},40);
    }
  }
this.hide=function(){
  this.window.style.display="none";
  this.bg.style.visibility="hidden";
  }
this.show=function(){
  this.window.style.display="block";
  this.bg.style.visibility="visible";
  }
this.close=function(){
  var b=document.body;
  b.removeChild(this.bg);
  b.removeChild(this.window);
  this.window=undefined;
  if(this.load&&b.contains(this.load))b.removeChild(this.load);
  if(this.type()==2){
    this.url.style.display="none";
    document.body.appendChild(this.url);
    }
  }
this.delete=function(){
  this.close();
  konan.dialog[this.id]=undefined;
  }
this.onload=function(){
  var d=this;
  var u=undefined;
  var b=document.body;
  var s=d.window.style;
  var data=document.getElementById(id+"_data");
  var c=d.client();
  if(d.load)b.removeChild(d.load);
  s.display="block";
  s.zIndex="999";
  var dw=d.window.offsetWidth-data.offsetWidth;
  var dh=d.window.offsetHeight-data.offsetHeight;
  var cw=c.clientWidth-Math.round(c.clientWidth/20);
  var ch=c.clientHeight-Math.round(c.clientHeight/20);
  var w=d.width&&d.width.toString().indexOf("%")>0?Math.round(parseInt(d.width)*c.clientWidth/100):d.width;
  var h=d.height&&d.height.toString().indexOf("%")>0?Math.round(parseInt(d.height)*c.clientHeight/100):d.height;
  w=w==u?0:parseInt(w);
  h=h==u?0:parseInt(h);
  if(d.type()==0){
    var f=document.frames?document.frames[id+"_data"]:data;
    var a=f.window?f.window:f.contentWindow;
    try{a=a.document.body.parentNode;}catch(e){}
    if(h==0)h=a.scrollHeight+dh<ch?(a.scrollWidth+dw<cw?a.scrollHeight+dh:a.scrollHeight-a.clientHeight+d.window.offsetHeight):ch;
    else data.style.height=h-dh+"px";
    if(w==0)w=a.scrollWidth+dw<cw?(a.scrollHeight+dh<ch?a.scrollWidth+dw:a.scrollWidth-a.clientWidth+d.window.offsetWidth):cw;
    else data.style.width=w-dw+"px";
    try{f.width=w-dw;f.height=h-dh;}catch(e){}
    }
  else{
    if(w==0)w=d.window.offsetWidth<cw?d.window.offsetWidth:cw;
    if(h==0)h=d.window.offsetHeight<ch?d.window.offsetHeight:ch;
    if(parseInt(d.width)>0||h*d.window.offsetWidth/d.window.offsetHeight>cw)data.style.width=w-dw+"px";
    if(parseInt(d.height)>0||w*d.window.offsetHeight/d.window.offsetWidth>ch)data.style.height=h-dh+"px";
    w=d.window.offsetWidth;
    h=d.window.offsetHeight;
    }
  var x=d.x&&d.x.toString().indexOf("%")>0?Math.round(parseInt(d.x)*c.clientWidth/100):d.x;
  var y=d.y&&d.y.toString().indexOf("%")>0?Math.round(parseInt(d.y)*c.clientHeight/100):d.y;
  x=x==u?Math.round(c.scrollLeft+c.clientWidth/2-w/2):parseInt(x);
  y=y==u?Math.round(c.scrollTop+c.clientHeight/2-h/2):parseInt(y);
  if(x<0)x=0;
  if(y<0)y=0;
  s.width=w+"px";
  s.height=h+"px";
  s.left=x+"px";
  s.top=y+"px";
  if("opacity" in window){
    opacity(d.window,0);
    opacity(d.window,100,400);
    }
  if(d.fn)return d.fn.apply(d.fn,d.arg);
  }
if(id==undefined){
  var p=this.path();
  if(!("f_get" in window))this.inc(p+"file.js");
  if(!("opacity" in window))this.inc(p+"opacity.js");
  if(!("dnd" in window))this.inc(p+"dnd.js");
  return false;
  }
if(konan.dialog[id])return konan.dialog[id];
this.id=id;
this.css="../css/dialog.css";
this.title=this.caption="";
}
function dialog(url,a,fn){
var u=undefined;
if(a==u)a={};
if(a.id==u)a.id='dialog';
var d=konan.dialog[a.id]=new konan.Dialog(a.id);
if(url!=u)d.url=url;
if(fn!=u)d.fn=fn;
if(a.width!=u)d.width=a.width;
if(a.height!=u)d.height=a.height;
if(a.x!=u)d.x=a.x;
if(a.y!=u)d.y=a.y;
if(a.title!=u)d.title=a.title;
if(a.caption!=u)d.caption=a.caption;
if(a.css!=u)d.css=a.css;
if(a.html!=u)d.html=a.html;
d.link=d.style(d);
d.arg=Array.prototype.slice.call(arguments,3);
if(d.html==u)d.tpl='<div class="dialog"><div class="dialog-control"><div class="dialog-move" onmousedown="dnd(event,konan.dialog[\'[--id--]\'].window)"></div><a href="javascript:konan.dialog[\'[--id--]\'].delete()" class="dialog-close"></a></div><div class="dialog-title">[--title--]</div><div class="dialog-data">[--body--]</div><div align="right"><a href="http://akonan.ru" target="_blank" class="dialog-copy">Powered by akonan.ru</a></div><div class="dialog-caption">[--caption--]</div></div>';
d.tpl==u?f_get(d.path()+d.html,d.open,d):d.open(d.tpl,d);
}
konan.Dialog();
