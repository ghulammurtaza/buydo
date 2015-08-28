(function(w,d,config,undefined){if(!config){return;}
var url,url_old,timer;var callback=typeof config.callback==='function'?config.callback:undefined;var path=config.path?config.path:'';var range=config.range;var range_len=range.length;var css=d.createElement('link');css.rel='stylesheet';css.media='screen';var isMobile=/iPhone|iPod|iPad|Phone|Mobile|Android|hpwos/i.test(navigator.userAgent);var isPhone=/iPhone|iPod|Phone|Android/i.test(navigator.userAgent);function isLandscape(){return typeof window.orientation!='undefined'&&(window.orientation==90||window.orientation==-90);}
var change_i,change_width;function change(i,width){oncallback_i=i;oncallback_width=width;css.href=url;url_old=url;var timer=setInterval(function(){var c1,c2,c3;try{c1=css.sheet&&css.sheet.cssRules&&css.sheet.cssRules.length>0;}catch(e){};try{c2=css.styleSheet&&css.styleSheet.cssText&&css.styleSheet.cssText.length>0;}catch(e){};try{c3=css.innerHTML&&css.innerHTML&&css.innerHTML.length>0;}catch(e){};if(c1||c2||c3){clearInterval(timer);callback&&callback(i,width);jQuery&&jQuery(window).trigger('emadaptchange');}},16);}
function adapt(){clearTimeout(timer);var width=jQuery(window).width();if(isMobile){if(isPhone||screen&&screen.width<760)
width=Math.min(760,screen.width);else
width=isLandscape()?screen.height:screen.width;}
var arr,arr_0,val_1,val_2,is_range,file;var i=range_len;var last=range_len-1;while(i--){url='';arr=range[i].split('=');arr_0=arr[0];file=arr[1]?arr[1].replace(/\s/g,''):undefined;is_range=arr_0.match('to');val_1=is_range?parseInt(arr_0.split('to')[0],10):parseInt(arr_0,10);val_2=is_range?parseInt(arr_0.split('to')[1],10):undefined;if((!val_2&&i===last&&width>val_1)||(width>val_1&&width<=val_2)){file&&(url=path+file);break;}}
if(!url_old){change(i,width);path&&(d.head||d.getElementsByTagName('head')[0]).appendChild(css);}
else if(url_old!==url){change(i,width);}}
adapt();function react(){clearTimeout(timer);timer=setTimeout(adapt,16);}
if(config.dynamic){if(w.addEventListener){w.addEventListener('resize',react,false);}
else if(w.attachEvent){w.attachEvent('onresize',react);}
else{w.onresize=react;}}})(this,this.document,ADAPT_CONFIG);