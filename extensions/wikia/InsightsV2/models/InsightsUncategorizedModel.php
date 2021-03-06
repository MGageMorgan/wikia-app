<?php

/**
 * Class InsightsUncategorizedModel
 * A class specific to a subpage with a list of pages
 * without categories.
 */
class InsightsUncategorizedModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'uncategorizedpages';

	private static $insightConfig = [
		InsightsConfig::DISPLAYFIXITMSG => true,
		InsightsConfig::PAGEVIEWS => true
	];

	public function __construct() {
		$this->config = new InsightsConfig( self::INSIGHT_TYPE, self::$insightConfig );
	}

	public function getDataProvider() {
		return new UncategorizedPagesPage();
	}

	/**
	 * Checks if a given article has been fixed by a user
	 * inside a productivity loop.
	 * @param Title $title
	 * @return bool
	 */
	public function isItemFixed( Title $title ) {
		$categories = $title->getParentCategories( true );
		if ( !empty( $categories ) ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $title );
		}
		return false;
	}
}
