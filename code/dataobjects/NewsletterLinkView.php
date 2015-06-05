<?php
/**
 * Records an individual link click.
 *
 * @package silverstripe-newsletter-tracking
 */
class NewsletterLinkView extends DataObject {

	private static $db = array(
		'IP' => 'Varchar(39)'
	);

	private static $has_one = array(
		'Link'       => 'Newsletter_TrackedLink',
		'Newsletter' => 'Newsletter',
		'Member'     => 'Member'
	);

	private static $summary_fields = array(
		'CreatedNice'   => 'Time',
		'Link.Original' => 'Link',
		'Member.ID'     => 'Member ID',
		'Member.Email'  => 'Email',
		'Member.Name'   => 'Name',
		'IP'            => 'IP Address'
	);

	public function getCreatedNice() {
		return $this->obj('Created')->Nice();
	}

	protected function onBeforeWrite() {
		if ($this->LinkID) {
			$this->NewsletterID = $this->Link()->NewsletterID;
		}

		parent::onBeforeWrite();
	}

}
