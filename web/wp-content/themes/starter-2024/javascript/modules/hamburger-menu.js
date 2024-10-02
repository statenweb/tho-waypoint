document.addEventListener('DOMContentLoaded', function () {
	// Function to handle visibility changes
	function handleVisibilityChange(entries, observer) {
		entries.forEach((entry) => {
			// Extract the data-parent attribute
			const dataParent = entry.target.getAttribute('data-parent');

			if (entry.isIntersecting) {
				const parentElement = document.getElementById(dataParent);
				if (parentElement) {
					parentElement.setAttribute('aria-expanded', 'true');
				}
			} else {
				const parentElement = document.getElementById(dataParent);
				if (parentElement) {
					parentElement.setAttribute('aria-expanded', 'false');
				}
			}
		});
	}

	// Set up the IntersectionObserver
	const observer = new IntersectionObserver(handleVisibilityChange, {
		root: null, // observing in relation to the viewport
		threshold: 0.1, // percentage of target's visibility the observer's callback should execute
	});

	// Select all elements with the data-parent attribute
	const elements = document.querySelectorAll('[data-parent]');

	// Observe each element
	elements.forEach((element) => {
		observer.observe(element);
	});
});

jQuery(document).ready(function ($) {


	$('a.dropdown-toggle[href="#"]').on('click', function (e) {

		if ($(window).width() > 1070) {
			return;
		}


		e.preventDefault();
		e.stopPropagation();
		$(this).siblings('.dropdown-icon').trigger('click');
	});

	$('.menu-toggler').on('click', function () {
		const parentContainerId = $(this).attr('data-menu-id');
		const $parentContainer = $(`#${parentContainerId}`);
		$('body').toggleClass('menu-expanded');
		$(this).attr(
			'aria-expanded',
			$(this).attr('aria-expanded') === 'true' ? 'false' : 'true'
		);

		$parentContainer.toggleClass('mobile-only:!translate-y-0');
	});
	const resetActiveMenus = () => {
		// timeout pushes to bottom of queue
		setTimeout(function () {
			$('.dropdown-menu').each(function () {
				let active = false;
				if ($(this).hasClass('flex')) {
					active = true;
				}
				const $elementToActUpon = $(this).siblings(
					'.dropdown-toggle,.dropdown-toggle-l2'
				);

				// $elementToActUpon.attr(
				// 	'aria-expanded',
				// 	active ? 'true' : 'false'
				// );
				if (!!active) {
					$elementToActUpon.addClass('active');
				} else {
					$elementToActUpon.removeClass('active');
				}
			});
		}, 100);
	};

	$('#primary_menu > .dropdown').on('click', '.dropdown-icon', function (e) {
		$(this)
			.closest('.menu-item')
			.find('> .dropdown-menu')
			.toggleClass('hidden');
	});

	$('.menu-item-has-children').on('mouseleave', function (e) {
		e.preventDefault();
		e.stopPropagation();
		$('.dropdown-menu.flex')
			.addClass('hidden')
			.removeClass('flex')
			.siblings('a')
			.toggleClass('active');
	});

	$('.menu-item-has-children').on('mouseenter', function (e) {
		if ($('body').hasClass('menu-expanded')) {
			return;
		}
		if (
			!$(e.target).hasClass('dropdown-toggle') &&
			!$(e.target).hasClass('dropdown-toggle-l2')
		) {
			return true;
		}

		e.preventDefault();
		e.stopPropagation();
		const thisClasses = '.' + $(this).attr('class').split(' ').join('.');

		if ($(e.target).hasClass('dropdown-toggle')) {
			$('.dropdown-menu.flex.l1')
				.not(thisClasses + ' .dropdown-menu.flex')
				.toggleClass('hidden')
				.toggleClass('flex');
			$(this)
				.find('.dropdown-menu.l1')
				.toggleClass('hidden')
				.toggleClass('flex')
				.siblings('a')
				.toggleClass('active');
		} else {
			$('.dropdown-toggle-l2')
				.siblings('.dropdown-menu')
				.toggleClass('hidden')
				.toggleClass('flex');
			// $( this ).find( '.dropdown-menu' ).toggleClass( 'hidden' ).toggleClass( 'flex' ).siblings( 'a' ).toggleClass( 'active' );
		}

		resetActiveMenus();
	});
	$(document).on('click', function () {
		$('.dropdown-menu.flex').toggleClass('hidden').toggleClass('flex');
		resetActiveMenus();
	});

	$(document).keyup(function (e) {
		if (e.key === 'Escape') {
			// escape key maps to keycode `27`

			$('.dropdown-menu.flex')
				.toggleClass('flex')
				.toggleClass('hidden')
				.siblings('a')
				.toggleClass('active');
			resetActiveMenus();
		}
	});

	$('.stop-propagation').on('click', function (e) {
		e.stopPropagation();
	});
});
