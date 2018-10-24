<?php
/*
 * Special page included on domain root when language wikis exist without the English wiki.
 */
$wgAutoloadClasses['LanguageWikisIndexController'] = __DIR__ . '/LanguageWikisIndexController.class.php';
$wgSpecialPages['LanguageWikisIndex'] = 'LanguageWikisIndexController';

$wgExtensionFunctions[] = function () {
	global $wgTitle, $wgOut, $wgRequest;

	$indexPage = '/language-wikis';

	switch( $wgRequest->getRequestURL() ) {
		case '/':
			$wgRequest->response()->header( 'Location: ' . $indexPage , 301 );
			break;
		case $indexPage:
			$wgOut->disallowUserJs();

			$wgTitle = SpecialPage::getTitleFor( 'LanguageWikisIndex' );

			$context = $wgOut->getContext();

			$context->setTitle( $wgTitle );
			$context->setSkin( Skin::newFromKey( 'oasis' ) );

			SpecialPageFactory::executePath( $wgTitle, $context );
			$wgOut->output();
		default:
			// TODO: display something here?
			http_response_code( 404 );
	}

	exit( 0 );
};
