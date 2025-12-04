/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 *
 */
;( function( $ ) {

	const G = window.Globals
	let mode = window.getLatestViewport()

	/**
	 *
	 * Initializes a slider
	 *
	 * @param $slider jQuery element
	 * @param show number of slides to show
	 * @param fade number of slides to show
	 */

	function initializeSlider( $slider, show = 1, fade = false, cal = false, autoplay = false) {


		const showNarrow = (1 === show ? 1 : show-1)

		// Only allow fade
		const fade_n_autoplay = (1 === show && fade)

		const offset_limit = 600
		const random_offset = Math.floor(Math.random() * 2 * offset_limit) - offset_limit


		const autoplaySpeed = (autoplay ? autoplay : G.tran.autoplay) + random_offset

		const settings = {
			// slow speed for fade, fast for slide
			infinite : true,
			speed: (fade ? G.tran.slow : G.tran.fast),
			slidesToShow: show,
			autoplay: fade_n_autoplay,
			autoplaySpeed: autoplaySpeed,
			dots: !fade,
			arrows: false,
			fade: fade_n_autoplay,
			adaptiveHeight: true,
			responsive: [
				{
					breakpoint: G.bp.narrow, //todo global var narrow screen
					settings: {
						slidesToShow: showNarrow
					}
				},
				{
					breakpoint: G.bp.mobile, //todo global var mobile
					settings: {
						slidesToShow: 1,
						centerMode: true,
						centerPadding: '0',
					}
				}
			]

		}

		// Get highest visible slide
		function highestHeight($slider, index) {

			if ($slider.children('.slides').hasClass('variable-height')) {

				if ('desktop' === mode) {
					let H = []
					let p = G.size.pMain * 2 // double main site padding

					getLatestViewport()

					let upcoming = [index, index + 1, index + 2]
					$.each(upcoming, function () {
						H.push($slider.find(`[data-slick-index='${this}'] a`).outerHeight() + p)
					})

					$slider.find('.slick-list').height(Math.max(...H))
					$slider.find('.slick-track').height(Math.max(...H))
				}
			}
		}

		// Initialize
		$slider.children('.slides').not('.slick-initialized')
		.slick(settings)
		.on('beforeChange', function(event, slick, currentSlide, nextSlide){
			if (!cal) highestHeight($(this), nextSlide)
		})
		if (!cal) highestHeight( $slider , 0 )
	}


	function initializeCalSlider( $calendar, show = 1) {

		const settings = {
			infinite : false,
			slidesToShow: show,
			slidesToScroll: show,
			slide: '.slide',
			dots: false,
			arrows: true,
			centerMode: true,
			centerPadding: 0,
			responsive: [
				{
					breakpoint: G.bp.narrow, //
					settings: {
						arrows: false,
					}
				},
				{
					breakpoint: G.bp.mobile, //todo global var mobile
					settings: {
						slidesToShow: 1,
						centerMode: true,
						arrows: true,
					}
				}
			]

		}

		// Initialize
		$calendar.children('.slides').not('.slick-initialized').slick(settings)

		$('.go-first-slide').on('click', function (event) {
			event.preventDefault()
			$calendar.children('.slides').slick('slickGoTo', 0)
		})
	}


	$(document).ready(function () {

		$('.slider').each(function () {
			const $slider = $(this)
			// fade or slide
			let fade = $slider.hasClass('fade')
			// single or carousel
			let carousel = $slider[0].hasAttribute('data-show')
			let show = (carousel ? $slider[0].getAttribute('data-show') : 1 )
			let autoplay = $slider[0].getAttribute('data-autoplay')

			// init with options
			initializeSlider( $slider , show, fade, autoplay)
		})

		$('.calendar-slider').each(function () {
			const $slider = $(this)
			let show = ($slider[0].getAttribute('data-show') ? $slider[0].getAttribute('data-show') : 1 )

			initializeCalSlider( $slider , show)
		})
		$('.cover-slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true, 
			fade: true,
			asNavFor: '.cover-nav',
			prevArrow: '<button type="button" class="slick-prev">Предыдущий</button>',
			nextArrow: '<button type="button" class="slick-next">Следующий</button>'
		  });
		$('.cover-nav').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			asNavFor: '.cover-slider',
			infinite: false,
			dots: true,
			appendDots: $('.appenddots'),
			centerMode: false,
			arrows: false,
			focusOnSelect: true
		});
		$('.language-item').on('click', function() {
			var language = $(this).data('language');
			var slideIndex = $('.cover-slide[data-language="' + language + '"]').index();
			
			// Переключаем слайдер
			$('.cover-slider').slick('slickGoTo', slideIndex);
			
			// Удаляем класс active-lang у всех элементов
			$('.language-item').removeClass('active-lang');
			
			// Добавляем класс active-lang к кликнутому элементу
			$(this).addClass('active-lang');
		});
	
		// Устанавливаем активный язык при загрузке страницы
		var initialLanguage = $('.cover-slider').slick('slickCurrentSlide');
		var initialLang = $('.cover-slide').eq(initialLanguage).data('language');
		$('.language-item[data-language="' + initialLang + '"]').addClass('active-lang');
	
		// Обновляем активный язык при изменении слайда
		$('.cover-slider').on('afterChange', function(event, slick, currentSlide) {
			var currentLang = $('.cover-slide').eq(currentSlide).data('language');
			$('.language-item').removeClass('active-lang');
			$('.language-item[data-language="' + currentLang + '"]').addClass('active-lang');
		});
	})

} )( jQuery )
