﻿/*!
 CLEditor WYSIWYG HTML Editor v1.4.4
 http://premiumsoftware.net/CLEditor
 requires jQuery v1.4.2 or later
 Copyright 2010, Chris Landowski, Premium Software, LLC
 Dual licensed under the MIT or GPL Version 2 licenses.
*/
(function(n){function vi(t){var i=this,v=t.target,p=n.data(v,a),w=o[p],k=w.popupName,g=f[k],y,d;if(!i.disabled&&n(v).attr(r)!==r){if(y={editor:i,button:v,buttonName:p,popup:g,popupName:k,command:w.command,useCSS:i.options.useCSS},w.buttonClick&&w.buttonClick(t,y)===!1)return!1;if(p==="source")l(i)?(delete i.range,i.$area.hide(),i.$frame.show(),v.title=w.title):(i.$frame.hide(),i.$area.show(),v.title="Show Rich Text"),setTimeout(function(){c(i)},100);else if(!l(i)){if(k){if(d=n(g),k==="url"){if(p==="link"&&ri(i)==="")return rt(i,"A selection is required when inserting a link.",v),!1;d.children(":button").unbind(u).bind(u,function(){var t=d.find(":text"),r=n.trim(t.val());r!==""&&s(i,y.command,r,null,y.button);t.val("http://");e();h(i)})}else k==="pastetext"&&d.children(":button").unbind(u).bind(u,function(){var n=d.find("textarea"),t=n.val().replace(/\n/g,"<br />");t!==""&&s(i,y.command,t,null,y.button);n.val("");e();h(i)});return v!==n.data(g,b)?(ui(i,g,v),!1):void 0}if(p==="print")i.$frame[0].contentWindow.print();else if(!s(i,y.command,y.value,y.useCSS,v))return!1}h(i)}}function kt(t){var i=n(t.target).closest("div");i.css(ft,i.data(a)?"#FFF":"#FFC")}function dt(t){n(t.target).closest("div").css(ft,"transparent")}function yi(i){var v=this,y=i.data.popup,r=i.target,l;if(y!==f.msg&&!n(y).hasClass(g)){var w=n.data(y,b),u=n.data(w,a),p=o[u],k=p.command,c,d=v.options.useCSS;if(u==="font"?c=r.style.fontFamily.replace(/"/g,""):u==="size"?(r.tagName.toUpperCase()==="DIV"&&(r=r.children[0]),c=r.innerHTML):u==="style"?c="<"+r.tagName+">":u==="color"?c=ti(r.style.backgroundColor):u==="highlight"&&(c=ti(r.style.backgroundColor),t?k="backcolor":d=!0),l={editor:v,button:w,buttonName:u,popup:y,popupName:p.popupName,command:k,value:c,useCSS:d},!p.popupClick||p.popupClick(i,l)!==!1){if(l.command&&!s(v,l.command,l.value,l.useCSS,w))return!1;e();h(v)}}}function nt(n){for(var t=1,i=0,r=0;r<n.length;++r)t=(t+n.charCodeAt(r))%65521,i=(i+t)%65521;return i<<16|t}function pi(n){n.$area.val("");ut(n)}function gt(r,u,e,o,s){var h,c;return f[r]?f[r]:(h=n(i).hide().addClass(si).appendTo("body"),o?h.html(o):r==="color"?(c=u.colors.split(" "),c.length<10&&h.width("auto"),n.each(c,function(t,r){n(i).appendTo(h).css(ft,"#"+r)}),e=hi):r==="font"?n.each(u.fonts.split(","),function(t,r){n(i).appendTo(h).css("fontFamily",r).html(r)}):r==="size"?n.each(u.sizes.split(","),function(t,r){n(i).appendTo(h).html('<font size="'+r+'">'+r+"<\/font>")}):r==="style"?n.each(u.styles,function(t,r){n(i).appendTo(h).html(r[1]+r[0]+r[1].replace("<","<\/"))}):r==="url"?(h.html('Enter URL:<br /><input type="text" value="http://" size="35" /><br /><input type="button" value="Submit" />'),e=g):r==="pastetext"&&(h.html('Paste your content here and click submit.<br /><textarea cols="40" rows="3"><\/textarea><br /><input type="button" value="Submit" />'),e=g),e||o||(e=pt),h.addClass(e),t&&h.attr(et,"on").find("div,font,p,h1,h2,h3,h4,h5,h6").attr(et,"on"),(h.hasClass(pt)||s===!0)&&h.children().hover(kt,dt),f[r]=h[0],h[0])}function ni(n,i){i?(n.$area.attr(r,r),n.disabled=!0):(n.$area.removeAttr(r),delete n.disabled);try{t?n.doc.body.contentEditable=!i:n.doc.designMode=i?"off":"on"}catch(u){}c(n)}function s(n,i,r,u,f){it(n);t||((u===undefined||u===null)&&(u=n.options.useCSS),n.doc.execCommand("styleWithCSS",0,u.toString()));var e=!0,o;if(t&&i.toLowerCase()==="inserthtml")p(n).pasteHTML(r);else{try{e=n.doc.execCommand(i,0,r||null)}catch(s){o=s.message;e=!1}e||("cutcopypaste".indexOf(i)>-1?rt(n,"For security reasons, your browser does not support the "+i+" command. Try using the keyboard shortcut or context menu instead.",f):rt(n,o?o:"Error executing the "+i+" command.",f))}return c(n),ct(n,!0),e}function h(n){setTimeout(function(){l(n)?n.$area.focus():n.$frame[0].contentWindow.focus();c(n)},0)}function p(n){return t?tt(n).createRange():tt(n).getRangeAt(0)}function tt(n){return t?n.doc.selection:n.$frame[0].contentWindow.getSelection()}function ti(n){var i=/rgba?\((\d+), (\d+), (\d+)/.exec(n),t;if(i){for(n=(i[1]<<16|i[2]<<8|i[3]).toString(16);n.length<6;)n="0"+n;return"#"+n}return(t=n.split(""),n.length===4)?"#"+t[1]+t[1]+t[2]+t[2]+t[3]+t[3]:n}function e(){n.each(f,function(t,i){n(i).hide().unbind(u).removeData(b)})}function ii(){var t=n("link[href*=cleditor]").attr("href");return t.replace(/^(.*\/)[^\/]+$/,"$1")+"images/"}function wi(n){return"url("+ii()+n+")"}function ht(i){var o=i.$main,r=i.options;i.$frame&&i.$frame.remove();var u=i.$frame=n('<iframe frameborder="0" src="javascript:true;" />').hide().appendTo(o),l=u[0].contentWindow,f=i.doc=l.document,s=n(f);f.open();f.write(r.docType+"<html>"+(r.docCSSFile===""?"":'<head><link rel="stylesheet" type="text/css" href="'+r.docCSSFile+'" /><\/head>')+'<body style="'+r.bodyStyle+'"><\/body><\/html>');f.close();(t||ot)&&s.click(function(){h(i)});ut(i);t||ot?(s.bind("beforedeactivate beforeactivate selectionchange keypress",function(n){if(n.type==="beforedeactivate")i.inactive=!0;else if(n.type==="beforeactivate")!i.inactive&&i.range&&i.range.length>1&&i.range.shift(),delete i.inactive;else if(!i.inactive)for(i.range||(i.range=[]),i.range.unshift(p(i));i.range.length>2;)i.range.pop()}),u.focus(function(){it(i);n(i).triggerHandler(d)}),u.blur(function(){n(i).triggerHandler(w)})):n(i.$frame[0].contentWindow).focus(function(){n(i).triggerHandler(d)}).blur(function(){n(i).triggerHandler(w)});s.click(e).bind("keyup mouseup",function(){c(i);ct(i,!0)});st?i.$area.show():u.show();n(function(){var t=i.$toolbar,f=t.children("div:last"),e=o.width(),n=f.offset().top+f.outerHeight()-t.offset().top+1;t.height(n);n=(/%/.test(""+r.height)?o.height():parseInt(r.height,10))-n;u.width(e).height(n);i.$area.width(e).height(li?n-2:n);ni(i,i.disabled);c(i)})}function c(i){var u,e;st||!ai||i.focused||(i.$frame[0].contentWindow.focus(),window.focus(),i.focused=!0);u=i.doc;t&&(u=p(i));e=l(i);n.each(i.$toolbar.find("."+vt),function(o,s){var v=n(s),h=n.cleditor.buttons[n.data(s,a)],c=h.command,l=!0,y;if(i.disabled)l=!1;else if(h.getEnabled)y={editor:i,button:s,buttonName:h.name,popup:f[h.popupName],popupName:h.popupName,command:h.command,useCSS:i.options.useCSS},l=h.getEnabled(y),l===undefined&&(l=!0);else if((e||st)&&h.name!=="source"||t&&(c==="undo"||c==="redo"))l=!1;else if(c&&c!=="print"&&(t&&c==="hilitecolor"&&(c="backcolor"),!t||c!=="inserthtml"))try{l=u.queryCommandEnabled(c)}catch(p){l=!1}l?(v.removeClass(yt),v.removeAttr(r)):(v.addClass(yt),v.attr(r,r))})}function it(n){n.range&&(t?n.range[0].select():ot&&tt(n).addRange(n.range[0]))}function bi(n){setTimeout(function(){l(n)?n.$area.select():s(n,"selectall")},0)}function ki(i){var u,r,f;return(it(i),u=p(i),t)?u.htmlText:(r=n("<layer>")[0],r.appendChild(u.cloneContents()),f=r.innerHTML,r=null,f)}function ri(n){return(it(n),t)?p(n).text:tt(n).toString()}function rt(n,t,i){var r=gt("msg",n.options,ci);r.innerHTML=t;ui(n,r,i)}function ui(t,i,r){var f,h,c,o=n(i),l,s;r?(l=n(r),f=l.offset(),h=--f.left,c=f.top+l.height()):(s=t.$toolbar,f=s.offset(),h=Math.floor((s.width()-o.width())/2)+f.left,c=f.top+s.height()-2);e();o.css({left:h,top:c}).show();r&&(n.data(i,b,r),o.bind(u,{popup:i},n.proxy(yi,t)));setTimeout(function(){o.find(":text,textarea").eq(0).focus().select()},100)}function l(n){return n.$area.is(":visible")}function ut(t,i){var u=t.$area.val(),o=t.options,f=o.updateFrame,s=n(t.doc.body),e,r;if(f){if(e=nt(u),i&&t.areaChecksum===e)return;t.areaChecksum=e}r=f?f(u):u;r=r.replace(/<(?=\/?script)/ig,"&lt;");o.updateTextArea&&(t.frameChecksum=nt(r));r!==s.html()&&(s.html(r),n(t).triggerHandler(k))}function ct(t,i){var u=n(t.doc.body).html(),o=t.options,f=o.updateTextArea,s=t.$area,e,r;if(f){if(e=nt(u),i&&t.frameChecksum===e)return;t.frameChecksum=e}r=f?f(u):u;o.updateFrame&&(t.areaChecksum=nt(r));r!==s.val()&&(s.val(r),n(t).triggerHandler(k))}var y,bt;n.cleditor={defaultOptions:{width:"auto",height:250,controls:"bold italic underline strikethrough subscript superscript | font size style | color highlight removeformat | bullets numbering | outdent indent | alignleft center alignright justify | undo redo | rule image link unlink | cut copy paste pastetext | print source",colors:"FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C 999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C 666 900 C60 C93 990 090 399 33F 60C 939 333 600 930 963 660 060 366 009 339 636 000 300 630 633 330 030 033 006 309 303",fonts:"Arial,Arial Black,Comic Sans MS,Courier New,Narrow,Garamond,Georgia,Impact,Sans Serif,Serif,Tahoma,Trebuchet MS,Verdana",sizes:"1,2,3,4,5,6,7",styles:[["Paragraph","<p>"],["Header 1","<h1>"],["Header 2","<h2>"],["Header 3","<h3>"],["Header 4","<h4>"],["Header 5","<h5>"],["Header 6","<h6>"]],useCSS:!0,docType:'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',docCSSFile:"",bodyStyle:"margin:4px; font:10pt Arial,Verdana; cursor:text"},buttons:{init:"bold,太字,|" + "italic,斜体,|" + "underline,下線,|" + "strikethrough,取り消し線,|" + "subscript,,|" + "superscript,,|" + "font,字体,fontname,|" + "size,フォントサイズ,fontsize,|" + "style,見出し,formatblock,|" + "color,文字色,forecolor,|" +  "highlight,背景色,hilitecolor,color|" + "removeformat,文字装飾解除,|" + "bullets,リスト,insertunorderedlist|" + "numbering,リストナンバー,insertorderedlist|" + "outdent,,|" +"indent,,|" +"alignleft,左寄せ,justifyleft|" +"center,センタリング,justifycenter|" +"alignright,右寄せ,justifyright|" +"justify,等幅,justifyfull|" +"undo,1つ戻す,|" +"redo,1つ進む,|" +"rule,横線挿入,inserthorizontalrule|" +"image,Insert Image,insertimage,url|" +"link,リンク設定（文字をドラッグしてからここを押してださい）,createlink,url|" +"unlink,リンク解除,|" +"cut,カット,|" +"copy,コピー,|" +"paste,貼り付け,|" +"pastetext,Paste as Text,inserthtml,|" +"print,プリント,|" +"source,HTML編集モード（直接リンクする際はこちらを押してURLを貼り付けてください）"},imagesPath:function(){return ii()}};n.fn.cleditor=function(t){var i=n([]);return this.each(function(r,u){if(u.tagName.toUpperCase()==="TEXTAREA"){var f=n.data(u,lt);f||(f=new cleditor(u,t));i=i.add(f)}}),i};var ft="backgroundColor",w="blurred",b="button",a="buttonName",k="change",lt="cleditor",u="click",r="disabled",i="<div>",d="focused",et="unselectable",fi="cleditorMain",ei="cleditorToolbar",at="cleditorGroup",vt="cleditorButton",yt="cleditorDisabled",oi="cleditorDivider",si="cleditorPopup",pt="cleditorList",hi="cleditorColor",g="cleditorPrompt",ci="cleditorMsg",v=navigator.userAgent.toLowerCase(),t=/msie/.test(v),li=/msie\s6/.test(v),ot=/(trident)(?:.*rv:([\w.]+))?/.test(v),ai=/webkit/.test(v),st=/iphone|ipad|ipod/i.test(v),f={},wt,o=n.cleditor.buttons;n.each(o.init.split("|"),function(n,t){var i=t.split(","),r=i[0];o[r]={stripIndex:n,name:r,title:i[1]===""?r.charAt(0).toUpperCase()+r.substr(1):i[1],command:i[2]===""?r:i[2],popupName:i[3]===""?r:i[3]}});delete o.init;cleditor=function(r,f){var s=this;s.options=f=n.extend({},n.cleditor.defaultOptions,f);var l=s.$area=n(r).hide().data(lt,s).blur(function(){ut(s,!0)}),v=s.$main=n(i).addClass(fi).width(f.width).height(f.height),y=s.$toolbar=n(i).addClass(ei).appendTo(v),h=n(i).addClass(at).appendTo(y),c=0;n.each(f.controls.split(" "),function(r,e){var w,l,p,v;if(e==="")return!0;e==="|"?(w=n(i).addClass(oi).appendTo(h),h.width(c+1),c=0,h=n(i).addClass(at).appendTo(y)):(l=o[e],p=n(i).data(a,l.name).addClass(vt).attr("title",l.title).bind(u,n.proxy(vi,s)).appendTo(h).hover(kt,dt),c+=24,h.width(c+1),v={},l.css?v=l.css:l.image&&(v.backgroundImage=wi(l.image)),l.stripIndex&&(v.backgroundPosition=l.stripIndex*-24),p.css(v),t&&p.attr(et,"on"),l.popupName&&gt(l.popupName,f,l.popupClass,l.popupContent,l.popupHover))});v.insertBefore(l).append(l);wt||(n(document).click(function(t){var i=n(t.target);i.add(i.parents()).is("."+g)||e()}),wt=!0);/auto|%/.test(""+f.width+f.height)&&n(window).bind("resize.cleditor",function(){ht(s)});ht(s)};y=cleditor.prototype;bt=[["clear",pi],["disable",ni],["execCommand",s],["focus",h],["hidePopups",e],["sourceMode",l,!0],["refresh",ht],["select",bi],["selectedHTML",ki,!0],["selectedText",ri,!0],["showMessage",rt],["updateFrame",ut],["updateTextArea",ct]];n.each(bt,function(n,t){y[t[0]]=function(){for(var u,n=this,r=[n],i=0;i<arguments.length;i++)r.push(arguments[i]);return(u=t[1].apply(n,r),t[2])?u:n}});y.blurred=function(t){var i=n(this);return t?i.bind(w,t):i.trigger(w)};y.change=function(t){console.log("change test");var i=n(this);return t?i.bind(k,t):i.trigger(k)};y.focused=function(t){var i=n(this);return t?i.bind(d,t):i.trigger(d)}})(jQuery);