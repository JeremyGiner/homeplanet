/**
 * Main script, indended for gigablaster
 * 
 * @author GINER Jeremy
 */
console.log('OKOK');
//_____________________________________________________________________________

Number.prototype.padLeft = function (n,str) {
    return (this < 0 ? '-' : '') + 
		Array(
				n-String(Math.abs(this)).length+1
		).join(str||'0') + 
		(Math.abs(this));
};


$.fn.ajaxUpdate = function( sUrl, oParam ) {
	
	// Get var
	/*
	var sUrl = this.attr('data-ajaxupd-url');
	var oParam = this.attr('data-ajaxupd-param') | {};
	*/
	if( sUrl == null ) throw('Invalid url param');
	
	// Put loading style
	
	var _this = this;
	// Send ajax request
	$.ajax({
		type: 'GET',
		url: sUrl,
		cache: false,
		data: oParam,
		success: function( data ){
			$(_this).html( data );
			$(document).trigger('ajaxUpdate.success', {target: _this});
		},
		error: function( XMLHttpRequest, textStatus, errorThrown ) {
			console.log( errorThrown );
			console.log( XMLHttpRequest );
		}
	});
	
};

//_____________________________________________________________________________


//_____________________________________________________________________________
//	Boot

$(function() {

	//_________________________________
	// HAjust
	function hajust_update() {
		$('.hajust-square').each(function(){
			$(this).height( $(this).width() );
		});
	}

	$( window ).resize(function() {
		hajust_update();
	});
	
	$( document ).on('documentmodified', function () {
		hajust_update();
	});
	
	hajust_update();
	
	//	HAjust quick fix for bootstrap modal
	$(document).on('shown.bs.modal', function () {
		$(document).trigger('resize');
	});
	$(document).on('ajaxUpdate.success', function () {
		$(document).trigger('resize');
	});

	
	/*
	//TOOD update placeholder height on resize, add multiple element possible
	var menu = $('#nav-main');
	var pos = menu.offset();
	var $placeholder = $(document.createElement( "div" ));
	$placeholder.insertAfter( menu );
	$placeholder.height( menu.height() ); 
	$placeholder.addClass('nav-sticky-placeholder');
	$(window).scroll(function(){
		if($(this).scrollTop() > pos.top){
			menu.addClass('nav-sticky');
			menu.next().css(
					'margin-top', 
					parseInt( menu.css('margin-bottom') ) +
					parseInt( menu.css( "height" ) ) 
			);
		} else {
			menu.removeClass('nav-sticky');
			menu.next().css('margin-top', 0);
		} 
	});*/
	
	//TODO : improve
	// Put .active on tab toggler
	$(document).on('show.bs.tab', 'a[data-toggle="tab"]', function (e) {
		$('a[data-toggle="tab"]').removeClass('active');
		$(e.target).addClass('active');
	});
	
	//_________________________________
	// Twig js template
	
	// Compile all the template o/
	$("script[type='text/template']").each(function() {
	    var id = $(this).attr("id"),
	        data = $(this).text();
	    
	    Twig.twig({
	        id: id,
	        data: data,
	        allowInlineIncludes: true
	    });
	    console.log(id+' is compiled');
	});
	
	//_________________________________
	//	Initialise ajaxForm
	$(document).on('submit','.js-ajaxForm',function(){
		$(this).ajaxSubmit({
			data: { ajax: 'true' },
			success: function(){
				console.log('submited');
			}
		});
		$('.js-ajaxForm [type=submit]').hide();
		return false;
	})

	//_________________________________
	// Bootstrap tooltip
	$('[data-tooltip]').each(function () {
		$(this).tooltip({
			html: true,
			title: $($(this).data('tooltip')).html()
		});
	});
});

//_____________________________________________________________________________
// Namespace
var gigablaster = gigablaster || {};

//_____________________________________________________________________________
// Class timer

//_____________________________________
// Contructor

/**
 * @param number iTime time interval in millisecond
 * @param callback fnCallBack callback executed when expire
 */
gigablaster.Timer = function( iTime, fnCallBack ){
	
	this._iTimeStart = this._time_get();
	this._iTime = iTime;
	
	if( fnCallBack ) {
		this._fnCallback = fnCallBack;
		this._iTimeId = setTimeout( fnCallBack, this._iTime);
	} else {
		this._fnCallback = null;
		this._iTimeId = null;
	}
};


gigablaster.Timer.prototype = {
//_____________________________________
// Accessor
	timeRemaining_get: function() {
		return this._iTime - ( this._time_get() - this._iTimeStart );
	},
	
	_time_get() {
		return (new Date()).getTime();
	},

//_____________________________________
// Modifier

};

//_____________________________________________________________________________
//	Class Comet



//_____________________________________
//	Contructor
gigablaster.Comet = function( sURL ) {
	this._sURL = sURL;
	this._aListener = [];
};
gigablaster.Comet.prototype = {
//_____________________________________
//	Modifier
	/**
	 * @param string sKey server relative
	 * @param Date iTimestamp last modified timestamp in ms
	 */
	listener_add: function( sKey, iTimestamp ) {
		this._aListener.push({ objRef: sKey, timeModified: iTimestamp });
	},

	start: function() {
		this._request_send();
	},

//_____________________________________
//	Sub-routine

	_request_send: function() {
		var _this = this;

		//console.log( this._aListener );
		// TODO: check request URL length
		$.ajax({
			type: 'GET',
			url: this._sURL,
			cache: false,
			data: {
				listenerList: this._aListener
			},
			success: function( data ){
				
				if( _this._message_handle( data ) )
					_this._request_send();
			},
			error: function( XMLHttpRequest, textStatus, errorThrown ) {
				console.log( errorThrown );
				console.log( XMLHttpRequest );
			}
		});
	},
	/**
	 * @return bool true if loop request, false if end loop
	 */
	_message_handle: function( data ) {
		
		// Case do nothing
		if( data === false)
			return true;
		
		// Case reload
		if( data === true ) { 
			location.reload();
			return false;
		}
		
		// Case redirect
		if( data.redirect !== undefined ) {
			console.log( 'redirect' );
			document.location.assign(data.redirect);
			//Keep in mind the rest of the script is still executed
			return false;
		}
		
		// Update listener
		for( var i=0; i < data.listenerList.length; i++ ) {
			var oListener = data.listenerList[ i ];
			var aResult = $.grep( 
				this._aListener, 
				function(e) { return e.objRef ==  oListener.objRef; } 
			);
			for( var i; i < aResult.length; i++ )
				aResult[i].timeModified = oListener.timeModified;
		}
		
		// Update display
		this._displayModify( data.displayModifier );
		
		return true;
	},
	
	_displayModify: function( oDisplayModifier ) {
		switch( oDisplayModifier.type ) {
			case 'composite' :
				for( i = 0; i < oDisplayModifier.content.length; i++ )
					this._displayModify( oDisplayModifier.content[i] );
			break;
			case 'direct' :
				$( oDisplayModifier.target ).html( oDisplayModifier.content );
				$( oDisplayModifier.target ).trigger('documentmodified');
			break;
			case 'template' :
				var s = Twig.twig({ 
						ref: oDisplayModifier.template 
					}).render( oDisplayModifier.content ) 
				$( oDisplayModifier.target ).html( s );
				$( oDisplayModifier.target ).trigger('documentmodified');
			break;
			default: 
				console.log('ERROR: cannot read following type : ');
				console.log(oDisplayModifier.type);
		}
	}
};
//_____________________________________________________________________________
