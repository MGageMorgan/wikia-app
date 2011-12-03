<?php

/**
 * Handles the display of ads
 */

class AdDisplay {

	//wrapper function for specific hooks (method signature appropriate for certain hook(s)
	//use this one
	public static function OutputAdvertisementOutputHook( &$out, &$text ){
		global $wgUser, $wgRequest, $wgShowAds, $wgTitle, $wgMaximizeArticleAreaArticleIds;

		if( empty( $wgShowAds ) 
		|| (is_array($wgMaximizeArticleAreaArticleIds) && in_array($wgTitle->getArticleId(), $wgMaximizeArticleAreaArticleIds)) ) {
			return true;
		}

		if ( empty($_GET['showads']) && is_object($wgUser) && $wgUser->isLoggedIn() && !$wgUser->getOption('showAds') ) {
			return true;
		}

		$action = $wgRequest->getVal('action', 'view');
		if(!$out->isArticle() || $wgRequest->getVal('diff') || $action!='view') return true;
		if(!self::ArticleCanShowAd()) return true;
		wfLoadExtensionMessages( 'SponsorPage' );

		$text.= self::OutputAdvertisement();
		return true;
	}

	//for testing
	public static function PurgeArticle(){
		global $wgArticle;
		$page = $wgArticle->getTitle()->getText();
		$wgArticle->doPurge();
		return true;
	}

	//Note that some hooks may or may not render wikitext, so plan accordingly
	public static function OutputAdvertisement() {
		global $wgParser;
		global $wgTitle, $wgSponsorAdsLimit, $wgUser;
		
		$adtext = "";
		$skin = isset($wgUser->mSkin) ? get_class($wgUser->mSkin) : false;
		
		if ( ( !empty( $skin ) ? ( !in_array( $skin, array( 'SkinWikiaphone', 'SkinWikiaApp' ) ) ) : true)) {
			$ads = Advertisement::GetAdsForCurrentPage();
			$adtext = '<div class="sponsorwrapper" style="display: none;">';
			$adtext .= wfMsg('sponsor-header');
			$adtext .= '<div class="sponsormsg">';
			$adtext .= '<ul>';
			if(is_array($ads)){
				foreach($ads as $ad){
					$adtext .= $ad->OutPutWikiText();
				}
			}
			$adtext .= '</ul>';
	
	
	
			$adtext .= '</div>';
			$adtext .= '</div>';
		}
		return $adtext;
	}

	/**
	 * Shows the sponsorship message
	 *
	 * @return string
	 * @public
	 */
	public static function ShowSponsorMessage(){
		global $wgTitle, $wgParser;
		$page = $wgTitle->getText();
		$specPage = Title::newFromText("Special:Sponsor");
		$specUrl = $specPage->getLocalURL("page_name=".$page);
		$fullUrl = $specPage->getFullUrl(array("page_name"=>$page));
		$text = wfMsg( 'sponsor-msg', $fullUrl );
		return $text;
	}

	/**
	 * See if we're on a page that can have ads (main namespace only, but not main_page)
	 * assumes using MediaWiki:Mainpage for name of main page
	 *
	 * @return bool
	 * @public
	 */
	public static function ArticleCanShowAd(){
		global $wgTitle;
		if(!isset($wgTitle)) return false;
		$page = $wgTitle->getPrefixedText();
		$mainpage = wfMsgForContent('Mainpage');
		//Only show ads in main namespace, but not on the main page
		if($mainpage == $page || $wgTitle->getNamespace() != NS_MAIN ) return false;
		return true;
	}
}
