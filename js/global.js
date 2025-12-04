/**
 * Global variables and helper functions
 *
 */

;(function ($) {

	/**
	 *  VIEWPORT MAGIC
	 */

	/**
	 * Debounce Resize
	 */
	let timeout
	window.addEventListener('resize', function () {
		// clear the timeout
		clearTimeout(timeout)
		// start timing for event "completion"
		timeout = setTimeout(onResize, 250)
	})

	window.Globals = {
		onPage: {
			home: $('body').hasClass('home')
		},

		size: {
			pMain: 33
		},

		tran: {
			fast: 300,
			medium: 900,
			slow: 1200,
			autoplay: 5000
		},

		bp: {
			narrow: 1080,
			mobile: 768
		},

		$element: {
			body: $('body'),
			menu: $('div#hideable'),
			ham: $('a#hamburger')
		}
	}

	window.getLatestViewport = function () {
		let isMobileCSS = $('body').css('clear') === 'both'
		return (isMobileCSS ? 'mobile' : 'desktop')
	}

	/**
	 * Stuff to do on debounced window resize
	 */
	window.onResize = function () {

		// Menu stuff on resize
		if ('desktop' === window.getLatestViewport()) {
			window.Globals.$element.menu.show()
		} else {
			window.Globals.$element.menu.hide()
			window.Globals.$element.ham.removeClass('closing')
		}
	}
	window.onResize()

	/**
	 * Infinite Scroll
	 */

	/*if ($( "a.next-posts" ).length) {

		$('.infinite').infiniteScroll({
			path: 'a.next-posts',
			hideNav: '.pagination',
			append: 'article',
			history: false,
			scrollThreshold: 1200
		})
	}*/

	/*
	* SMOOTH SCROLL
	* */
	$(document).ready(function () {
		let smoothString = 'a[href^="#"]:not([href="#"])'
		if (true === window.Globals.onPage.home ) {
			smoothString += ', a[href^="/#"]'
		}
		const smoothLink = $(smoothString)

		$(smoothLink).on('click', function (e) {

			e.preventDefault()

			$(document).off("scroll")

			var target = $(this.hash)

			if (undefined !== target) {

				$('html, body').stop().animate({
					'scrollTop': target.offset().top
				}, 600, 'swing', function () {
					$(document).one("scroll", function (e) {
					})
				})
			}
		})
	})

	/*
	* SCROLL MAGIC
	*/
	var controller = new ScrollMagic.Controller()
	// header resize

	offset = (
		'desktop' === window.getLatestViewport() ?
			14 : // p__header
			0
	)

	new ScrollMagic.Scene({
		triggerHook: 0,
		triggerElement: 'body',
		offset: offset,
		duration: 0
	})
	.setClassToggle('#masthead', 'tiny')
	//.addIndicators() // debug
	.addTo(controller)
})(jQuery)