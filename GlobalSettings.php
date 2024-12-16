<?php
// Protect against web entry
if (!defined('MEDIAWIKI')) {
	die('Not an entry point.');
}

$wgHooks['CreateWikiDataFactoryBuilder'][] = 'MirahezeFunctions::onCreateWikiDataFactoryBuilder';
$wgHooks['ManageWikiCoreAddFormFields'][] = 'MirahezeFunctions::onManageWikiCoreAddFormFields';
$wgHooks['ManageWikiCoreFormSubmission'][] = 'MirahezeFunctions::onManageWikiCoreFormSubmission';
$wgHooks['MediaWikiServices'][] = 'MirahezeFunctions::onMediaWikiServices';
$wgHooks['BeforePageDisplay'][] = static function ( &$out, &$skin ) {
	if ( $out->getTitle()->isSpecialPage() ) {
		$out->setRobotPolicy( 'noindex,nofollow' );
	}
	return true;
};
/*
if ( $wmgMirahezeContactPageFooter && $wi->isExtensionActive( 'ContactPage' ) ) {
	$wgHooks['SkinAddFooterLinks'][] = static function ( Skin $skin, string $key, array &$footerlinks ) {
		if ( $key === 'places' ) {
			$footerlinks['contact'] = Html::element( 'a',
				[
					'href' => htmlspecialchars( SpecialPage::getTitleFor( 'Contact' )->getFullURL() ),
					'rel' => 'noreferrer noopener',
				],
				$skin->msg( 'contactpage-label' )->text()
			);
		}
	};
}
 */
if ( $wi->isExtensionActive( 'chameleon' ) ) {
	wfLoadExtension( 'Bootstrap' );
}

if ($wi->isExtensionActive('CirrusSearch')) {
	wfLoadExtension('Elastica');
	$wgSearchType = 'CirrusSearch';
	$wgCirrusSearchServers = ['localhost'];

	if ($wi->isExtensionActive('RelatedArticles')) {
		$wgRelatedArticlesUseCirrusSearch = true;
	}
}

if ($wi->isExtensionActive('SocialProfile')) {
	require_once "$IP/extensions/SocialProfile/SocialProfile.php";

	#$wgSocialProfileFileBackend = 'miraheze-swift';
}

if ($wi->isExtensionActive('JsonConfig')) {
	$wgJsonConfigEnableLuaSupport = true;
}

$articlePath = str_replace( '$1', '', $wgArticlePath );

$wgDiscordNotificationWikiUrl = $wi->server . $articlePath;
$wgDiscordNotificationWikiUrlEnding = '';
$wgDiscordNotificationWikiUrlEndingDeleteArticle = '?action=delete';
$wgDiscordNotificationWikiUrlEndingDiff = '?diff=prev&oldid=';
$wgDiscordNotificationWikiUrlEndingEditArticle = '?action=edit';
$wgDiscordNotificationWikiUrlEndingHistory = '?action=history';
$wgDiscordNotificationWikiUrlEndingUserRights = 'Special:UserRights?user=';

// Public Wikis
if ( !$cwPrivate ) {
	$wgDiscordIncomingWebhookUrl = "https://discord.com/api/webhooks/1314112442565132329/kNOrvoHFpOYjelMPyFgvie9nRe_sPM8AqqHTu00Tt5zK6pRC7y9QLcNw83ObvZzPcaBj"; //$wmgGlobalDiscordWebhookUrl;
}

if ($cwClosed) {
	$wgRevokePermissions = [
		'*' => [
			'block' => true,
			'createaccount' => true,
			'delete' => true,
			'edit' => true,
			'protect' => true,
			'import' => true,
			'upload' => true,
			'undelete' => true,
		],
	];

	if ($wi->isExtensionActive('Comments')) {
		$wgRevokePermissions['*']['comment'] = true;
	}
}

$wgDataDumpDirectory = '/var/www/dumps/';

$wgDataDump = [
	'xml' => [
		'file_ending' => '.xml.gz',
		'useBackendTempStore' => true,
		'generate' => [
			'type' => 'mwscript',
			'script' => "$IP/maintenance/dumpBackup.php",
			'options' => [
				'--full',
				'--logs',
				'--uploads',
				'--output',
				'gzip:/tmp/${filename}',
			],
			'arguments' => [
				'--namespaces'
			],
		],
		'limit' => 1,
		'permissions' => [
			'view' => 'view-dump',
			'generate' => 'generate-dump',
			'delete' => 'delete-dump',
		],
		'htmlform' => [
			'name' => 'namespaceselect',
			'type' => 'namespaceselect',
			'exists' => true,
			'noArgsValue' => 'all',
			'hide-if' => ['!==', 'generatedumptype', 'xml'],
			'label-message' => 'datadump-namespaceselect-label'
		],
	],
	'zip' => [
		'file_ending' => '.zip',
		'generate' => [
			'type' => 'script',
			'script' => '/usr/bin/zip',
			'options' => [
				'-r',
				"{$wgDataDumpDirectory}" . '${filename}',
				"$IP/images/{$wgDBname}",
			],
		],
		'limit' => 1,
		'permissions' => [
			'view' => 'view-dump',
			'generate' => 'generate-dump',
			'delete' => 'delete-dump',
		],
	],

	/*'managewiki_backup' => [
		'file_ending' => '.json',
		'generate' => [
			'type' => 'mwscript',
			'script' => "$IP/extensions/WikiOasisMagic/maintenance/generateManageWikiBackup.php",
			'options' => [
				'--filename',
				'${filename}'
			],
		],
		'limit' => 1,
		'permissions' => [
			'view' => 'view-dump',
			'generate' => 'generate-dump',
			'delete' => 'delete-dump',
		],
	],*/
];

// $wgLogos
$wgLogos = [
	'1x' => $wgLogo,
];

$wgApexLogo = [
	'1x' => $wgLogos['1x'],
	'2x' => $wgLogos['1x'],
];

if ( $wgIcon ) {
	$wgLogos['icon'] = $wgIcon;
}

if ( $wgWordmark ) {
	$wgLogos['wordmark'] = [
		'src' => $wgWordmark,
		'width' => $wgWordmarkWidth,
		'height' => $wgWordmarkHeight,
	];
}
$wgHCaptchaSiteKey = '33e28cca-4d96-44d2-9e5e-050282c8b2a2';
$wgHCaptchaSecretKey = ''; // redacted for security reasons
