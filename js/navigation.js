/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 *
 */
;(function ($) {

	const G = window.Globals

	/**
	 * BUTTONS
	 * */
		//var scrollSpeed = 1200
		// Menu
	const masthead = $('header#masthead')
	const menuwrap = G.$element.menu
	const ham = G.$element.ham

	const hideMobileMenu = function () {
		menuwrap.fadeOut(G.tran.fast)
		masthead.removeClass('mobile-open')

		ham.removeClass('closing')
	}
	const toggleScrollListener = function () {
		$(window).one('scroll', function () {
			hideMobileMenu()
		})
	}

	ham.on('click', function () {
		menuwrap.fadeToggle(G.tran.fast)
		masthead.toggleClass('mobile-open')

		let h = $(this)
		h.toggleClass('closing')
		if (h.hasClass('closing')) {
			toggleScrollListener()
		}
	})

	menuwrap.on('click', function () {
		if ('mobile' === window.getLatestViewport()) {
			hideMobileMenu()
		}
	})

	/**
	 * Overlays
	 */
	const overlay = {
		container: $('#overlay'),
		items: $('.overlay'),
		closer: $('#overlay-closer'),
		unreveal: function () {
			this.container.fadeOut()
		},
		reveal: function (overlay) {
			overlay.show()
			this.container.fadeIn()

			if (window.getLatestViewport() === 'desktop') {
				thisoverlay = this

				$(window).one('scroll', function () {
					thisoverlay.unreveal()
				})
			}
		}
	}

	overlay.closer.on('click', function (e) {
		e.preventDefault()
		overlay.unreveal()
	})

	/**
	 * Search
	 */

	const search = {
		toggle: $('a#search-toggle'),
		overlay: $('#overlay #search-overlay'),
		input: null,
	}

	search.toggle.on('click', function (e) {
		e.preventDefault()
		overlay.reveal(search.overlay)
		search.overlay.find('input.search-field').focus()
	})

	/**
	 * Body classes based on menu
	 */
	const $currentSubmenu = $('.current-menu-ancestor > ul')

	if ($currentSubmenu.length) {
		G.$element.body.addClass('menu-expanded')
	}


})(jQuery)
