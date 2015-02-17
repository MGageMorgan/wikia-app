/**
 * These are generic functions having to do with loading graphics
 * and ajax responses for LVS
 */
define('lvs.commonajax', [
	'lvs.suggestions',
	'lvs.ellipses',
	'lvs.videocontrols',
	'wikia.window',
	'lvs.tracker'
], function (suggestions, ellipses, controls, window, tracker) {
	'use strict';

	var $body,
		$container;

	function init($elem) {
		$body = $('body');
		$container = $elem;
	}

	// add loading graphic
	function startLoadingGraphic() {
		var scrollTop = $(window).scrollTop();
		$body.addClass('lvs-loading').startThrobbing();
		$body.children('.wikiaThrobber').css('top', scrollTop);
	}

	// remove loading graphic
	function stopLoadingGraphic() {
		$body.removeClass('lvs-loading').stopThrobbing();
	}

	// ajax success callback
	function success(data, trackingLabel) {
		if (data.result === 'error') {
			window.BannerNotifications.show(data.msg, 'error');
			stopLoadingGraphic();
		} else {
			windowBannerNotifications.show(data.msg, 'confirm');
			// update the grid and trigger the reset event for JS garbage collection
			$container.html(data.html).trigger('contentReset');
			suggestions.init($container);
			ellipses.init($container);
			controls.init($container);

			$('.lvs-match-stats').find('.count').text(data.totalVideos || 0);

			stopLoadingGraphic();

			tracker.track({
				action: tracker.actions.SUCCESS,
				label: trackingLabel
			});

			// redirect if user swaps last video on page
			if (data.redirect.length) {
				window.location = data.redirect;
			}
		}
	}

	// ajax failure callback
	function failure() {
		stopLoadingGraphic();
	}

	return {
		init: init,
		startLoadingGraphic: startLoadingGraphic,
		stopLoadingGraphic: stopLoadingGraphic,
		success: success,
		failure: failure
	};
});
