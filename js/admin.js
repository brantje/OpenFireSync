/**
 * ownCloud - openfiresync
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Sander Brand <brantje@gmail.com>
 * @copyright Sander Brand 2014
 */


$(document).ready(function () {
	$(document).on('click','#openfire_apply',function(){
	var data = {
		'openfire_secret_key': $('#openfire_secret_key').val(),
		'openfire_server_url': $('#openfire_server_url').val()
	}
	$.post(
			OC.filePath('openfiresync','', 'admin.php'), 
				data,
				function(response){
					$('#ofr').html('<span class="ofrm msg success">Saved</span>');
					setTimeout(function(){$('.ofrm').fadeOut()},1500)
				}
		);
	})
});

