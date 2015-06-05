<?php
/**
 * Shows tracking information when viewing a newsletter.
 *
 * @package silverstripe-newsletter-tracking
 */
class NewsletterTrackingExtension extends DataExtension {

	private static $db = array(
		'Token' => 'Varchar(32)',
	);

	private static $has_many = array(
		'Views'     => 'NewsletterView',
		'LinkViews' => 'NewsletterLinkView',
	);

	public function updateCMSFields(FieldList $fields) {
		$fields->replaceField('TrackedLinks', $tracked = new TableListField(
			'LinkViews',
			'NewsletterLinkView',
			null,
			'"NewsletterID" = ' . $this->owner->ID,
			'"Created" DESC'
		));
		$tracked->setPermissions(array('show', 'export'));

		$viewers = new TableListField(
			'Views',
			'NewsletterView',
			null,
			'"NewsletterID" = ' . $this->owner->ID,
			'"Created" DESC'
		);
		$viewers->setPermissions(array('show', 'export'));

		$fields->addFieldsToTab('Root.ViewedBy', array(
			new LiteralField('ViewsNote', '<p>The viewed by list may not be '
				. 'accurate, as many email clients block images used for '
				. 'tracking by default.</p>'),
			$viewers
		));
	}

	public function onBeforeWrite() {
		if (!$this->owner->Token) {
			$generator = new RandomGenerator();
			$this->owner->Token = $generator->generateHash('md5');
		}
	}

}
