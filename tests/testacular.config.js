// Testacular configuration
// Generated on Thu Feb 28 2013 11:29:38 GMT+0100 (CET)

/*
	created by Jakub Olek <jakub.olek@wikia-inc.com>
 */

// base path, that will be used to resolve files and exclude
basePath = '../';

// list of files / patterns to load in the browser
files = [
	JASMINE,
	JASMINE_ADAPTER,
	'resources/wikia/libraries/define.mock.js',
	'tests/lib/jasmine/jasmine.async.js',
	'tests/lib/jasmine/helpers.js',

	'resources/jquery/jquery-1.8.2.js',
	'extensions/wikia/JSMessages/js/JSMessages.js',
	'extensions/wikia/WikiaMobile/js/autocomplete.js',
	'extensions/wikia/WikiaMobile/js/events.js',
	'extensions/wikia/WikiaMobile/js/features.js',
	'extensions/wikia/WikiaMobile/js/lazyload.js',
	'extensions/wikia/WikiaMobile/js/mediagallery.js',
	'extensions/wikia/WikiaMobile/js/media.js',
	'extensions/wikia/WikiaMobile/js/modal.js',
	'extensions/wikia/WikiaMobile/js/pager.js',
	'extensions/wikia/WikiaMobile/js/popover.js',
	'extensions/wikia/WikiaMobile/js/sections.js',
	'extensions/wikia/WikiaMobile/js/ads.js',
	'extensions/wikia/WikiaMobile/js/share.js',
	'extensions/wikia/WikiaMobile/js/tables.js',
	'extensions/wikia/WikiaMobile/js/throbber.js',
	'extensions/wikia/WikiaMobile/js/toast.js',
	'extensions/wikia/WikiaMobile/js/toc.js',
	'extensions/wikia/WikiaMobile/js/topbar.js',
	'extensions/wikia/WikiaMobile/js/features.js',

	'extensions/**/js/spec/*.spec.js'
];



// list of files to exclude
exclude = [
  
];


// test results reporter to use
// possible values: 'dots', 'progress', 'junit'
reporters = ['progress'];


// web server port
port = 9876;


// cli runner port
runnerPort = 9100;


// enable / disable colors in the output (reporters and logs)
colors = true;


// level of logging
// possible values: LOG_DISABLE || LOG_ERROR || LOG_WARN || LOG_INFO || LOG_DEBUG
logLevel = LOG_INFO;


// enable / disable watching file and executing tests whenever any file changes
autoWatch = false;


// Start these browsers, currently available:
// - Chrome
// - ChromeCanary
// - Firefox
// - Opera
// - Safari (only Mac)
// - PhantomJS
// - IE (only Windows)
browsers = ['PhantomJS'];


// If browser does not capture in given timeout [ms], kill it
captureTimeout = 6000;


// Continuous Integration mode
// if true, it capture browsers, run tests and exit
singleRun = true;

coverageReporter = {
	type : 'html',
	dir : 'tests/coverage/'
};

//reportSlowerThan = 100;

preprocessors = {
	'**/js/*.js': 'coverage'
};