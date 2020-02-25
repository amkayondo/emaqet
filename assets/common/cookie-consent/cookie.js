window.addEventListener("load", function() {

    var s = document.createElement( 'script' );
    s.setAttribute( 'src', '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js' );
    document.body.appendChild( s );

    var s = document.createElement( 'link' );
    s.setAttribute( 'href', '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css' );
    s.setAttribute( 'rel', 'stylesheet' );
    s.setAttribute( 'id', 'cookie-consent' );
    document.body.appendChild( s );

    var intval = setInterval(function(){
        if (!window.cookieconsent) {
            return;
        }
        clearInterval(intval);
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "#000"
                },
                "button": {
                    "background": "#f1d600"
                }
            },
            "theme": "edgeless"
        });
    }, 500);

});