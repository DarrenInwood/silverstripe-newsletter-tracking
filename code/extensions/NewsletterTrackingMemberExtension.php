<?php
/**
 * Adds a token to the member object to enable newsletter tracking.
 *
 * @package silverstripe-newsletter-tracking
 */
class NewsletterTrackingMemberExtension extends DataExtension {

	private static $db = array(
		'NewsletterTrackingToken' => 'Varchar(32)',
	);

	public function onBeforeWrite() {
		if (!$this->owner->NewsletterTrackingToken) {
			$generator = new RandomGenerator();
			$this->owner->NewsletterTrackingToken = $generator->generateHash('md5');
		}
	}

}
