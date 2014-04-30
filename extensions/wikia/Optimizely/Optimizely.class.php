<?php
/**
 * Optimizely
 *
 * @author Damian Jóźwiak
 *
 */
class Optimizely {
	static public function onWikiaMobileAssetsPackages( Array &$jsStaticPackages, Array &$jsExtensionPackages, Array &$scssPackages ) {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$jsStaticPackages[] = 'optimizely_blocking_js';
		}

		return true;
	}

	static public function onOasisSkinAssetGroupsBlocking( &$jsAssetGroups ) {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$jsAssetGroups[] = 'optimizely_blocking_js';
		}

		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgDevelEnvironment, $wgOptimizelyUrl, $wgOptimizelyDevUrl;

		$scripts .= '<script src="' . ($wgDevelEnvironment ? $wgOptimizelyDevUrl : $wgOptimizelyUrl) . '" async></script>';

		return true;
	}
}
