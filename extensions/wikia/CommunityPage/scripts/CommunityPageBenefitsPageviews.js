require([
	'wikia.pageviewsInSession',
	'CommunityPageBenefitsModal'
], function (pageviews, modal) {
	'use strict';

	function init() {
		if (pageviews.getPageviewsCount() >= 4) {
			modal.open();
		}
	}

	// Gets timestamp in format of YYYY-mm-dd HH:mm:ss
	function getTimestamp() {
		return (new Date()).toISOString().substr(0, 19).replace('T', ' ');
	}

	// This cookie is checked in CommunityPageSpecialHooks::onBeforePageDisplay to avoid unnecessary script loading
	function setModalShownCookie() {
		cookies.set('cpBenefitsModalShown', getTimestamp(), {
			domain: mw.config.get('wgCookieDomain'),
			expires: 2592000000, // 30 days
			path: mw.config.get('wgCookiePath')
		});
	}

	function trackModalImpression() {
		tracker.track({
			action: tracker.ACTIONS.OPEN,
			category: 'community-page-benefits-modal',
			label: 'benefits-modal-fired-after-pageviews',
			trackingMethod: 'analytics'
		});
	}

	init();
});
