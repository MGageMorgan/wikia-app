<?php

/**
 * Lazy loader for Special:Sitemap
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia.com
 * @copyright © 2010, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 *
 * @example lighttpd configuration:
 * url.rewrite += ( "^/(sitemap.+\.xml[.gz]*)$" => "/index.php?title=Special:Sitemap/$1" )
 *
 * @example apache configuration
 * RewriteRule ^/(sitemap.+\.xml[.gz]*)$ /index.php?title=Special:Sitemap/$1 [L,QSA]
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

/**
 * Extension credits that will show up on Special:Version
 */
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Sitemap',
	'version' => '1.1',
	'author' => 'Krzysztof Krzyżaniak',
	'description' => 'Generate Sitemaps for the wiki on the fly',
	'description-msg' => 'sitemap-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SitemapXml'
);

/**
 * Set up the new special page
 */
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Sitemap'] = $dir . 'Sitemap.i18n.php';
$wgExtensionMessagesFiles['SitemapAlias'] = $dir . 'Sitemap.alias.php';
$wgAutoloadClasses['SitemapPage'] = $dir . 'SpecialSitemap_body.php';
$wgAutoloadClasses['SitemapHooks'] =  __DIR__ . '/SitemapHooks.class.php';
$wgSpecialPages['Sitemap'] = 'SitemapPage';
$wgSpecialPageGroups['Sitemap'] = 'wikia';

$wgAutoloadClasses['SitemapXmlModel'] = __DIR__ . '/SitemapXmlModel.class.php';
$wgAutoloadClasses['SitemapXmlController'] = __DIR__ . '/SitemapXmlController.class.php';
$wgAutoloadClasses['ApiSitemapXml'] = __DIR__ . '/ApiSitemapXml.php';

$wgAPIModules["sitemap"] = "ApiSitemapXml";

$wgHooks['BeforeTitleRedirect'][] = 'SitemapHooks::onBeforeTitleRedirect';
$wgHooks['TestCanonicalRedirect'][] = 'SitemapHooks::onTestCanonicalRedirect';
