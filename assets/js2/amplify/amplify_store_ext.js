amplify.store.remove = function ( key ) {
	var value = amplify.store( key );
	amplify.store( key, null );
	return value;
}// JavaScript Document

