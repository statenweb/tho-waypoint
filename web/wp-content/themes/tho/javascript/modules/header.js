let lastScrollTop = 0;
let isScrolling;

// Debounce function to limit the rate at which a function is executed
function debounce(func, delay) {
	clearTimeout(isScrolling);
	isScrolling = setTimeout(func, delay);
}

window.addEventListener('scroll', function () {
	debounce(function () {
		const scrollTop =
			window.pageYOffset || document.documentElement.scrollTop;
		const masthead = document.getElementById('masthead');

		// Adjusting the threshold to a slightly higher value to ensure smoother behavior
		if (scrollTop > lastScrollTop && 10 < scrollTop) {
			// Scrolling down
			masthead.classList.remove('scrolling-up', 'at-top');
			masthead.classList.add('scrolled-down');
		} else if (scrollTop < lastScrollTop && 10 < scrollTop) {
			// Scrolling up
			masthead.classList.remove('scrolled-down');
			masthead.classList.add('scrolling-up');
		} else {
			masthead.classList.remove('scrolled-down', 'scrolling-up');
			masthead.classList.add('at-top');
		}
		lastScrollTop = scrollTop;
	}, 100);
});
