amplify.store.getItem = function( key ) {

return amplify.store( key );

};

 

amplify.store.setItem = function( key, value ) {

amplify.store( key, value );

};

 

amplify.store.isEmpty = function() {

for ( var key in amplify.store() ) {

return false;

}

return true;

}

 

amplify.store.length = function() {

var storage = amplify.store(), length = 0, key;

 

for ( key in storage ) {

length += 1;

}

 

return length;

};

 

amplify.store.removeItem = function( key ) {

amplify.store( key, null );

};

 

amplify.store.clear = function() {

var storage = amplify.store(), key;

 

for ( key in storage ) {

amplify.store( key, null );

}

};

 

amplify.request.clearCache = function( resourceId ) {

var prefix = "request-" + resourceId,

length = prefix.length,

type = amplify.request.resources[ resourceId ]

 

$.each( amplify.store(), function( key ) {

if ( key.substring( 0, length ) === prefix ) {

amplify.store.remove( key, null );

}

});

};