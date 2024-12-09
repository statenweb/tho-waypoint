document.addEventListener('DOMContentLoaded', function () {
	const CLOSEALL = 'closeall';
	const TOGGLE = 'toggle';

	// Get the menu style from the wp_localize_script
	const menuStyle = sw?.menu_style ? sw.menu_style : 'click';

	const transformUpperCaseCode = (event) => event?.code?.toUpperCase() || '';

	function closeAllDropdowns() {
		const dropdownToggles = document.querySelectorAll(
			'.dropdown-toggle, .dropdown-toggle-l2'
		);
		dropdownToggles.forEach((toggle) => {
			toggle.setAttribute('aria-expanded', 'false');
		});
	}

	/**
	 * Events to listen to for collapsing navigation
	 */

	document.addEventListener('keyup', function (event) {
		const upperCaseCodePressed = transformUpperCaseCode(event);
		if ('ESCAPE' === upperCaseCodePressed || 27 === event.keyCode) {
			// Check if the code is the Escape code
			closeAllDropdowns();
		}
	});

	document.addEventListener('click', function (event) {
		let target = event.target; // Get the clicked element

		// Check if the clicked element or any of its parents have the class 'foo'
		while (target) {
			if (
				target.classList &&
				target.classList.contains('header-navigation')
			) {
				return; // Click was inside '.foo' or a child of '.foo', so do nothing
			}
			target = target.parentNode; // Move up in the DOM tree
		}
		closeAllDropdowns();
	});

	// Define the events to listen to
	const eventsToListenTo = [];
	addEventsToListenTo({ type: 'keyup', code: ['space', 'enter'] });
	addEventsToListenTo({
		type: 'keydown-space-prevent-default',
		code: ['space', 'enter'],
	});
	addEventsToListenTo({ type: 'keyup', action: CLOSEALL, code: ['escape'] });
	if ('click' === menuStyle || !menuStyle) {
		addEventsToListenTo({ type: 'click' });
	}
	if ('hover' === menuStyle) {
		addEventsToListenTo({ type: 'mouse-events' });
	}
	document
		.querySelector('.menu-toggler')
		.addEventListener('click', function () {
			document.body.classList.toggle('menu-expanded');
		});

	/**
	 * Add events to listen to (click, keyup, etc) note: action defaults to `toggle`
	 * @param eventObject
	 */
	function addEventsToListenTo(eventObject) {
		const defaults = { action: TOGGLE, code: [] };
		eventObject = { ...defaults, ...eventObject };
		eventObject.code = eventObject.code.map((item) => item.toUpperCase());
		eventsToListenTo.push(eventObject);
	}

	// Get all the dropdown toggles
	const dropdownToggles = document.querySelectorAll('.nav-link');

	/**
	 * Toggle the aria-expanded attribute of the dropdown toggle
	 * @returns {void}
	 */
	function toggleElement(only = false) {
		const isOpening = 'false' === this.getAttribute('aria-expanded');
		if (this.classList.contains('dropdown-toggle-l2')) {
			const siblings = this.closest('.dropdown-menu').querySelectorAll(
				'[data-toggle="dropdown"]'
			);
			siblings.forEach((sib) =>
				sib.setAttribute('aria-expanded', 'false')
			);
		} else {
			closeAllDropdowns();
		}

		if (only) {
			this.setAttribute(
				'aria-expanded',
				'open' === only ? 'true' : false
			);
			return;
		}

		this.setAttribute('aria-expanded', isOpening ? 'true' : 'false');
	}

	/**
	 * Handle the event on the dropdown toggle
	 * @param eventObject
	 * @param dropdownToggle
	 */
	function handleMenuEvent(eventObject, dropdownToggle) {
		const { action, code, type } = eventObject;
		let listenToEventType = type;
		if ('keydown-space-prevent-default' === type) {
			Array.from(document.querySelectorAll('.nav-link')).forEach(
				(menu) => {
					menu.addEventListener('keydown', (event) => {
						const upperCaseCodePressed =
							transformUpperCaseCode(event);
						if (code.includes(upperCaseCodePressed)) {
							event.preventDefault();
						}
					});
				}
			);
			return;
		}

		if ('mouse-events' === type) {
			dropdownToggle.parentElement.addEventListener(
				'mouseenter',
				function (event) {
					event.preventDefault();
					event.stopPropagation();
					for (let child of this.children) {
						if (
							child.classList.contains('dropdown-toggle') ||
							child.classList.contains('dropdown-toggle-l2')
						) {
							toggleElement.call(child, 'open');
						}
					}
				}
			);

			dropdownToggle.parentElement.addEventListener(
				'mouseleave',
				function (event) {
					event.stopPropagation();
					event.preventDefault();

					for (let child of this.children) {
						if (
							child.classList.contains('dropdown-toggle') ||
							child.classList.contains('dropdown-toggle-l2')
						) {
							toggleElement.call(child, 'close');
						}
					}
				}
			);
		}
		dropdownToggle.addEventListener(listenToEventType, function (event) {
			event.stopPropagation();
			const upperCaseCodePressed = transformUpperCaseCode(event);
			const isDropdown = this.hasAttribute('aria-expanded');
			if (isDropdown && 'click' === listenToEventType) {
				event.preventDefault();
			}

			let shortCircuit = false;
			if ('keyup' === type) {
				shortCircuit = true;

				// default to toggle

				const keysToCheck =
					code.map((item) => item.toUpperCase()) || [];
				switch (action) {
					case CLOSEALL:
						if (keysToCheck.includes(upperCaseCodePressed)) {
							closeAllDropdowns();
						}
						break;
					case TOGGLE:
					default:
						if (keysToCheck.includes(upperCaseCodePressed)) {
							shortCircuit = false;
						}
				}
			}
			if (shortCircuit) {
				return;
			}
			if (isDropdown) {
				toggleElement.call(this);
				return;
			}
			this.click();
		});
	}

	dropdownToggles.forEach((dropdownToggle) => {
		eventsToListenTo.forEach((eventObject) => {
			handleMenuEvent(eventObject, dropdownToggle);
		});
	});

	document.querySelectorAll('.dropdown-menu').forEach((menu) => {
		const firstChild = menu.children[0];
		const lastChild = menu.children[menu.children.length - 1];
		if (firstChild) {
			firstChild.addEventListener('keydown', function (event) {
				const upperCaseCodePressed = transformUpperCaseCode(event);
				if ('TAB' === upperCaseCodePressed && event.shiftKey) {
					event.stopPropagation();

					const dropdownMenuAncestor =
						firstChild.closest('.dropdown-menu');
					if (dropdownMenuAncestor) {
						const parent = dropdownMenuAncestor.parentNode;
						const siblings = parent.children;

						for (let i = 0; i < siblings.length; i++) {
							const sibling = siblings[i];
							if (
								sibling !== dropdownMenuAncestor &&
								sibling.hasAttribute('aria-expanded')
							) {
								sibling.setAttribute('aria-expanded', 'false');
								// 'sibling' is the element you’re looking for
								break;
							}
						}
					}
					// closeMenu(this);  // Directly use 'this' since it is bound to the element in the event listener
				}
			});
		}

		if (lastChild) {
			lastChild.addEventListener('keydown', function (event) {
				const upperCaseCodePressed = transformUpperCaseCode(event);
				if ('TAB' === upperCaseCodePressed && !event.shiftKey) {
					// Ensure this handles non-shift + TAB
					let close = true;
					for (let i = 0; i < lastChild.children.length; i++) {
						if (
							'true' ===
							lastChild.children[i].getAttribute('aria-expanded')
						) {
							close = false;
						}
					}
					if (close) {
						const dropdownMenuAncestor =
							lastChild.closest('.dropdown-menu');
						if (dropdownMenuAncestor) {
							const parent = dropdownMenuAncestor.parentNode;
							const siblings = parent.children;

							for (let i = 0; i < siblings.length; i++) {
								const sibling = siblings[i];
								if (
									sibling !== dropdownMenuAncestor &&
									sibling.hasAttribute('aria-expanded')
								) {
									sibling.setAttribute(
										'aria-expanded',
										'false'
									);
									// 'sibling' is the element you’re looking for
									break;
								}
							}
						}
					}
				}
			});
		}
	});
});
