//slideshow
var jq = jQuery.noConflict();
var SimpleSlideshow = new Class({
	options: {
		showControls: true,
		showDuration: 3000,
		showTOC: true,
		tocWidth: 20,
		tocClass: 'toc',
		tocActiveClass: 'toc-active'
	},
	Implements: [Options,Events],
	initialize: function(container,elements,options) {
		//settings
		this.container = $(container);
		this.elements = $$(elements);
		this.currentIndex = 0;
		this.interval = '';
		if(this.options.showTOC) this.toc = [];
		
		//assign
		this.elements.each(function(el,i){
			if(this.options.showTOC) {
				this.toc.push(new Element('a',{
					text: i+1,
					href: '#',
					'class': this.options.tocClass + '' + (i == 0 ? ' ' + this.options.tocActiveClass : ''),
					events: {
						click: function(e) {
							if(e) e.stop();
							this.stop();
							this.show(i);
						}.bind(this)
					},
					styles: {
						right: 155-((i + 1) * (this.options.tocWidth + 10))
					}
				}).inject(this.container));
			}
			if(i > 0) el.set('opacity',0);
		},this);
		
		//next,previous links
		if(this.options.showControls) {
			this.createControls();
		}
		//events
		this.container.addEvents({
			mouseenter: function() { this.stop(); }.bind(this),
			mouseleave: function() { this.start(); }.bind(this)
		});

	},
	show: function(to) {
		this.elements[this.currentIndex].fade('out');
		if(this.options.showTOC) this.toc[this.currentIndex].removeClass(this.options.tocActiveClass);
		this.currentIndex = ($defined(to) ? to : (this.currentIndex < this.elements.length - 1 ? this.currentIndex + 1 : 0));
		this.elements[this.currentIndex].fade('in');
		if(this.options.showTOC) this.toc[this.currentIndex].addClass(this.options.tocActiveClass);
	},
	start: function() {
		this.interval = this.show.bind(this).periodical(this.options.showDuration);
	},
	stop: function() {
		$clear(this.interval);
	},
	//"private"
	createControls: function() {
		/*var next = new Element('a',{
			href: '#',
			id: 'next',
			text: '>>',
			events: {
				click: function(e) {
					if(e) e.stop();
					this.stop(); 
					this.show();
				}.bind(this)
			}
		}).inject(this.container);
		var previous = new Element('a',{
			href: '#',
			id: 'previous',
			text: '<<',
			events: {
				click: function(e) {
					if(e) e.stop();
					this.stop(); 
					this.show(this.currentIndex != 0 ? this.currentIndex -1 : this.elements.length-1);
				}.bind(this)
			}
		}).inject(this.container);
		*/
	}
});

/* usage */
window.addEvent('domready',function() {
	//jq("#mopbox").mopBox({'target':'#prod_detail','w':1000,'h':400});

/* jq(document).bind("contextmenu",function(e){
    return false;
});*/

	var slideshow = new SimpleSlideshow('slideshow-container','#slideshow-container img');
	slideshow.start();
});

function show_mopbox(divId) {
	jq("#" + divId).click();
}

function prod_click(product_id){
	jq("#prod_detail").load("product/mopbox_form/" + product_id,
		function(){
			jq("#mopbox").click();
		}
	);
}
 
function checkout() {
	location.href="checkout.php";
}

function checkout2() {
	location.href="checkout2.php";
}

function checkout3() {
	location.href="checkout3.php";
}
 	
function paypal() {
	location.href="http://paypal.com";
}
