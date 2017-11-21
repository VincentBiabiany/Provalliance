var inputs = document.querySelectorAll( '.input-file' );
Array.prototype.forEach.call( inputs, function( input )
{
	var label	 = input.previousElementSibling,
		labelVal = label.innerHTML;
	input.addEventListener( 'change', function( e )
	{

		var fileName = '';
			fileName = e.target.value.split( '\\' ).pop();
		if( fileName ){
            if (fileName.length > 20){
              fileName = jQuery.trim(fileName).substring(0, 20).split(" ").slice(0, -1).join(" ") + "...";
              label.querySelector( 'span' ).innerHTML = fileName;
            }else{
              label.querySelector( 'span' ).innerHTML = fileName;
            }
        }	else{
    			label.innerHTML = labelVal;
        }
	});
});
