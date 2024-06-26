/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

// Timepicker
if(jQuery().timepicker && $(".timepicker").length) {
	$(".timepicker").timepicker({
		icons: {
			up: 'fas fa-chevron-up',
			down: 'fas fa-chevron-down'
		}
	});
}
