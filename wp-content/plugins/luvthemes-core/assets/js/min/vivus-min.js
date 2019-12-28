"use strict";var requestAnimFrame,cancelAnimFrame,parsePositiveInt;function Vivus(b,a,c){this.isReady=false;this.setElement(b,a);this.setOptions(a);this.setCallback(c);if(this.isReady){this.init()}}Vivus.LINEAR=function(a){return a};Vivus.EASE=function(a){return -Math.cos(a*Math.PI)/2+0.5};Vivus.EASE_OUT=function(a){return 1-Math.pow(1-a,3)};Vivus.EASE_IN=function(a){return Math.pow(a,3)};Vivus.EASE_OUT_BOUNCE=function(a){var e=-Math.cos(a*(0.5*Math.PI))+1,d=Math.pow(e,1.5),c=Math.pow(1-a,2),b=-Math.abs(Math.cos(d*(2.5*Math.PI)))+1;return(1-c)+(b*c)};Vivus.prototype.setElement=function(d,c){if(typeof d==="undefined"){throw new Error('Vivus [constructor]: "element" parameter is required')}if(d.constructor===String){d=document.getElementById(d);if(!d){throw new Error('Vivus [constructor]: "element" parameter is not related to an existing ID')}}this.parentEl=d;if(c&&c.file){var b=document.createElement("object");b.setAttribute("type","image/svg+xml");b.setAttribute("data",c.file);b.setAttribute("width","100%");b.setAttribute("height","100%");d.appendChild(b);d=b}switch(d.constructor){case window.SVGSVGElement:case window.SVGElement:this.el=d;this.isReady=true;break;case window.HTMLObjectElement:this.el=d.contentDocument&&d.contentDocument.querySelector("svg");if(this.el){this.isReady=true;return}var a=this;d.addEventListener("load",function(){a.el=d.contentDocument&&d.contentDocument.querySelector("svg");if(!a.el){throw new Error("Vivus [constructor]: object loaded does not contain any SVG")}else{a.isReady=true;a.init()}});break;default:throw new Error('Vivus [constructor]: "element" parameter is not valid (or miss the "file" attribute)')}};Vivus.prototype.setOptions=function(b){var c=["delayed","async","oneByOne","scenario","scenario-sync"];var a=["inViewport","manual","autostart"];if(b!==undefined&&b.constructor!==Object){throw new Error('Vivus [constructor]: "options" parameter must be an object')}else{b=b||{}}if(b.type&&c.indexOf(b.type)===-1){throw new Error("Vivus [constructor]: "+b.type+" is not an existing animation `type`")}else{this.type=b.type||c[0]}if(b.start&&a.indexOf(b.start)===-1){throw new Error("Vivus [constructor]: "+b.start+" is not an existing `start` option")}else{this.start=b.start||a[0]}this.isIE=(window.navigator.userAgent.indexOf("MSIE")!==-1||window.navigator.userAgent.indexOf("Trident/")!==-1||window.navigator.userAgent.indexOf("Edge/")!==-1);this.duration=parsePositiveInt(b.duration,120);this.delay=parsePositiveInt(b.delay,null);this.dashGap=parsePositiveInt(b.dashGap,2);this.forceRender=b.hasOwnProperty("forceRender")?!!b.forceRender:this.isIE;this.selfDestroy=!!b.selfDestroy;this.onReady=b.onReady;this.ignoreInvisible=b.hasOwnProperty("ignoreInvisible")?!!b.ignoreInvisible:false;this.animTimingFunction=b.animTimingFunction||Vivus.LINEAR;this.pathTimingFunction=b.pathTimingFunction||Vivus.LINEAR;if(this.delay>=this.duration){throw new Error("Vivus [constructor]: delay must be shorter than duration")}};Vivus.prototype.setCallback=function(a){if(!!a&&a.constructor!==Function){throw new Error('Vivus [constructor]: "callback" parameter must be a function')}this.callback=a||function(){}};Vivus.prototype.mapping=function(){var b,g,d,f,a,h,c,e;e=h=c=0;g=this.el.querySelectorAll("path");for(b=0;b<g.length;b++){d=g[b];if(this.isInvisible(d)){continue}a={el:d,length:Math.ceil(d.getTotalLength())};if(isNaN(a.length)){if(window.console&&console.warn){console.warn("Vivus [mapping]: cannot retrieve a path element length",d)}continue}h+=a.length;this.map.push(a);d.style.strokeDasharray=a.length+" "+(a.length+this.dashGap);d.style.strokeDashoffset=a.length;if(this.isIE){a.length+=this.dashGap}this.renderPath(b)}h=h===0?1:h;this.delay=this.delay===null?this.duration/3:this.delay;this.delayUnit=this.delay/(g.length>1?g.length-1:1);for(b=0;b<this.map.length;b++){a=this.map[b];switch(this.type){case"delayed":a.startAt=this.delayUnit*b;a.duration=this.duration-this.delay;break;case"oneByOne":a.startAt=c/h*this.duration;a.duration=a.length/h*this.duration;break;case"async":a.startAt=0;a.duration=this.duration;break;case"scenario-sync":d=g[b];f=this.parseAttr(d);a.startAt=e+(parsePositiveInt(f["data-delay"],this.delayUnit)||0);a.duration=parsePositiveInt(f["data-duration"],this.duration);e=f["data-async"]!==undefined?a.startAt:a.startAt+a.duration;this.frameLength=Math.max(this.frameLength,(a.startAt+a.duration));break;case"scenario":d=g[b];f=this.parseAttr(d);a.startAt=parsePositiveInt(f["data-start"],this.delayUnit)||0;a.duration=parsePositiveInt(f["data-duration"],this.duration);this.frameLength=Math.max(this.frameLength,(a.startAt+a.duration));break}c+=a.length;this.frameLength=this.frameLength||this.duration}};Vivus.prototype.drawer=function(){var a=this;this.currentFrame+=this.speed;if(this.currentFrame<=0){this.stop();this.reset();this.callback(this)}else{if(this.currentFrame>=this.frameLength){this.stop();this.currentFrame=this.frameLength;this.trace();if(this.selfDestroy){this.destroy()}this.callback(this)}else{this.trace();this.handle=requestAnimFrame(function(){a.drawer()})}}};Vivus.prototype.trace=function(){if(typeof this.map==="undefined"){return}var b,a,d,c;c=this.animTimingFunction(this.currentFrame/this.frameLength)*this.frameLength;for(b=0;b<this.map.length;b++){d=this.map[b];a=(c-d.startAt)/d.duration;a=this.pathTimingFunction(Math.max(0,Math.min(1,a)));if(d.progress!==a){d.progress=a;d.el.style.strokeDashoffset=Math.floor(d.length*(1-a));this.renderPath(b)}}};Vivus.prototype.renderPath=function(a){if(this.forceRender&&this.map&&this.map[a]){var b=this.map[a],c=b.el.cloneNode(true);b.el.parentNode.replaceChild(c,b.el);b.el=c}};Vivus.prototype.init=function(){this.frameLength=0;this.currentFrame=0;this.map=[];new Pathformer(this.el);this.mapping();this.starter();if(this.onReady){this.onReady(this)}};Vivus.prototype.starter=function(){switch(this.start){case"manual":return;case"autostart":this.play();break;case"inViewport":var a=this,b=function(){if(a.isInViewport(a.parentEl,1)){a.play();window.removeEventListener("scroll",b)}};window.addEventListener("scroll",b);b();break}};Vivus.prototype.getStatus=function(){return this.currentFrame===0?"start":this.currentFrame===this.frameLength?"end":"progress"};Vivus.prototype.reset=function(){return this.setFrameProgress(0)};Vivus.prototype.finish=function(){return this.setFrameProgress(1)};Vivus.prototype.setFrameProgress=function(a){a=Math.min(1,Math.max(0,a));this.currentFrame=Math.round(this.frameLength*a);this.trace();return this};Vivus.prototype.play=function(a){if(a&&typeof a!=="number"){throw new Error("Vivus [play]: invalid speed")}this.speed=a||1;if(!this.handle){this.drawer()}return this};Vivus.prototype.stop=function(){if(this.handle){cancelAnimFrame(this.handle);delete this.handle}return this};Vivus.prototype.destroy=function(){var a,b;for(a=0;a<this.map.length;a++){b=this.map[a];b.el.style.strokeDashoffset=null;b.el.style.strokeDasharray=null;this.renderPath(a)}};Vivus.prototype.isInvisible=function(a){var b,c=a.getAttribute("data-ignore");if(c!==null){return c!=="false"}if(this.ignoreInvisible){b=a.getBoundingClientRect();return !b.width&&!b.height}else{return false}};Vivus.prototype.parseAttr=function(d){var a,b={};if(d&&d.attributes){for(var c=0;c<d.attributes.length;c++){a=d.attributes[c];b[a.name]=a.value}}return b};Vivus.prototype.isInViewport=function(i,g){var f=this.scrollY(),c=f+this.getViewportH(),e=i.getBoundingClientRect(),b=e.height,a=f+e.top,d=a+b;g=g||0;return(a+b*g)<=c&&(d)>=f};Vivus.prototype.docElem=window.document.documentElement;Vivus.prototype.getViewportH=function(){var a=this.docElem.clientHeight,b=window.innerHeight;if(a<b){return b}else{return a}};Vivus.prototype.scrollY=function(){return window.pageYOffset||this.docElem.scrollTop};requestAnimFrame=(function(){return(window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(a){return window.setTimeout(a,1000/60)})})();cancelAnimFrame=(function(){return(window.cancelAnimationFrame||window.webkitCancelAnimationFrame||window.mozCancelAnimationFrame||window.oCancelAnimationFrame||window.msCancelAnimationFrame||function(a){return window.clearTimeout(a)})})();parsePositiveInt=function(c,a){var b=parseInt(c,10);return(b>=0)?b:a};