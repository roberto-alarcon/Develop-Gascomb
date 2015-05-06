/*
This software is allowed to use under GPL or you need to obtain Commercial or Enterise License
to use it in non-GPL project. Please contact sales@dhtmlx.com for details
*/
(scheduler._temp_matrix_scope=function(){function H(){for(var a=scheduler.get_visible_events(),c=[],b=0;b<this.y_unit.length;b++)c[b]=[];c[d]||(c[d]=[]);for(b=0;b<a.length;b++){for(var d=this.order[a[b][this.y_property]],h=0;this._trace_x[h+1]&&a[b].start_date>=this._trace_x[h+1];)h++;for(;this._trace_x[h]&&a[b].end_date>this._trace_x[h];)c[d][h]||(c[d][h]=[]),c[d][h].push(a[b]),h++}return c}function w(a,c,b){var d=0,h=b._step,e=b.round_position,k=0,g=c?a.end_date:a.start_date;if(g.valueOf()>scheduler._max_date.valueOf())g=
scheduler._max_date;var i=g-scheduler._min_date_timeline;if(i>0){var m=scheduler._get_date_index(b,g);scheduler._ignores[m]&&(e=!0);for(var l=0;l<m;l++)d+=scheduler._cols[l];var p=scheduler.date.add(scheduler._min_date_timeline,scheduler.matrix[scheduler._mode].x_step*m,scheduler.matrix[scheduler._mode].x_unit);e?+g>+p&&c&&(k=scheduler._cols[m]):(i=g-p,b.first_hour||b.last_hour?(i-=b._start_correction,i<0&&(i=0),k=Math.round(i/h),k>scheduler._cols[m]&&(k=scheduler._cols[m])):k=Math.round(i/h))}d+=
c?i!=0&&!e?k-12:k-14:k+1;return d}function t(a,c){var b=scheduler._get_date_index(this,a),d=this._trace_x[b];c&&+a!=+this._trace_x[b]&&(d=this._trace_x[b+1]?this._trace_x[b+1]:scheduler.date.add(this._trace_x[b],this.x_step,this.x_unit));return new Date(d)}function I(a){var c="";if(a&&this.render!="cell"){a.sort(this.sort||function(a,b){return a.start_date.valueOf()==b.start_date.valueOf()?a.id>b.id?1:-1:a.start_date>b.start_date?1:-1});for(var b=[],d=a.length,h=0;h<d;h++){var e=a[h];e._inner=!1;
for(var k=this.round_position?t.apply(this,[e.start_date,!1]):e.start_date,g=this.round_position?t.apply(this,[e.end_date,!0]):e.end_date;b.length;){var i=b[b.length-1];if(i.end_date.valueOf()<=k.valueOf())b.splice(b.length-1,1);else break}for(var m=!1,l=0;l<b.length;l++){var p=b[l];if(p.end_date.valueOf()<=k.valueOf()){m=!0;e._sorder=p._sorder;b.splice(l,1);e._inner=!0;break}}if(b.length)b[b.length-1]._inner=!0;if(!m)if(b.length)if(b.length<=b[b.length-1]._sorder){if(b[b.length-1]._sorder)for(var f=
0;f<b.length;f++){for(var q=!1,n=0;n<b.length;n++)if(b[n]._sorder==f){q=!0;break}if(!q){e._sorder=f;break}}else e._sorder=0;e._inner=!0}else{for(var q=b[0]._sorder,o=1;o<b.length;o++)if(b[o]._sorder>q)q=b[o]._sorder;e._sorder=q+1;e._inner=!1}else e._sorder=0;b.push(e);b.length>(b.max_count||0)?(b.max_count=b.length,e._count=b.length):e._count=e._count?e._count:1}for(var j=0;j<a.length;j++)a[j]._count=b.max_count;for(var r=0;r<d;r++)c+=scheduler.render_timeline_event.call(this,a[r],!1)}return c}function J(a){var c=
"<table style='table-layout:fixed;' cellspacing='0' cellpadding='0'>",b=[];scheduler._load_mode&&scheduler._load();if(this.render=="cell")b=H.call(this);else for(var d=scheduler.get_visible_events(),h=this.order,e=0;e<d.length;e++){var k=d[e],g=k[this.y_property],i=this.order[g];if(this.show_unassigned&&!g)for(var m in h){if(h.hasOwnProperty(m)){i=h[m];b[i]||(b[i]=[]);var l=scheduler._lame_copy({},k);l[this.y_property]=m;b[i].push(l)}}else b[i]||(b[i]=[]),b[i].push(k)}for(var p=0,f=0;f<scheduler._cols.length;f++)p+=
scheduler._cols[f];var q=new Date,n=scheduler._cols.length-scheduler._ignores_detected;this._step=q=(scheduler.date.add(q,this.x_step*n,this.x_unit)-q-(this._start_correction+this._end_correction)*n)/p;this._summ=p;var o=scheduler._colsS.heights=[];this._events_height={};this._section_height={};for(f=0;f<this.y_unit.length;f++){var j=this._logic(this.render,this.y_unit[f],this);scheduler._merge(j,{height:this.dy});if(this.section_autoheight){if(this.y_unit.length*j.height<a.offsetHeight)j.height=
Math.max(j.height,Math.floor((a.offsetHeight-1)/this.y_unit.length));this._section_height[this.y_unit[f].key]=j.height}scheduler._merge(j,{tr_className:"",style_height:"height:"+j.height+"px;",style_width:"width:"+(this.dx-1)+"px;",td_className:"dhx_matrix_scell"+(scheduler.templates[this.name+"_scaley_class"](this.y_unit[f].key,this.y_unit[f].label,this.y_unit[f])?" "+scheduler.templates[this.name+"_scaley_class"](this.y_unit[f].key,this.y_unit[f].label,this.y_unit[f]):""),td_content:scheduler.templates[this.name+
"_scale_label"](this.y_unit[f].key,this.y_unit[f].label,this.y_unit[f]),summ_width:"width:"+p+"px;",table_className:""});var r=I.call(this,b[f]);if(this.fit_events){var s=this._events_height[this.y_unit[f].key]||0;j.height=s>j.height?s:j.height;j.style_height="height:"+j.height+"px;";this._section_height[this.y_unit[f].key]=j.height}c+="<tr class='"+j.tr_className+"' style='"+j.style_height+"'><td class='"+j.td_className+"' style='"+j.style_width+" height:"+(j.height-1)+"px;'>"+j.td_content+"</td>";
if(this.render=="cell")for(e=0;e<scheduler._cols.length;e++)c+=scheduler._ignores[e]?"<td></td>":"<td class='dhx_matrix_cell "+scheduler.templates[this.name+"_cell_class"](b[f][e],this._trace_x[e],this.y_unit[f])+"' style='width:"+(scheduler._cols[e]-1)+"px'><div style='width:"+(scheduler._cols[e]-1)+"px'>"+scheduler.templates[this.name+"_cell_value"](b[f][e])+"</div></td>";else{c+="<td><div style='"+j.summ_width+" "+j.style_height+" position:relative;' class='dhx_matrix_line'>";c+=r;c+="<table class='"+
j.table_className+"' cellpadding='0' cellspacing='0' style='"+j.summ_width+" "+j.style_height+"' >";for(e=0;e<scheduler._cols.length;e++)c+=scheduler._ignores[e]?"<td></td>":"<td class='dhx_matrix_cell "+scheduler.templates[this.name+"_cell_class"](b[f],this._trace_x[e],this.y_unit[f])+"' style='width:"+(scheduler._cols[e]-1)+"px'><div style='width:"+(scheduler._cols[e]-1)+"px'></div></td>";c+="</table>";c+="</div></td>"}c+="</tr>"}c+="</table>";this._matrix=b;a.innerHTML=c;scheduler._rendered=[];
for(var B=scheduler._obj.getElementsByTagName("DIV"),f=0;f<B.length;f++)B[f].getAttribute("event_id")&&scheduler._rendered.push(B[f]);this._scales={};for(f=0;f<a.firstChild.rows.length;f++){o.push(a.firstChild.rows[f].offsetHeight);var x=this.y_unit[f].key,z=this._scales[x]=scheduler._isRender("cell")?a.firstChild.rows[f]:a.firstChild.rows[f].childNodes[1].getElementsByTagName("div")[0];scheduler.callEvent("onScaleAdd",[z,x])}}function K(a){var c=scheduler.xy.scale_height,b=this._header_resized||
scheduler.xy.scale_height;scheduler._cols=[];scheduler._colsS={height:0};this._trace_x=[];var d=scheduler._x-this.dx-scheduler.xy.scroll_width,h=[this.dx],e=scheduler._els.dhx_cal_header[0];e.style.width=h[0]+d+"px";scheduler._min_date_timeline=scheduler._min_date;var k=scheduler.config.preserve_scale_length,g=scheduler._min_date;scheduler._process_ignores(g,this.x_size,this.x_unit,this.x_step,k);var i=this.x_size+(k?scheduler._ignores_detected:0);if(i!=this.x_size)scheduler._max_date=scheduler.date.add(scheduler._min_date,
i*this.x_step,this.x_unit);for(var m=i-scheduler._ignores_detected,l=0;l<i;l++)this._trace_x[l]=new Date(g),g=scheduler.date.add(g,this.x_step,this.x_unit),scheduler._ignores[l]?(scheduler._cols[l]=0,m++):scheduler._cols[l]=Math.floor(d/(m-l)),d-=scheduler._cols[l],h[l+1]=h[l]+scheduler._cols[l];a.innerHTML="<div></div>";if(this.second_scale){for(var p=this.second_scale.x_unit,f=[this._trace_x[0]],q=[],n=[this.dx,this.dx],o=0,j=0;j<this._trace_x.length;j++){var r=this._trace_x[j],s=E(p,r,f[o]);s&&
(++o,f[o]=r,n[o+1]=n[o]);var B=o+1;q[o]=scheduler._cols[j]+(q[o]||0);n[B]+=scheduler._cols[j]}a.innerHTML="<div></div><div></div>";var x=a.firstChild;x.style.height=b+"px";var z=a.lastChild;z.style.position="relative";for(var u=0;u<f.length;u++){var y=f[u],C=scheduler.templates[this.name+"_second_scalex_class"](y),A=document.createElement("DIV");A.className="dhx_scale_bar dhx_second_scale_bar"+(C?" "+C:"");scheduler.set_xy(A,q[u]-1,b-3,n[u],0);A.innerHTML=scheduler.templates[this.name+"_second_scale_date"](y);
x.appendChild(A)}}scheduler.xy.scale_height=b;for(var a=a.lastChild,v=0;v<this._trace_x.length;v++)if(!scheduler._ignores[v]){g=this._trace_x[v];scheduler._render_x_header(v,h[v],g,a);var w=scheduler.templates[this.name+"_scalex_class"](g);w&&(a.lastChild.className+=" "+w)}scheduler.xy.scale_height=c;var t=this._trace_x;a.onclick=function(a){var b=F(a);b&&scheduler.callEvent("onXScaleClick",[b.x,t[b.x],a||event])};a.ondblclick=function(a){var b=F(a);b&&scheduler.callEvent("onXScaleDblClick",[b.x,
t[b.x],a||event])}}function E(a,c,b){switch(a){case "hour":return c.getHours()!=b.getHours()||E("day",c,b);case "day":return!(c.getDate()==b.getDate()&&c.getMonth()==b.getMonth()&&c.getFullYear()==b.getFullYear());case "week":return!(scheduler.date.getISOWeek(c)==scheduler.date.getISOWeek(b)&&c.getFullYear()==b.getFullYear());case "month":return!(c.getMonth()==b.getMonth()&&c.getFullYear()==b.getFullYear());case "year":return c.getFullYear()!=b.getFullYear();default:return!1}}function L(a){if(a){scheduler.set_sizes();
G();var c=scheduler._min_date;K.call(this,scheduler._els.dhx_cal_header[0]);J.call(this,scheduler._els.dhx_cal_data[0]);scheduler._min_date=c;scheduler._els.dhx_cal_date[0].innerHTML=scheduler.templates[this.name+"_date"](scheduler._min_date,scheduler._max_date);scheduler._mark_now&&scheduler._mark_now()}D()}function D(){if(scheduler._tooltip)scheduler._tooltip.style.display="none",scheduler._tooltip.date=""}function M(a,c,b){if(a.render=="cell"){var d=c.x+"_"+c.y,h=a._matrix[c.y][c.x];if(!h)return D();
h.sort(function(a,b){return a.start_date>b.start_date?1:-1});if(scheduler._tooltip){if(scheduler._tooltip.date==d)return;scheduler._tooltip.innerHTML=""}else{var e=scheduler._tooltip=document.createElement("DIV");e.className="dhx_year_tooltip";document.body.appendChild(e);e.onclick=scheduler._click.dhx_cal_data}for(var k="",g=0;g<h.length;g++){var i=h[g].color?"background-color:"+h[g].color+";":"",m=h[g].textColor?"color:"+h[g].textColor+";":"";k+="<div class='dhx_tooltip_line' event_id='"+h[g].id+
"' style='"+i+""+m+"'>";k+="<div class='dhx_tooltip_date'>"+(h[g]._timed?scheduler.templates.event_date(h[g].start_date):"")+"</div>";k+="<div class='dhx_event_icon icon_details'>&nbsp;</div>";k+=scheduler.templates[a.name+"_tooltip"](h[g].start_date,h[g].end_date,h[g])+"</div>"}scheduler._tooltip.style.display="";scheduler._tooltip.style.top="0px";scheduler._tooltip.style.left=document.body.offsetWidth-b.left-scheduler._tooltip.offsetWidth<0?b.left-scheduler._tooltip.offsetWidth+"px":b.left+c.src.offsetWidth+
"px";scheduler._tooltip.date=d;scheduler._tooltip.innerHTML=k;scheduler._tooltip.style.top=document.body.offsetHeight-b.top-scheduler._tooltip.offsetHeight<0?b.top-scheduler._tooltip.offsetHeight+c.src.offsetHeight+"px":b.top+"px"}}function G(){dhtmlxEvent(scheduler._els.dhx_cal_data[0],"mouseover",function(a){var c=scheduler.matrix[scheduler._mode];if(c&&c.render=="cell"){if(c){var b=scheduler._locate_cell_timeline(a),a=a||event,d=a.target||a.srcElement;if(b)return M(c,b,getOffset(b.src))}D()}});
G=function(){}}function N(a){for(var c=a.parentNode.childNodes,b=0;b<c.length;b++)if(c[b]==a)return b;return-1}function F(a){for(var a=a||event,c=a.target?a.target:a.srcElement;c&&c.tagName!="DIV";)c=c.parentNode;if(c&&c.tagName=="DIV"){var b=c.className.split(" ")[0];if(b=="dhx_scale_bar")return{x:N(c),y:-1,src:c,scale:!0}}}scheduler.matrix={};scheduler._merge=function(a,c){for(var b in c)typeof a[b]=="undefined"&&(a[b]=c[b])};scheduler.createTimelineView=function(a){scheduler._skin_init();scheduler._merge(a,
{section_autoheight:!0,name:"matrix",x:"time",y:"time",x_step:1,x_unit:"hour",y_unit:"day",y_step:1,x_start:0,x_size:24,y_start:0,y_size:7,render:"cell",dx:200,dy:50,event_dy:scheduler.xy.bar_height-5,event_min_dy:scheduler.xy.bar_height-5,resize_events:!0,fit_events:!0,show_unassigned:!1,second_scale:!1,round_position:!1,_logic:function(a,b,c){var g={};scheduler.checkEvent("onBeforeSectionRender")&&(g=scheduler.callEvent("onBeforeSectionRender",[a,b,c]));return g}});a._original_x_start=a.x_start;
if(a.x_unit!="day")a.first_hour=a.last_hour=0;a._start_correction=a.first_hour?a.first_hour*36E5:0;a._end_correction=a.last_hour?(24-a.last_hour)*36E5:0;scheduler.checkEvent("onTimelineCreated")&&scheduler.callEvent("onTimelineCreated",[a]);var c=scheduler.render_data;scheduler.render_data=function(b,e){if(this._mode==a.name)if(e&&!a.show_unassigned&&a.render!="cell")for(var d=0;d<b.length;d++)this.clear_event(b[d]),this.render_timeline_event.call(this.matrix[this._mode],b[d],!0);else scheduler._renderMatrix.call(a,
!0,!0);else return c.apply(this,arguments)};scheduler.matrix[a.name]=a;scheduler.templates[a.name+"_cell_value"]=function(a){return a?a.length:""};scheduler.templates[a.name+"_cell_class"]=function(){return""};scheduler.templates[a.name+"_scalex_class"]=function(){return""};scheduler.templates[a.name+"_second_scalex_class"]=function(){return""};scheduler.templates[a.name+"_scaley_class"]=function(){return""};scheduler.templates[a.name+"_scale_label"]=function(a,b){return b};scheduler.templates[a.name+
"_tooltip"]=function(a,b,c){return c.text};scheduler.templates[a.name+"_date"]=function(a,b){return a.getDay()==b.getDay()&&b-a<864E5||+a==+scheduler.date.date_part(new Date(b))||+scheduler.date.add(a,1,"day")==+b&&b.getHours()==0&&b.getMinutes()==0?scheduler.templates.day_date(a):a.getDay()!=b.getDay()&&b-a<864E5?scheduler.templates.day_date(a)+" &ndash; "+scheduler.templates.day_date(b):scheduler.templates.week_date(a,b)};scheduler.templates[a.name+"_scale_date"]=scheduler.date.date_to_str(a.x_date||
scheduler.config.hour_date);scheduler.templates[a.name+"_second_scale_date"]=scheduler.date.date_to_str(a.second_scale&&a.second_scale.x_date?a.second_scale.x_date:scheduler.config.hour_date);scheduler.date["add_"+a.name]=function(b,c){var d=scheduler.date.add(b,(a.x_length||a.x_size)*c*a.x_step,a.x_unit);if((a.x_unit=="minute"||a.x_unit=="hour")&&!a.x_length)if(+scheduler.date.date_part(new Date(b))==+scheduler.date.date_part(new Date(d)))a.x_start+=c*a.x_size;else{var g=a.x_unit=="hour"?a.x_step*
60:a.x_step,i=1440/(a.x_size*g)-1;c>0?a.x_start-=i*a.x_size:a.x_start=i*a.x_size+a.x_start}return d};scheduler.attachEvent("onBeforeTodayDisplayed",function(){a.x_start=a._original_x_start;return!0});scheduler.date[a.name+"_start"]=function(b){var c=scheduler.date[a.x_unit+"_start"]||scheduler.date.day_start,d=c.call(scheduler.date,b);return d=scheduler.date.add(d,a.x_step*a.x_start,a.x_unit)};scheduler.attachEvent("onSchedulerResize",function(){return this._mode==a.name?(scheduler._renderMatrix.call(a,
!0,!0),!1):!0});scheduler.attachEvent("onOptionsLoad",function(){a.order={};scheduler.callEvent("onOptionsLoadStart",[]);for(var b=0;b<a.y_unit.length;b++)a.order[a.y_unit[b].key]=b;scheduler.callEvent("onOptionsLoadFinal",[]);scheduler._date&&a.name==scheduler._mode&&scheduler.setCurrentView(scheduler._date,scheduler._mode)});scheduler.callEvent("onOptionsLoad",[a]);scheduler[a.name+"_view"]=function(){scheduler._renderMatrix.apply(a,arguments)};var b=new Date,d=scheduler.date.add(b,a.x_step,a.x_unit).valueOf()-
b.valueOf();scheduler["mouse_"+a.name]=function(b){var c=this._drag_event;if(this._drag_id)c=this.getEvent(this._drag_id),this._drag_event._dhx_changed=!0;b.x-=a.dx;for(var d=0,g=0,i=0;g<=this._cols.length-1;g++){var m=this._cols[g];d+=m;if(d>b.x){var l=(b.x-(d-m))/m,l=l<0?0:l;break}}if(g==0&&this._ignores[0]){g=1;for(l=0;this._ignores[g];)g++}else if(g==this._cols.length&&this._ignores[g-1]){g=this._cols.length-1;for(l=0;this._ignores[g];)g--;g++}for(d=0;i<this._colsS.heights.length;i++)if(d+=this._colsS.heights[i],
d>b.y)break;b.fields={};a.y_unit[i]||(i=a.y_unit.length-1);if(i>=0&&a.y_unit[i]&&(b.section=b.fields[a.y_property]=a.y_unit[i].key,c)){if(c[a.y_property]!=b.section){var p=scheduler._get_timeline_event_height(c,a);c._sorder=scheduler._get_dnd_order(c._sorder,p,a._section_height[b.section])}c[a.y_property]=b.section}b.x=0;b.force_redraw=!0;b.custom=!0;var f;if(g>=a._trace_x.length)f=scheduler.date.add(a._trace_x[a._trace_x.length-1],a.x_step,a.x_unit),a._end_correction&&(f=new Date(f-a._end_correction));
else{var q=l*m*a._step+a._start_correction;f=new Date(+a._trace_x[g]+q)}if(this._drag_mode=="move"&&this._drag_id&&this._drag_event){var c=this.getEvent(this._drag_id),n=this._drag_event;b._ignores=this._ignores_detected||a._start_correction||a._end_correction;if(!n._move_delta&&(n._move_delta=(c.start_date-f)/6E4,this.config.preserve_length&&b._ignores))n._move_delta=this._get_real_event_length(c.start_date,f,a),n._event_length=this._get_real_event_length(c.start_date,c.end_date,a);if(this.config.preserve_length&&
b._ignores){var o=n._event_length,j=this._get_fictional_event_length(f,n._move_delta,a,!0);f=new Date(f-j)}else f=scheduler.date.add(f,n._move_delta,"minute")}if(this._drag_mode=="resize"&&c){var r=!!(Math.abs(c.start_date-f)<Math.abs(c.end_date-f));if(a._start_correction||a._end_correction){var s=!this._drag_event||this._drag_event._resize_from_start==void 0;s||Math.abs(c.end_date-c.start_date)<=6E4*this.config.time_step?this._drag_event._resize_from_start=b.resize_from_start=r:b.resize_from_start=
this._drag_event._resize_from_start}else b.resize_from_start=r}if(a.round_position)switch(this._drag_mode){case "move":if(!this.config.preserve_length&&(f=t.call(a,f,!1),a.x_unit=="day"))b.custom=!1;break;case "resize":if(this._drag_event){if(this._drag_event._resize_from_start==null)this._drag_event._resize_from_start=b.resize_from_start;b.resize_from_start=this._drag_event._resize_from_start;f=t.call(a,f,!this._drag_event._resize_from_start)}}b.y=Math.round((f-this._min_date)/(6E4*this.config.time_step));
b.shift=this.config.time_step;return b}};scheduler._get_timeline_event_height=function(a,c){var b=a[c.y_property],d=c.event_dy;c.event_dy=="full"&&(d=c.section_autoheight?c._section_height[b]-6:c.dy-3);c.resize_events&&(d=Math.max(Math.floor(d/a._count),c.event_min_dy));return d};scheduler._get_timeline_event_y=function(a,c){var b=a,d=2+b*c+(b?b*2:0);scheduler.config.cascade_event_display&&(d=2+b*scheduler.config.cascade_event_margin+(b?b*2:0));return d};scheduler.render_timeline_event=function(a,
c){var b=a[this.y_property];if(!b)return"";var d=a._sorder,h=w(a,!1,this),e=w(a,!0,this),k=scheduler._get_timeline_event_height(a,this),g=k-2;!a._inner&&this.event_dy=="full"&&(g=(g+2)*(a._count-d)-2);var i=scheduler._get_timeline_event_y(a._sorder,k),m=k+i+2;if(!this._events_height[b]||this._events_height[b]<m)this._events_height[b]=m;var l=scheduler.templates.event_class(a.start_date,a.end_date,a),l="dhx_cal_event_line "+(l||""),p=a.color?"background:"+a.color+";":"",f=a.textColor?"color:"+a.textColor+
";":"",q=scheduler.templates.event_bar_text(a.start_date,a.end_date,a),n='<div event_id="'+a.id+'" class="'+l+'" style="'+p+""+f+"position:absolute; top:"+i+"px; height: "+g+"px; left:"+h+"px; width:"+Math.max(0,e-h)+"px;"+(a._text_style||"")+'">';if(scheduler.config.drag_resize&&!scheduler.config.readonly){var o="dhx_event_resize";n+="<div class='"+o+" "+o+"_start' style='height: "+g+"px;'></div><div class='"+o+" "+o+"_end' style='height: "+g+"px;'></div>"}n+=q+"</div>";if(c){var j=document.createElement("DIV");
j.innerHTML=n;var r=this.order[b],s=scheduler._els.dhx_cal_data[0].firstChild.rows[r].cells[1].firstChild;scheduler._rendered.push(j.firstChild);s.appendChild(j.firstChild)}else return n};scheduler._renderMatrix=function(a,c){if(!c)scheduler._els.dhx_cal_data[0].scrollTop=0;scheduler._min_date=scheduler.date[this.name+"_start"](scheduler._date);scheduler._max_date=scheduler.date.add(scheduler._min_date,this.x_size*this.x_step,this.x_unit);scheduler._table_view=!0;if(this.second_scale){if(a&&!this._header_resized)this._header_resized=
scheduler.xy.scale_height,scheduler.xy.scale_height*=2,scheduler._els.dhx_cal_header[0].className+=" dhx_second_cal_header";if(!a&&this._header_resized){scheduler.xy.scale_height/=2;this._header_resized=!1;var b=scheduler._els.dhx_cal_header[0];b.className=b.className.replace(/ dhx_second_cal_header/gi,"")}}L.call(this,a)};scheduler._locate_cell_timeline=function(a){for(var a=a||event,c=a.target?a.target:a.srcElement,b={},d=scheduler.matrix[scheduler._mode],h=scheduler.getActionData(a),e=0;e<d._trace_x.length-
1;e++)if(+h.date<d._trace_x[e+1])break;b.x=e;b.y=d.order[h.section];var k=scheduler._isRender("cell")?1:0;b.src=d._scales[h.section]?d._scales[h.section].getElementsByTagName("td")[e+k]:null;for(var g=!1;b.x==0&&c.className!="dhx_cal_data"&&c.parentNode;)if(c.className.split(" ")[0]=="dhx_matrix_scell"){g=!0;break}else c=c.parentNode;if(g)b.x=-1,b.src=c,b.scale=!0;return b};var O=scheduler._click.dhx_cal_data;scheduler._click.dhx_marked_timespan=scheduler._click.dhx_cal_data=function(a){var c=O.apply(this,
arguments),b=scheduler.matrix[scheduler._mode];if(b){var d=scheduler._locate_cell_timeline(a);d&&(d.scale?scheduler.callEvent("onYScaleClick",[d.y,b.y_unit[d.y],a||event]):scheduler.callEvent("onCellClick",[d.x,d.y,b._trace_x[d.x],(b._matrix[d.y]||{})[d.x]||[],a||event]))}return c};scheduler.dblclick_dhx_marked_timespan=scheduler.dblclick_dhx_matrix_cell=function(a){var c=scheduler.matrix[scheduler._mode];if(c){var b=scheduler._locate_cell_timeline(a);b&&(b.scale?scheduler.callEvent("onYScaleDblClick",
[b.y,c.y_unit[b.y],a||event]):scheduler.callEvent("onCellDblClick",[b.x,b.y,c._trace_x[b.x],(c._matrix[b.y]||{})[b.x]||[],a||event]))}};scheduler.dblclick_dhx_matrix_scell=function(a){return scheduler.dblclick_dhx_matrix_cell(a)};scheduler._isRender=function(a){return scheduler.matrix[scheduler._mode]&&scheduler.matrix[scheduler._mode].render==a};scheduler.attachEvent("onCellDblClick",function(a,c,b,d,h){if(!(this.config.readonly||h.type=="dblclick"&&!this.config.dblclick_create)){var e=scheduler.matrix[scheduler._mode],
k={};k.start_date=e._trace_x[a];k.end_date=e._trace_x[a+1]?e._trace_x[a+1]:scheduler.date.add(e._trace_x[a],e.x_step,e.x_unit);if(e._start_correction)k.start_date=new Date(k.start_date*1+e._start_correction);if(e._end_correction)k.end_date=new Date(k.end_date-e._end_correction);k[e.y_property]=e.y_unit[c].key;scheduler.addEventNow(k,null,h)}});scheduler.attachEvent("onBeforeDrag",function(){return!scheduler._isRender("cell")});scheduler.attachEvent("onEventChanged",function(a,c){c._timed=this.isOneDayEvent(c)});
var P=scheduler._render_marked_timespan;scheduler._render_marked_timespan=function(a,c,b,d,h){if(!scheduler.config.display_marked_timespans)return[];if(scheduler.matrix&&scheduler.matrix[scheduler._mode]){if(!scheduler._isRender("cell")){var e=scheduler._lame_copy({},scheduler.matrix[scheduler._mode]);e.round_position=!1;var k=[],g=[],i=[];if(b)i=[c],g=[b];else{var m=e.order,l;for(l in m)m.hasOwnProperty(l)&&(g.push(l),i.push(e._scales[l]))}var d=d?new Date(d):scheduler._min_date,h=h?new Date(h):
scheduler._max_date,p=[];if(a.days>6){var f=new Date(a.days);scheduler.date.date_part(new Date(d))<=+f&&+h>=+f&&p.push(f)}else p.push.apply(p,scheduler._get_dates_by_index(a.days));for(var q=a.zones,n=scheduler._get_css_classes_by_config(a),o=0;o<g.length;o++)for(var c=i[o],b=g[o],j=0;j<p.length;j++)for(var r=p[j],s=0;s<q.length;s+=2){var t=q[s],x=q[s+1],z=new Date(+r+t*6E4),u=new Date(+r+x*6E4);if(d<u&&h>z){var y=scheduler._get_block_by_config(a);y.className=n;var C=w({start_date:z},!1,e)-1,A=w({start_date:u},
!1,e)-1,v=Math.max(1,A-C-1),D=e._section_height[b]-1;y.style.cssText="height: "+D+"px; left: "+C+"px; width: "+v+"px; top: 0;";c.insertBefore(y,c.firstChild);k.push(y)}}return k}}else return P.apply(scheduler,[a,c,b])};var Q=scheduler._append_mark_now;scheduler._append_mark_now=function(a,c){if(scheduler.matrix&&scheduler.matrix[scheduler._mode]){var b=scheduler._currentDate(),d=scheduler._get_zone_minutes(b),h={days:+scheduler.date.date_part(b),zones:[d,d+1],css:"dhx_matrix_now_time",type:"dhx_now_time"};
return scheduler._render_marked_timespan(h)}else return Q.apply(scheduler,[a,c])};scheduler.attachEvent("onScaleAdd",function(a,c){var b=scheduler._marked_timespans;if(b&&scheduler.matrix&&scheduler.matrix[scheduler._mode])for(var d=scheduler._mode,h=scheduler._min_date,e=scheduler._max_date,k=b.global,g=scheduler.date.date_part(new Date(h));g<e;g=scheduler.date.add(g,1,"day")){var i=+g,m=g.getDay(),l=[],p=k[i]||k[m];l.push.apply(l,scheduler._get_configs_to_render(p));if(b[d]&&b[d][c]){var f=[],q=
scheduler._get_types_to_render(b[d][c][m],b[d][c][i]);f.push.apply(f,scheduler._get_configs_to_render(q));f.length&&(l=f)}for(var n=0;n<l.length;n++){var o=l[n],j=o.days;j<7?(j=i,scheduler._render_marked_timespan(o,a,c,g,scheduler.date.add(g,1,"day")),j=m):scheduler._render_marked_timespan(o,a,c,g,scheduler.date.add(g,1,"day"))}}});scheduler._get_date_index=function(a,c){for(var b=0,d=a._trace_x;b<d.length-1&&+c>=+d[b+1];)b++;return b}})();