(function( $, undefined ) {

	'use strick';

	/*
	 * DENNY K.
	 * indySliceSlider object.
	 */

	 $.indySliceSlider  		= function( element, options ) {

	 	this.$el    = $( element );
	 	this._init( options );

	 };

	 $.indySliceSlider.defaults       = {

	 	'slideClass' : '.slice-slide',
	 	'autoplay' 	 : 5000,

	 };

	 $.indySliceSlider.prototype   = {

	 	_init               : function( options ) {

	 		var _self = this;

	 		this.options  = $.extend( true, {}, $.indySliceSlider.defaults, options );			

	 		_self.slideSet 		= _self.$el.find(this.options.slideClass);
	 		_self.sSize 		= _self.slideSet.size();
	 		_self.sSizeD 		= _self.sSize - 1;
	 		_self.active		= 1;
	 		_self.delta 		= true;

	 		_self._config();
	 		_self._events();
	 		_self._slide(0, 1, true);	 			

	 	},

	 	_events : function() {


	 		var
	 		_self 		= this,
	 		element 	= _self.$el;

	 		element
	 		.on('click', '.arrow.prev button', function() {

	 			_self._slideCallback(-1);

	 		})
	 		.on('click', '.arrow.next button', function() {

	 			_self._slideCallback(1);

	 		})
	 		.on('click', '.slider-tumb li:not(.active)', function() {

	 			_self._slide($(this).index(), false, false);

	 		})
	 		.on('click', '.slider-tumb li:not(.active), .arrow button', function() {

	 			_self._autoPlayOff();
	 			_self._autoPlayOn();

	 		});

	 		if (_self.options.autoplay) {_self._autoPlayEvents();}	

	 	},

	 	_autoPlayOff : function () {

	 		var
	 		_self = this;

	 		clearInterval(_self.myInterval);
	 		clearInterval(_self.myInterval - 1);


	 	},

	 	_autoPlayOn : function () {

	 		var
	 		_self = this;

	 		_self.myInterval = setInterval(function() {

	 			_self._slideCallback(1);

	 		}, _self.options.autoplay);


	 	},

	 	_autoPlayEvents : function () {

	 		var 
	 		_self = this;

	 		$(window)
	 		.on("blur focus load", function(e) {

	 			_self._autoPlayCallback(e);

	 		});

	 	},

	 	_autoPlayCallback : function (e) {

	 		var 
	 		_self 		= this,
	 		prevType 	= _self.prevType;

	 		if (prevType != e.type) {   

	 			if (e.type == "blur") {

	 				_self._autoPlayOff();

	 			}

	 			if (e.type == "focus" || e.type == "load") {

	 				_self._autoPlayOff();
	 				_self._autoPlayOn();

	 			}

	 		}

	 		_self.prevType = e.type;

	 	},

	 	_config : function() {

	 		var
	 		_self 		= this,
	 		_control 	= _self.options.control;

	 		_self.$el.addClass('slice-slider animationoff').css('overflow', 'hidden');

	 		_self._cloneSlide();
	 		_self._addControl();
	 		_self._addTumb();	 		

	 	},

	 	_addControl : function() {

	 		var
	 		_self = this;

	 		_self.$el.append('<span class="arrow prev"><button></button></span><span class="arrow next"><button></button></span>');

	 	},

	 	_addTumb : function () {


	 		var 
	 		_self 	=  this,
	 		element = _self.$el,
	 		sSize 	= _self.sSize;
	 		tumb 	= [];

	 		for (var i=0; i<sSize; i++) {

	 			tumb.push('<li><span></span></li>');

	 		}

	 		element.append('<section class="slider-tumb">'+tumb.join('')+'</section>');
	 		_self.tumb = element.find('.slider-tumb li');

	 	},

	 	_cloneSlide : function () {

	 		var
	 		_self 		= this,
	 		element 	= _self.slideSet.find('.slice-part');

	 		element.each(function() {

	 			var 
	 			el = $(this);

	 			for (var i=0; i<4; i++) {

	 				el.before(el.clone());

	 			} 


	 		});

	 	},

	 	_slideCallback : function (direction) {

	 		var
	 		_self 		= this,
	 		active 		= _self.active,
	 		newActive 	= _self._slideIndex(active, direction);


	 		_self._slide(newActive, direction, false);

	 	},

	 	_slideIndex : function(index, direction) {

	 		var 
	 		_self 		= this,
	 		sSizeD 		= _self.sSizeD,
	 		newIndex   	= index + direction,
	 		delta		= false,
	 		out;

	 		if (newIndex > sSizeD) {

	 			newIndex 	= 0;

	 		}

	 		if (newIndex < 0) {

	 			newIndex 	= sSizeD;

	 		}

	 		return newIndex;

	 	},

	 	_setActive : function (activeIndex, direction) {

	 		var
	 		_self 			= this,
	 		prev 			= direction ? _self._slideIndex(activeIndex, -direction) : _self.active;

	 		_self.active 	= activeIndex;

	 		_self._setSlide(prev, activeIndex);
	 		_self._setTumb(activeIndex);


	 	},

	 	_slide : function (activeIndex, direction, preset) {

	 		var
	 		_self 			= this,
	 		prev 			= direction ? _self._slideIndex(activeIndex, -direction) : _self.active;

	 		_self.active 	= activeIndex;

	 		_self._setSlide(prev, activeIndex);
	 		_self._setTumb(activeIndex);

	 		if (_self.delta && !preset) {_self.$el.removeClass('animationoff'); _self.delta = false;}

	 	},

	 	_setTumb : function(active) {

	 		var
	 		_self 	= this,
	 		tumb 	= _self.tumb;

	 		tumb
	 		.removeClass("active")
	 		.eq(active)
	 		.addClass("active");

	 	},

	 	_setSlide : function(prev, active) {

	 		var
	 		_self 		= this,
	 		slideSet 	= _self.slideSet;

	 		slideSet
	 		.removeClass('active prev')
	 		.eq(active)
	 		.addClass("active")
	 		.end()
	 		.eq(prev)
	 		.addClass("prev");

	 	},


	 };


	 $.fn.indySliceSlider          = function( options ) {

	 	var args = Array.prototype.slice.call(arguments, 1);
	 	return this.each(function() {
	 		var item = $(this), instance = item.data('indySliceSlider');
	 		if(!instance) {

	 			item.data('indySliceSlider', new $.indySliceSlider(this, options));

	 		} else {

	 			if(typeof options === 'string') {
	 				instance[options].apply(instance, args);
	 			}
	 		}
	 	});		

	 };

	})( jQuery );

