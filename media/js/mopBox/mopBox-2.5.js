/*
 * mopBox 2.5.0
 * By Hiroki Miura (http://www.mopstudio.jp)
 * Copyright (c) 2009 mopStudio
 * Licensed under the MIT License: http://www.opensource.org/licenses/mit-license.php
 * Nobember 19, 2009
*/

/*path to image*/
var mpBxClsBtnF=new Image();
var mpBxFwd=new Image();
var mpBxBwd=new Image();
var mpBxFwdF=new Image();
var mpBxBwdF=new Image();
var mpBxLtAw=new Image();
var mpBxLtAwF=new Image();
var mpBxLtAwF2=new Image();
var mpBxRtAw=new Image();
var mpBxRtAwF=new Image();
var mpBxRtAwF2=new Image();
mpBxClsBtnF.src="/camportco2/media/css/mopBox/sldClsF.png";
mpBxFwd.src="/camportco2/media/css/mopBox/sldRtB.png";
mpBxBwd.src="/camportco2/media/css/mopBox/sldLtB.png";
mpBxFwdF.src="/camportco2/media/css/mopBox/sldRtBF.png";
mpBxBwdF.src="/camportco2/media/css/mopBox/sldLtBF.png";
mpBxLtAw.src="/camportco2/media/css/mopBox/sldBtnLt.png";
mpBxLtAwF.src="/camportco2/media/css/mopBox/sldBtnLtF.png";
mpBxLtAwF2.src="/camportco2/media/css/mopBox/sldBtnLtF2.png";
mpBxRtAw.src="/camportco2/media/css/mopBox/sldBtnRt.png";
mpBxRtAwF.src="/camportco2/media/css/mopBox/sldBtnRtF.png";
mpBxRtAwF2.src="/camportco2/media/css/mopBox/sldBtnRtF2.png";
var mpBxCnt=0;
var mpBxNum=0;
var mpBxPs;
var mpBxCt="";
var mpBxSldPs,mpBxP;
var mpBxTgt,mpBxPgH,mpBxPgW,mpBxSpd,mpBxStp,mpBxStpPx,mpBxStP,mpBxBgc,mpBxRz,mpBxRszTg;
var mpBxNvPs,mpBxFbPs,mpBxBtnW;
var mpBxCkNum,mpBxCkNum2=0;
var mpBxSldW,mpBxSldMx,mpBxSldDg;
var mpBxCntH=0,mpBxCntW=0;
var mpBxUa,mpBxMac,mpBxWin,mpBxBrw,mpBxIe=false;
var hvChkItv,hvChkItv2,mpBxBtnCk="n",mpBxMsOv="n",mpBxMsOv2="n";
var idCheck=[];
jQuery.fn.extend({
	mopBox: function(stt) {
		var mpBxF,thsCnt;
		var stopNum=[];
		var check,check2,check3;
		var startH,stTgtH,startW,stTgtW;
		var kpH,nwH,kpW,nwW;
		var mpBxRzY,mpBxRzX;
		var tgtH,tgtHtKp;
		var tgtW,tgtWdKp;
		var chkId;
		var dblclk=false;
		var hldLtMx;
		var hvChk,clk='n',ltClk='n',rtClk='n';
		var hvChk2,hvChk3;
		jq(this).click(function(){
			if(mpBxCnt==0){
				mpBxUa=navigator.userAgent;
				if(mpBxUa.indexOf("Mac",0)>=0){
					mpBxMac=true;
				}else if(mpBxUa.indexOf("Win",0)>=0){
					mpBxWin=true;
				};
				if(mpBxUa.indexOf("MSIE 6")>-1){mpBxBrw="ie6";};
				if(mpBxUa.indexOf("MSIE 7")>-1){mpBxBrw="ie7";};
				if(mpBxUa.indexOf("MSIE")>-1){mpBxIe=true;};
			};
			var href=jq(this).attr("href");
			if(jq(this).attr("href")){
				//jq(this).attr({href:"#?mopBox"});
				jq(this).attr({href:"#?p"});
			};
			mpBxCnt+=1;;
			thsCnt=jQuery.data(this);
			
			// Set to 1st page
			mpBxStP = 1;
			mpBxNum=mpBxStP-1;
			jq("#mpBx .pageNumber").html(mpBxStP);
			jq("#mpBx .holder").css({left:-(mpBxPgW*(mpBxStP-1))+"px"});
			jq("#mpBx .sliderBtn").css({left:(mpBxStpPx*(mpBxStP-1))/mpBxStp+"px"});
			
			mpBxF.init();
		});
		mpBxF={
			init:function(){
				mpBxTgt=stt.target;
				mpBxPgW=stt.w;
				mpBxPgH=stt.h;
				mpBxSpd=stt.speed;
				mpBxStp=stt.step;
				mpBxStpPx=stt.stepPx;
				mpBxNvPs=stt.naviPosi;
				mpBxFbPs=stt.fbPosi;
				mpBxBtnW=stt.btnW;
				mpBxStP=stt.startPage;
				mpBxBgc=stt.bgc;
				mpBxRz=stt.resize;
				mpBxRszTg=stt.rszTarget;
				var mopBoxFnc=function(){
					if(stt.fnc!=null){
						/*customize hire for your web site*/
						if(stt.fnc=="pChange"){news.pChange();};
						if(stt.fnc=="demoFnc"){demoFnc();};
						/* + + + */
					};
				};
				jq("#mpBx .sliderBtn").draggable("destroy");
				jq("#mpBx .case").resizable('destroy');
				jq("#mpBx .holder").children().remove();
				if(mpBxStp==null){mpBxStp=1;};
				if(mpBxStpPx==null){mpBxStpPx=10;};
				if(mpBxSpd==null){mpBxSpd=300;};
				if(mpBxNvPs==null){mpBxNvPs=5;};
				if(mpBxFbPs==null){mpBxFbPs=50;};
				if(mpBxBtnW==null){mpBxBtnW=100;};
				if(mpBxStP==null){mpBxStP=1;};
				if(mpBxRz=="se"){mpBxRz="s,e,se"}
				mpBxCkNum=mpBxStpPx/mpBxStp;
				if(mpBxCnt==1){
					if (jq("#mpBx .holder") == null || jq("#mpBx .holder").length == 0) { // Additional code
					
					jq("body").append(
						'<div id="mpBx" class="dialog">'+
							'<div class="s-topLeft"></div>'+
							'<div class="s-top"></div>'+
							'<div class="s-left"></div>'+
							'<div class="s-topRight"></div>'+
							'<div class="s-right"></div>'+
							'<div class="s-bottomLeft"></div>'+
							'<div class="s-bottom"></div>'+
							'<div class="s-bottomRight"></div>'+
							'<div class="cover"></div>'+
							'<div class="case">'+
								'<div class="holder"></div>'+
							'</div>'+
							'<div class="fwd"></div>'+
							'<div class="bwd"></div>'+
							'<div class="slider">'+
								'<div class="sldLeft"></div>'+
								'<div class="sldCenter"></div>'+
								'<div class="sldRight"></div>'+
								'<div class="sliderBtn">'+
									'<div class="sldBtnLeft"></div>'+
									'<div class="sldBtnCenter"><div class="pageNumber"></div></div>'+
									'<div class="sldBtnRight"></div>'+
								'</div>'+
							'</div>'+
							'<div class="closeBtn"></div>'+
						'</div>'
					);
					jq(".closeBtn").click(
						function(){
							jq("#mpBx .sliderBtn").draggable("destroy");
							jq("#mpBx .slider,#mpBx .fwd,#mpBx .bwd").hide();
							jq("#mpBx .s-topLeft, #mpBx .s-top, #mpBx .s-left, #mpBx .s-topRight, #mpBx .s-right").hide();
							jq("#mpBx .s-bottomLeft, #mpBx .s-bottom, #mpBx .s-bottomRight,#mpBx .closeBtn,#mpBx object").hide();
							jq("#mpBx").fadeOut("slow");
					});
					jq("#mpBx .fwd,#mpBx .bwd,#mpBx .closeBtn").hover(
						function(){jq("#mpBx").draggable("disable")},
						function(){jq("#mpBx").draggable("enable")}
					);
					jq("#mpBx").draggable({cancel:"#mpBx .slider,object,.scrollBox"});
					if(mpBxBrw!="ie6"){
						jq("#mpBx .pageNumber").mouseover(
							function(){
								if((mpBxBtnCk=='n')&&(clk=='n')){
									mpBxMsOv='y';
									clearInterval(hvChk);
									hvChk=setInterval("hvChkItv()",20);
								}
							}
						);
						jq("#mpBx .pageNumber").mouseout(
							function(){
								if((mpBxBtnCk=='n')&&(clk=='n')){
									clearInterval(hvChk);
									jq("#mpBx .sldBtnLeft").css({backgroundImage:"url("+mpBxLtAw.src+")"});
									jq("#mpBx .sldBtnRight").css({backgroundImage:"url("+mpBxRtAw.src+")"});
								}
								mpBxMsOv='n';
							}
						);
						jq("#mpBx .pageNumber").mouseup(function(){mpBxBtnCk='n';});
						jq("#mpBx .pageNumber").mousedown(function(){mpBxBtnCk='y';});
						jq("body").mouseup(function(){
							if((mpBxMsOv=='n')&&(mpBxBtnCk=='y')){
								mpBxBtnCk='n';
								clearInterval(hvChk);
								jq("#mpBx .sldBtnLeft").css({backgroundImage:"url("+mpBxLtAw.src+")"});
								jq("#mpBx .sldBtnRight").css({backgroundImage:"url("+mpBxRtAw.src+")"});
							};
						});
						jq("#mpBx .sldBtnLeft").hover(
							function(){
								if((mpBxNum!=0)&&(clk=='n')){jq(this).css({backgroundImage:"url("+mpBxLtAwF2.src+")"});}
							},function(){
								if((ltClk=='n')&&(clk=='n')){
									jq(this).css({backgroundImage:"url("+mpBxLtAw.src+")"});
								}
							}
						);
						jq("#mpBx .sldBtnRight").hover(
							function(){
								if((mpBxNum!=(mpBxP-1))&&(clk=='n')){
									jq(this).css({backgroundImage:"url("+mpBxRtAwF2.src+")"});
								};
							},
							function(){
								if((rtClk=='n')&&(clk=='n')){
									jq(this).css({backgroundImage:"url("+mpBxRtAw.src+")"});
								}
							}
						);
						jq("#mpBx .fwd").hover(
							function(){
								mpBxMsOv2='yf';
								clearInterval(hvChk2);
								hvChk2=setInterval("hvChkItv2()",20);
							},
							function(){
								clearInterval(hvChk2);
								jq("#mpBx .fwd").css({backgroundImage:"url("+mpBxFwd.src+")"});
								jq("#mpBx .sldBtnRight").css({backgroundImage:"url("+mpBxRtAw.src+")"});
							}
						);
						jq("#mpBx .bwd").hover(
							function(){
								mpBxMsOv2='yb';
								clearInterval(hvChk3);
								hvChk3=setInterval("hvChkItv3()",20);
							},
							function(){
								clearInterval(hvChk3);
								jq("#mpBx .bwd").css({backgroundImage:"url("+mpBxBwd.src+")"});
								jq("#mpBx .sldBtnLeft").css({backgroundImage:"url("+mpBxLtAw.src+")"});
							}
						);
					}
					jq("#mpBx .fwd").click(function(){mpBxF.goAndBack("fwd");});
					jq("#mpBx .bwd").click(function(){mpBxF.goAndBack("bwd")});
					var stop0=function(){
						clk='n'
						ltClk='n';
						clearInterval(check2);
						jq("#mpBx .pageNumber").html(1);
						jq("#mpBx .holder").css({left:"0px"});
						mpBxNum=0;
						if(mpBxBrw!="ie6"){
							jq("#mpBx .sldBtnLeft").css({backgroundImage:"url("+mpBxLtAw.src+")"});
						};
					};
					var stopMax=function(){
						clk='n'
						rtClk='n';
						clearInterval(check2);
						jq("#mpBx .pageNumber").html(mpBxP);
						jq("#mpBx .holder").css({left:hldLtMx+"px"});
						mpBxNum=mpBxP-1;
						if(mpBxBrw!="ie6"){
							jq("#mpBx .sldBtnRight").css({backgroundImage:"url("+mpBxRtAw.src+")"});
						};
					};
					jq("#mpBx .sldBtnLeft").click(function(){
						clk='y'
						ltClk='y'
						var page=jq("#mpBx .pageNumber").html();
						if(page!=1){
							jq("#mpBx .sliderBtn").animate({left:0+"px"},500,"linear",function(){stop0();});
							check2=setInterval("mpBxSldDg2()",10);
						};
					});
					jq("#mpBx .sldBtnRight").click(function(){
						clk='y'
						rtClk='y'
						mpBxSldMx=mpBxSldW-mpBxBtnW;
						hldLtMx=-(mpBxPgW*(mpBxP-1));
						var page=jq("#mpBx .pageNumber").html();
						if(page!=mpBxP){
							jq("#mpBx .sliderBtn").animate({left:mpBxSldMx+"px"},500,"linear",function(){stopMax();});
							check2=setInterval("mpBxSldDg2()",10);
						};
					});
				}
				}; // if(mpBxCnt==1)
				jq("#mpBx").pngFix();
				jq("#mpBx").css({width:mpBxPgW+40+"px",height:mpBxPgH+40+"px"});
				jq("#mpBx .s-bottom,#mpBx .s-bottomLeft,#mpBx .s-bottomRight").css({"top":mpBxPgH+20+"px"});
				jq("#mpBx .case,#mpBx .s-top,#mpBx .s-bottom").css({width:mpBxPgW+"px"});
				jq("#mpBx .case,#mpBx .s-left,#mpBx .s-right").css({height:mpBxPgH+"px"});
				jq("#mpBx .s-right,#mpBx .s-topRight,#mpBx .s-bottomRight").css({left:mpBxPgW+20+"px"});
				if(mpBxRz!=null){
					if(mpBxRszTg!=null){
						if(mpBxBrw=="ie6"){
							jq(mpBxRszTg).css({display:"inline"})
						};
						tgtH=stt.rzH;
						tgtW=stt.rzW;
					};
					if((mpBxCnt==1)||(thsCnt!=mpBxCt)){
						chkId=jQuery.inArray(thsCnt,idCheck);
						if(chkId==-1){
							idCheck.push(thsCnt);
						}else{
							nwH=tgtH;
							nwW=tgtW;
							if(mpBxCntH!=0){	
								if(mpBxRszTg!=null){
									jq(mpBxRszTg).css({height:tgtH+"px"});
									jq(mpBxRszTg).css({width:tgtW+"px"});
								};
							};
						};
					}else{
						if(mpBxCntH!=0){
							mpBxCntH=mpBxPgH;
							mpBxCntW=mpBxPgW;
							nwH=tgtH;
							nwW=tgtW;
							if(mpBxRszTg!=null){
								jq(mpBxRszTg).css({height:nwH});
								jq(mpBxRszTg).css({width:nwW});
							};
							jq("#mpBx .case").css({height:mpBxCntH+"px"});
							jq("#mpBx .case").css({width:mpBxCntW+"px"});
							jq("#mpBx .s-bottom,#mpBx .s-bottomLeft,#mpBx .s-bottomRight").css({top:mpBxCntH+20+"px"});
							jq("#mpBx .s-right,#mpBx .s-bottomRight,#mpBx .s-topRight").css({left:mpBxCntW+20+"px"});
							jq("#mpBx .s-left,#mpBx .s-right").css({height:mpBxCntH+"px"});
							jq("#mpBx .s-top,#mpBx .s-bottom").css({width:mpBxCntW+"px"});
						};
					};
					jq("#mpBx .case").resizable({
						resize:function(){
							if(mpBxRz!=null){
								mpBxCntH=eval(jq("#mpBx .case").css("height").split("px")[0]);
								mpBxCntW=eval(jq("#mpBx .case").css("width").split("px")[0]);
								mpBxRzY=mpBxCntH-mpBxPgH;
								mpBxRzX=mpBxCntW-mpBxPgW;
								if(mpBxRszTg!=null){
									nwH=tgtH+mpBxRzY+"px"
									nwW=tgtW+mpBxRzX+"px"
									jq(mpBxRszTg).css({height:nwH});
									jq(mpBxRszTg).css({width:nwW});
								};
								jq("#mpBx .s-bottom,#mpBx .s-bottomLeft,#mpBx .s-bottomRight").css({top:mpBxCntH+20+"px"});
								jq("#mpBx .s-right,#mpBx .s-bottomRight,#mpBx .s-topRight").css({left:mpBxCntW+20+"px"});
								jq("#mpBx .s-left,#mpBx .s-right").css({height:mpBxCntH+"px"});
								jq("#mpBx .s-top,#mpBx .s-bottom").css({width:mpBxCntW+"px"});
							};
						},
						handles:mpBxRz
					});
				}else{
					jq("#mpBx .case").resizable('destroy');
				};
				mpBxF.findPosi();
				if(thsCnt!=mpBxCt){
					mpBxCkNum2=0;
					mpBxNum=mpBxStP-1;
					if(mpBxStP==1){
						jq("#mpBx .pageNumber").html(mpBxStP);
						jq("#mpBx .holder").css({left:-(mpBxPgW*(mpBxStP-1))+"px"});
						jq("#mpBx .sliderBtn").css({left:(mpBxStpPx*(mpBxStP-1))/mpBxStp+"px"});
						mpBxCt=thsCnt;
					};
				};
				var ready1=jq(mpBxTgt).html();
				ready1=jQuery.trim(ready1);
				if(ready1.indexOf("<!--")==0){
					var ready2=ready1.split("<!--")[1];
					var ready3=ready2.split("-->")[0];
					jq("#mpBx .holder").append('<div>'+ready3+'</div>');
				}else{
					(jq(mpBxTgt)).clone().appendTo("#mpBx .holder");
				};
				mpBxP=jq("#mpBx .holder").children().children().length;
				if(mpBxP==1){
					jq("#mpBx .slider,#mpBx .fwd,#mpBx .bwd").hide();
				};
				for (i=1; i<mpBxP; i++){
					var num=mpBxPgW*i;
					stopNum.push(num);
				};
				jq("#mpBx .holder").children().css({width:mpBxPgW*mpBxP+"px",position:"absolute"});
				jq("#mpBx .holder").children().children().css({float:"left"});
				jq("#mpBx .holder").children().show();
				if(mpBxBgc!=null){
					jq("#mpBx .case").css({backgroundColor:mpBxBgc});
				}else{
					jq("#mpBx .case").css({backgroundColor:""});
				};
				var sliderH=eval(jq("#mpBx .slider").css("height").split("px")[0]);
				var stepAll=mpBxStpPx*(mpBxP-1);
				mpBxSldW=(stepAll/mpBxStp)+mpBxBtnW;
				var sidL =((mpBxPgW-mpBxSldW)/2)+20;
				jq("#mpBx .sliderBtn").css({width:mpBxBtnW+"px"});
				jq("#mpBx .slider").css({width:mpBxSldW+"px",left:sidL+"px",top:mpBxPgH+20+mpBxNvPs+"px"});
				jq("#mpBx .bwd").css({left:(sidL-mpBxFbPs)+"px",top:mpBxPgH+20+mpBxNvPs+"px"});
				jq("#mpBx .fwd").css({right:(sidL-mpBxFbPs)+"px",top:mpBxPgH+20+mpBxNvPs+"px"});
				jq("#mpBx .cover").css({top:mpBxPgH+20+"px",height:sliderH+mpBxNvPs+5+"px",width:mpBxPgW+"px",left:"20px"});
				jq("#mpBx .sldLeft").css({left:"0px"});
				jq("#mpBx .sldRight").css({right:"0px"});
				jq("#mpBx .sldCenter").css({left:"20px",width:mpBxSldW-40+"px"});
				jq("#mpBx .sldBtnLeft").css({left:"0px"});
				jq("#mpBx .sldBtnRight").css({right:"0px"});
				jq("#mpBx .sldBtnCenter").css({left:"20px",width:mpBxBtnW-40+"px"});
				var showParts=function(){
					jq("#mpBx .s-topLeft, #mpBx .s-top, #mpBx .s-left, #mpBx .s-topRight, #mpBx .s-right").show();
					jq("#mpBx .s-bottomLeft, #mpBx .s-bottom, #mpBx .s-bottomRight").show();
					if(mpBxP!=1){
						jq("#mpBx .slider,#mpBx .fwd,#mpBx .bwd").show();
					}
					jq("#mpBx .closeBtn").show();
					mopBoxFnc();
				};
				jq("#mpBx").fadeIn("normal",function(){showParts();});
				var startAnim=function(){
					clearInterval(check3)
					jq("#mpBx .pageNumber").html(mpBxStP);
					jq("#mpBx .holder").css({left:-(mpBxPgW*(mpBxStP-1))+"px"});
					mpBxNum=mpBxStP-1;
				};
				if(thsCnt!=mpBxCt){
					if(mpBxStP!=1){
						jq("#mpBx .sliderBtn").animate({left:(mpBxStpPx*(mpBxStP-1))/mpBxStp+"px"},500,"linear",function(){startAnim()});
						check3=setInterval("mpBxSldDg2()",10);
						mpBxCt=thsCnt;
					};
				};
				mpBxF.sliderDrag();
				mpBxSldMx=mpBxSldW-mpBxBtnW;
				hldLtMx=-(mpBxPgW*(mpBxP-1));
				if(mpBxMac==true){jq("#mpBx .pageNumber").css({fontSize:"9px",paddingTop:"12px"});};
			},
			sliderDrag:function(){
				jq("#mpBx .sliderBtn").draggable({
					axis:"x",
					cursor:"default",
					containment:"parent",
					grid:[mpBxStpPx],
					start:function(){
						check=setInterval("mpBxSldDg()",10);
					},
					drag:function(){},
					stop:function(){
						clearInterval(check);
						jq("#mpBx .holder").animate(
							{left:((mpBxNum*mpBxPgW)*-1)+"px"},
							{duration:mpBxSpd,easing:'swing'}
						);
					}
				});
			},
			goAndBack:function(whitch){
				if(mpBxCkNum<1){
					if(mpBxCkNum2>=1){mpBxCkNum2-=1;};
					mpBxCkNum2+=mpBxCkNum;
				}else{
					mpBxCkNum2=mpBxCkNum;
				};
				hdPosi=eval(Math.floor(jq("#mpBx .holder").css("left").split("px")[0]));
				mpBxSldPs=eval(Math.floor(jq("#mpBx .sliderBtn").css("left").split("px")[0]));
				if(((mpBxNum+1)<mpBxP)&&(whitch=="fwd")){
					jq("#mpBx .holder").animate(
						{left:hdPosi-mpBxPgW+"px"},
						{duration:mpBxSpd,complete:function (){mpBxF.goAndBack2()}
					});
					mpBxNum+=1;
					jq("#mpBx .pageNumber").html(""+(mpBxNum+1));
					if((mpBxCkNum2>=1)&&(mpBxSldPs<(mpBxSldMx))){
						jq("#mpBx .sliderBtn").css({left:mpBxSldPs+mpBxCkNum2+"px"});
					};
				}else if(((mpBxNum+1)>1)&&(whitch=="bwd")){
					jq("#mpBx .holder").animate(
						{left:hdPosi+mpBxPgW+"px"},
						{duration:mpBxSpd,complete:function (){mpBxF.goAndBack2()}
					});
					mpBxNum-=1;
					jq("#mpBx .pageNumber").html(""+(mpBxNum+1));
					if(mpBxCkNum2>=1){
						jq("#mpBx .sliderBtn").css({left:mpBxSldPs-mpBxCkNum2+"px"});
					};
				}
			},
			goAndBack2:function(){
				var mpBxCkNumPx=jq("#mpBx .holder").css("left");
				var mpBxCkNumMns=mpBxCkNumPx.split("px")[0];
				var mpBxCkNum=mpBxCkNumMns*-1
				var check=jQuery.inArray(mpBxCkNum,stopNum);
				if(check==-1){
					if(((mpBxNum+1)<mpBxP)||((mpBxNum+1)>1)){
						jq("#mpBx .holder").animate(
							{left:(mpBxPgW*(mpBxNum*-1))+"px"},{duration:mpBxSpd});
					};
				};
			},
			findPosi:function(){
				var dPosiT,dPosiL;
				var windW=document.documentElement.clientWidth;
				var windH=document.documentElement.clientHeight;
				if(mpBxIe==true){
					var scrollY=document.documentElement.scrollTop;
					var scrollX=document.documentElement.scrollLeft;
				}else{
					var scrollY=window.pageYOffset;
					var scrollX=window.pageXOffset;
				};
				dPosiT=((windH/2)+scrollY)-((mpBxPgH/2)+20);
				dPosiL=((windW/2)+scrollX)-(((mpBxPgW*1)+40)/2);
				jq("#mpBx").css({position:"absolute",top:dPosiT+"px",left:dPosiL+"px"});
			}
		};
		mpBxSldDg=function(whitch){
			mpBxSldPs=jq("#mpBx .sliderBtn").css("left").split("px")[0];
			mpBxNum=(mpBxSldPs/mpBxStpPx)*mpBxStp;
			jq("#mpBx .pageNumber").html(~~(mpBxNum+1));
		};
		mpBxSldDg2=function(whitch){
			mpBxSldDg();
			jq("#mpBx .holder").css({left:((mpBxNum*mpBxPgW)*-1)+"px"});
		};
		hvChkItv=function(){
			if((mpBxNum!=0)&&(mpBxNum!=(mpBxP-1))){
				jq("#mpBx .sldBtnRight").css({backgroundImage:"url("+mpBxRtAwF.src+")"});	
				jq("#mpBx .sldBtnLeft").css({backgroundImage:"url("+mpBxLtAwF.src+")"});
			}else if(mpBxNum!=0){
				jq("#mpBx .sldBtnRight").css({backgroundImage:"url("+mpBxRtAw.src+")"});
				jq("#mpBx .sldBtnLeft").css({backgroundImage:"url("+mpBxLtAwF.src+")"});
			}else if(mpBxNum!=(mpBxP-1)){
				jq("#mpBx .sldBtnRight").css({backgroundImage:"url("+mpBxRtAwF.src+")"});	
				jq("#mpBx .sldBtnLeft").css({backgroundImage:"url("+mpBxLtAw.src+")"});
			};
		};
		hvChkItv2=function(){
			if(mpBxNum!=(mpBxP-1)){
				jq("#mpBx .fwd").css({backgroundImage:"url("+mpBxFwdF.src+")"});
				jq("#mpBx .sldBtnRight").css({backgroundImage:"url("+mpBxRtAwF.src+")"});
			}else{
				jq("#mpBx .fwd").css({backgroundImage:"url("+mpBxFwd.src+")"});
				jq("#mpBx .sldBtnRight").css({backgroundImage:"url("+mpBxRtAw.src+")"});
			}
		};	
		hvChkItv3=function(){
			if(mpBxNum!=0){
				jq("#mpBx .bwd").css({backgroundImage:"url("+mpBxBwdF.src+")"});
				jq("#mpBx .sldBtnLeft").css({backgroundImage:"url("+mpBxLtAwF.src+")"});
			}else{
				jq("#mpBx .bwd").css({backgroundImage:"url("+mpBxBwd.src+")"});
				jq("#mpBx .sldBtnLeft").css({backgroundImage:"url("+mpBxLtAw.src+")"});
			}
		};	
	}
});