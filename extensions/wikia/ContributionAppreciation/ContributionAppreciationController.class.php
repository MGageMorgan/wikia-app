<?php

class ContributionAppreciationController extends WikiaController {

	public function appreciate() {
		global $wgUser;

		if ( $this->request->isValidWriteRequest( $wgUser ) ) {
			//TODO: do something with apprecation
		}
	}

	public static function onDiffHeader( DifferenceEngine $diffPage, $oldRev, Revision $newRev ) {
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
			$diffPage->getOutput()->addHTML( self::getAppreciationLink( $newRev->getId() ) );
		}

		return true;
	}

	public static function onPageHistoryLineEnding( HistoryPager $pager, $row, &$s, $classes ) {
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			$s .= self::getAppreciationLink( $row->rev_id );
		}

		return true;
	}

	public static function onPageHistoryBeforeList() {
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
		}

		return true;
	}

	private static function getAppreciationLink( $revision ) {
		return Html::element( 'button',
			[
				'class' => 'appreciation-button',
				'href' => '#',
				'data-revision' => $revision
			],
			wfMessage( 'appreciation-text' )->escaped() );
	}
}
