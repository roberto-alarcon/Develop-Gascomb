/* 
 * Authors: Nedim Arabacı (http://ned.im)
*/

var notes = [];

notes['alert'] = 'Best check yo self, you\'re not looking too good.';
notes['error'] = 'Change a few things up and try submitting again.';
notes['success'] = 'You successfully read this important alert message.';
notes['information'] = 'This alert needs your attention, but it\'s not super important.';
notes['warning'] = '<strong>Warning!</strong> <br /> Best check yo self, you\'re not looking too good.';
notes['confirm'] = 'Do you want to continue?';

$(document).ready(function() {		
	
	$('div.runner').click(function() {

		var self = $(this);

		noty({
			text: notes[self.data('type')],
			type: self.data('type'),
			dismissQueue: true,
			layout: self.data('layout'),
			buttons: (self.data('type') != 'confirm') ? false : [
		    {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {
		    			
		    			// this = button element
		    			// $noty = $noty element
		    	
		    			$noty.close();
		    			noty({force: true, text: 'You clicked "Ok" button', type: 'success', layout: self.data('layout')});
		    	}
		    },
		    {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
		    		$noty.close();
			    	noty({force: true, text: 'You clicked "Cancel" button', type: 'error', layout: self.data('layout')});
		    	}
		    }
		    ]
		});
		return false;
	});
	
	
	
});