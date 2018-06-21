$(document).ready(function () {

	function ConfirmDelete() {
		return confirm('Do you want to delete the current school?');
	}
	
	$('input').bind('focus', false);

	$('#mask-mobile-number')
		.keyup(function (e) {
			var key = e.which || e.charCode || e.keyCode || 0;
			$phone = $(this);

			if ($phone.val().indexOf('(') > -1) {

				if ($phone.val().length === 1 && (key === 8 || key === 46)) {
					$phone.val('(');
					return false;
				}
			} else {
				//alert("( not found inside your_string");
				$phone.val('(');
			}
			// Don't let them remove the starting '('
			if ($phone.val().length === 1 && (key === 8 || key === 46)) {
				$phone.val('(');
				return false;
			}
			// Reset if they highlight and type over first char.
			else if ($phone.val().charAt(0) !== '(') {
				$phone.val('(' + String.fromCharCode(e.keyCode) + '');
			}

			// Auto-format- do not expose the mask as the user begins to type
			if (key !== 8 && key !== 9) {
				if ($phone.val().length === 4) {
					$phone.val($phone.val() + ')');
				}
				// if ($phone.val().length === 5) {
				// 	$phone.val($phone.val() + ' ');
				// }			
				if ($phone.val().length === 8) {
					$phone.val($phone.val() + '-');
				}
			}

			// Allow numeric (and tab, backspace, delete) keys only
			return (key == 8 ||
				key == 9 ||
				key == 46 ||
				(key >= 48 && key <= 57) ||
				(key >= 96 && key <= 105));
		})

		.bind('focus click', function () {
			$phone = $(this);

			if ($phone.val().length === 0) {
				$phone.val('(');
			}
			else {
				var val = $phone.val();
				$phone.val('').val(val); // Ensure cursor remains at the end
			}
		})

		.blur(function () {
			$phone = $(this);

			if ($phone.val() === '(') {
				$phone.val('');
			}
		});

	$("#mask-mobile-number").mask("(999)999-9999");
	// $('#mask-fax-number')
	// 	.keydown(function (e) {
	// 		var key = e.which || e.charCode || e.keyCode || 0;
	// 		$phone = $(this);

	// 		// Don't let them remove the starting '('
	// 		if ($phone.val().length === 1 && (key === 8 || key === 46)) {
	// 			$phone.val('(');
	// 			return false;
	// 		}
	// 		// Reset if they highlight and type over first char.
	// 		else if ($phone.val().charAt(0) !== '(') {
	// 			$phone.val('(' + String.fromCharCode(e.keyCode) + '');
	// 		}

	// 		// Auto-format- do not expose the mask as the user begins to type
	// 		if (key !== 8 && key !== 9) {
	// 			if ($phone.val().length === 4) {
	// 				$phone.val($phone.val() + ')');
	// 			}
	// 			// if ($phone.val().length === 5) {
	// 			// 	$phone.val($phone.val() + ' ');
	// 			// }			
	// 			if ($phone.val().length === 8) {
	// 				$phone.val($phone.val() + '-');
	// 			}
	// 		}

	// 		// Allow numeric (and tab, backspace, delete) keys only
	// 		return (key == 8 ||
	// 			key == 9 ||
	// 			key == 46 ||
	// 			(key >= 48 && key <= 57) ||
	// 			(key >= 96 && key <= 105));
	// 	})

	// 	.bind('focus click', function () {
	// 		$phone = $(this);

	// 		if ($phone.val().length === 0) {
	// 			$phone.val('(');
	// 		}
	// 		else {
	// 			var val = $phone.val();
	// 			$phone.val('').val(val); // Ensure cursor remains at the end
	// 		}
	// 	})

	// 	.blur(function () {
	// 		$phone = $(this);

	// 		if ($phone.val() === '(') {
	// 			$phone.val('');
	// 		}
	// 	});

});
