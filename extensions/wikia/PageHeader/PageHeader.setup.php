<?php
$dir = dirname( __FILE__ ) . '/';

// Controllers
$wgAutoloadClasses[ 'Wikia\PageHeader\PageHeaderController' ] = $dir . 'PageHeaderController.class.php';

// Classes
$wgAutoloadClasses[ 'Wikia\PageHeader\Categories' ] = $dir . 'Categories.class.php';
$wgAutoloadClasses[ 'Wikia\PageHeader\Counter' ] = $dir . 'Counter.class.php';
$wgAutoloadClasses[ 'Wikia\PageHeader\Subtitle' ] = $dir . 'Subtitle.class.php';
$wgAutoloadClasses[ 'Wikia\PageHeader\ActionButton' ] = $dir . 'ActionButton.class.php';
$wgAutoloadClasses[ 'Wikia\PageHeader\PageTitle' ] = $dir . 'PageTitle.class.php';
$wgAutoloadClasses[ 'Wikia\PageHeader\Language' ] = $dir . 'Language.class.php';

// Hooks
$wgAutoloadClasses[ 'Wikia\PageHeader\Hooks' ] = $dir . 'Hooks.class.php';
$wgHooks['BeforePageDisplay'][] = 'Wikia\PageHeader\Hooks::onBeforePageDisplay';
$wgHooks['EditPage::showEditForm:initial'][] = 'Wikia\PageHeader\Hooks::onEditPageRender';

// i18n
$wgExtensionMessagesFiles[ 'PageHeader' ] = $dir . 'PageHeader.i18n.php';
