// Color Picker
(function( $ ) {
 
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('#font-color').wpColorPicker({
            defaultColor: '#fff'
        });

        $('#bkg-color').wpColorPicker({
            defaultColor: '#f25648'
        });
    });
     
})( jQuery );

//PLAIN JAVASCRIPT
//event listener form DOM ready
// function addLoadEvent(func) {
//     var oldonload = window.onload;
//     if (typeof window.onload != 'function') {
//         window.onload = func;
//     } else {
//         window.onload = function() {
//             oldonload();
//             func();
//         }
//     }
// }
// //call plugin function after DOM ready
// addLoadEvent(
//     outdatedBrowser({
//         bgColor: '#f25648',
//         color: '#ffffff',
//         lowerThan: 'transform'
//     })
// );