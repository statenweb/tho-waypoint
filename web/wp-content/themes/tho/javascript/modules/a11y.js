document.addEventListener('DOMContentLoaded', function () {
	['keydown', 'keyup'].forEach(function (action) {
		document.addEventListener(action, function (event) {
			// Check if the spacebar was pressed

			if ([' ', 'ENTER'].includes(event.key.toUpperCase())) {
				// Check if the focused element has a role of 'button'
				const spaceWasPressed = ' ' === event.key;
				const enterWasPressed = 'Enter' === event.key;
				const activeElement = document.activeElement;
				const isButtonOrLink =
					'button' === activeElement.getAttribute('role') ||
					'A' === activeElement.tagName;

				if (
					activeElement &&
					isButtonOrLink &&
					(spaceWasPressed || enterWasPressed)
				) {
					// Prevent the default action (scrolling)

					event.preventDefault();

					if ('keyup' === action && isButtonOrLink) {
						activeElement.click(); // Uncomment this line if you want to manually trigger the click action on space press
					}
				}
			}
		});
	});
});
