document.addEventListener('DOMContentLoaded', function () {

	const CLOSEALL = 'closeall';
	const TOGGLE = 'toggle';


	// Get the menu style from the wp_localize_script
	const menuStyle = sw?.menu_style ? sw.menu_style : 'click';

	/**
	 * Events to listen to

	 */


	document.addEventListener('keyup', function(event) {

		if (event.key === "Escape" || event.keyCode === 27) { // Check if the key is the Escape key
			closeAllDropdowns();
		}
	});

	document.addEventListener('click', function(event){
		let target = event.target; // Get the clicked element

		// Check if the clicked element or any of its parents have the class 'foo'
		while (target) {
			if (target.classList && target.classList.contains('header-navigation')) {
				return; // Click was inside '.foo' or a child of '.foo', so do nothing
			}
			target = target.parentNode; // Move up in the DOM tree
		}
		closeAllDropdowns();
	})

	// Define the events to listen to
	const eventsToListenTo = [];
	addEventsToListenTo({type: 'keyup', key: [' ']});
	addEventsToListenTo({type: 'keyup', action: CLOSEALL, key: ['escape'], });

	if('click' === menuStyle || !menuStyle) {
		addEventsToListenTo({type: 'click'});
	}
	if('hover' === menuStyle) {
		addEventsToListenTo({type: 'mouse-events'});
	}



	document.querySelector('.menu-toggler').addEventListener('click', function(){
		document.body.classList.toggle('menu-expanded');
	});

	/**
	 * Add events to listen to (click, keyup, etc) note: action defaults to `toggle`
	 * @param eventObject
	 */
	function addEventsToListenTo(eventObject) {

		const defaults = {action: TOGGLE, key: []};
		eventObject = {...defaults, ...eventObject};
		eventsToListenTo.push(eventObject);
	}

	// Get all the dropdown toggles
	const dropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]');

	/**
	 * Toggle the aria-expanded attribute of the dropdown toggle
	 * @returns {void}
	 */
	function toggleElement(only = false) {
		const isOpening = this.getAttribute('aria-expanded') === 'false';
		if (this.classList.contains('dropdown-toggle-l2')) {
			const siblings = this.closest('.dropdown-menu').querySelectorAll('[data-toggle="dropdown"]');
			siblings.forEach(sib => sib.setAttribute('aria-expanded', 'false'));
		} else {

			closeAllDropdowns();
		}

		if(only){
			this.setAttribute('aria-expanded', only === 'open' ? 'true' : false);
			return;
		}

		this.setAttribute('aria-expanded', isOpening ? 'true' : 'false');
	}

	/**
	 * Handle the event on the dropdown toggle
	 * @param eventObject
	 * @param dropdownToggle
	 * @param toggleElement
	 */
	function handleMenuEvent(eventObject, dropdownToggle) {

		const { action, key, type  } = eventObject;
		let listenToEventType = type;
		if(type === 'mouse-events') {


			dropdownToggle.parentElement.addEventListener('mouseenter', function (e) {
				e.preventDefault();
				e.stopPropagation();
				for(let child of this.children){
					if(child.classList.contains('dropdown-toggle') || child.classList.contains('dropdown-toggle-l2')){
						toggleElement.call(child, 'open');
					}
				}

			});

			dropdownToggle.parentElement.addEventListener('mouseleave', function (e) {
				e.stopPropagation();
				e.preventDefault();

				for(let child of this.children){
					if(child.classList.contains('dropdown-toggle') || child.classList.contains('dropdown-toggle-l2')){
						toggleElement.call(child, 'close');
					}
				}

			});

		}
		dropdownToggle.addEventListener(listenToEventType, function (e) {
			e.preventDefault();
			e.stopPropagation();
			let shortCircuit = false;



			if('keyup' === type) {

				shortCircuit = true;
				const upperCaseKeyPressed = e.key.toUpperCase();
				// default to toggle

				const keysToCheck = key.map(item => item.toUpperCase())|| [];
				switch(action) {
					case CLOSEALL:
						if(keysToCheck.includes(upperCaseKeyPressed)) {
							closeAllDropdowns();
						}
						break;
					case TOGGLE:
					default:
						if(keysToCheck.includes(upperCaseKeyPressed)) {
							shortCircuit = false;
						}
				}
			}
			if(shortCircuit){
				return;
			}

			toggleElement.call(this);
		});
	}

	dropdownToggles.forEach(dropdownToggle => {
		eventsToListenTo.forEach(eventObject => {
			handleMenuEvent(eventObject, dropdownToggle);
		});
	});

	function closeAllDropdowns() {
		const dropdownToggles = document.querySelectorAll('.dropdown-toggle, .dropdown-toggle-l2');
		dropdownToggles.forEach(toggle => {
			toggle.setAttribute('aria-expanded', 'false');
		});
	}
});
