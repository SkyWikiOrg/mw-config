<?php
# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'Vector' );


wfLoadExtension( 'CentralAuth' );
$wgCentralAuthDatabase = 'centralauth';
$wgCreateWikiCacheDirectory = 'cw_cache';
#$wgCreateWikiDatabase = 'wikidb';

# Enabled extensions. Most of the extensions are enabled by adding
# wfLoadExtension( 'ExtensionName' );
# to LocalSettings.php. Check specific extension documentation for more details.
# The following extensions were automatically enabled:
wfLoadExtensions([
	'AbuseFilter',
	'Echo',
	'Interwiki',
	'InterwikiDispatcher',
	'WikiEditor',
	'AntiSpoof',
	'CheckUser',
	'ConfirmEdit',
	'ConfirmEdit/hCaptcha',
	'BetaFeatures',
	'DataDump',
	'Scribunto',
	'GlobalPreferences',
	'ImportDump',
	'WikiDiscover',
	'GlobalBlocking',
	'ParserFunctions',
	'DiscordNotifications',
	'SkywikiMagic',
	'OAuth',
	'OATHAuth',
	'WebAuthn',
	'QuickInstantCommons',
	'TorBlock',
	'IPInfo'
]);
