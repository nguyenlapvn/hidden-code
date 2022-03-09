window.addEventListener( 'DOMContentLoaded', () => {
    const  els = document.querySelectorAll( '.hidden-code' );
    const elsArrEls = Array.prototype.slice.call(els)
    // console.log( elsArrEls)
    if ( elsArrEls.length ) {
        elsArrEls.map( ( el ) => {
			return initBlock( el );
		} );
	}
});

const initBlock = ( el ) => {
	const time = el.getAttribute('data-count-time') ?? 0;
	const code =  el.getAttribute('data-code') ?? null;
	const buttonEl = document.querySelector( '.hidden-code__button' );

	if ( time && code && buttonEl ) {
		initializeCountdown( time, code, buttonEl );
		// clearBlockSettings( el );
	}
};

const initializeCountdown = ( time, code, el ) => {
    console.log( el)
    el.onclick = function() {
        var refreshTime  = setInterval(() => {
            if(time > 0){
                el.innerText = time
            } else {
                el.innerText = code
                clearInterval(refreshTime)
            }

            time--;
        }, 1000);
    }
};

const clearBlockSettings = ( el ) => {
	el.removeAttribute( 'data-count-time' );
	el.removeAttribute( 'data-code' );
    // el.classList.add( 'is-initialized' );
	return el;
};