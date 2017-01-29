/**
 * Main script, indended for gigablaster
 * 
 * @author GINER Jeremy
 * 
 */

//_____________________________________________________________________________
var clock_render = function () {
	
	if( !this._oTimer )
		this._oTimer = new gigablaster.Timer( 5 * 60 * 1000 );	//5 Min

	var d = new Date(this._oTimer.timeRemaining_get());
	//console.log(this._oTimer.timeRemaining_get());
	$('#SPAN-CLOCK').html( 
		d.getMinutes().padLeft( 2, '0' ) + 
		':' +
		d.getSeconds().padLeft( 2, '0' )
	);
}

setInterval(
	clock_render,
	1000
);



console.log( oGameView );
//_____________________________________________________________________________
