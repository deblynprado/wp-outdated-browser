// Color Picker
(function( $ ) {
 
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('#font-color').wpColorPicker({
            defaultColor: '#ffffff'
        });

        $('#bkg-color').wpColorPicker({
            defaultColor: '#f25648'
        });
    });
     
})( jQuery );
