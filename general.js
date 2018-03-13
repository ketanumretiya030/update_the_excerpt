/**********js for check third party url*************/
jQuery(function() {
				
function ket_thirdurl(event) {
	
    var choice = true; //window.confirm( 'Third party url open in new window' +ket_url );
	//if(choice == true)
	{
		var links = jQuery(this).attr('href');
	window.open(links);
		         choice = false;
	}
    return choice;
}

var thirdparty = 'a[href*="//"]:not([href*="'+ket_url+'"])';
jQuery(document).on( 'click', thirdparty, ket_thirdurl )
});
