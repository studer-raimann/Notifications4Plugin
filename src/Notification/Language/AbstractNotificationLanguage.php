<?php

namespace srag\Notifications4Plugin\Notification\Language;

use ActiveRecord;
use arConnector;
use ilDateTime;
use srag\DIC\DICTrait;
use srag\Notifications4Plugin\Notification\Language\Repository as NotificationLanguageRepository;
use srag\Notifications4Plugin\Notification\Language\RepositoryInterface as NotificationLanguageRepositoryInterface;
use srag\Notifications4Plugin\Notification\Repository as NotificationRepository;
use srag\Notifications4Plugin\Notification\RepositoryInterface as NotificationRepositoryInterface;
use srag\Notifications4Plugin\Utils\Notifications4PluginTrait;
use Throwable;

/**
 * Class AbstractNotificationLanguage
 *
 * @package srag\Notifications4Plugin\Notification\Language
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Stefan Wanzenried <sw@studer-raimann.ch>
 */
abstract class AbstractNotificationLanguage extends ActiveRecord implements NotificationLanguage {

	use DICTrait;
	use Notifications4PluginTrait;


	/**
	 * @inheritdoc
	 */
	protected static function notification(string $notification_class): NotificationRepositoryInterface {
		return NotificationRepository::getInstance($notification_class, static::class);
	}


	/**
	 * @inheritdoc
	 */
	protected static function notificationLanguage(): NotificationLanguageRepositoryInterface {
		return NotificationLanguageRepository::getInstance(static::class);
	}


	/**
	 * @return string
	 */
	public function getConnectorContainerName(): string {
		return static::TABLE_NAME;
	}


	/**
	 * @return string
	 *
	 * @deprecated
	 */
	public static function returnDbTableName(): string {
		return static::TABLE_NAME;
	}


	/**
	 *
	 */
	public static function updateDB_()/*: void*/ {
        try {
            self::updateDB();
        } catch (Throwable $ex) {
            // Fix Call to a member function getName() on null (Because not use ILIAS primary key)
        }

		if (self::dic()->database()->sequenceExists(static::TABLE_NAME)) {
			self::dic()->database()->dropSequence(static::TABLE_NAME);
		}

		self::dic()->database()->createAutoIncrement(static::TABLE_NAME, "id");
	}


	/**
	 *
	 */
	public static function dropDB_()/*: void*/ {
		self::dic()->database()->dropTable(static::TABLE_NAME, false);

		self::dic()->database()->dropAutoIncrementTable(static::TABLE_NAME);
	}


	/**
	 * @var int
	 *
	 * @con_has_field    true
	 * @con_fieldtype    integer
	 * @con_length       8
	 * @con_is_notnull   true
	 * @con_is_primary   true
	 */
	protected $id = 0;
	/**
	 * @var int
	 *
	 * @con_has_field    true
	 * @con_fieldtype    integer
	 * @con_length       8
	 * @con_is_notnull   true
	 */
	protected $notification_id;
	/**
	 * @var string
	 *
	 * @con_has_field    true
	 * @con_fieldtype    text
	 * @con_length       2
	 * @con_is_notnull   true
	 */
	protected $language = "";
	/**
	 * @var string
	 *
	 * @con_has_field    true
	 * @con_fieldtype    clob
	 * @con_length       256
	 * @con_is_notnull   true
	 */
	protected $subject = "";
	/**
	 * @var string
	 *
	 * @con_has_field    true
	 * @con_fieldtype    clob
	 * @con_length       4000
	 * @con_is_notnull   true
	 */
	protected $text = "";
	/**
	 * @var ilDateTime
	 *
	 * @con_has_field    true
	 * @con_fieldtype    timestamp
	 * @con_is_notnull   true
	 */
	protected $created_at;
	/**
	 * @var ilDateTime
	 *
	 * @con_has_field    true
	 * @con_fieldtype    timestamp
	 * @con_is_notnull   true
	 */
	protected $updated_at;


	/**
	 * AbstractNotificationLanguage constructor
	 *
	 * @param int              $primary_key_value
	 * @param arConnector|null $connector
	 */
	public function __construct(/*int*/ $primary_key_value = 0, /*?*/ arConnector $connector = null) {
		//parent::__construct($primary_key_value, $connector);
	}


	/**
	 * @inheritdoc
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @inheritdoc
	 */
	public function setId(int $id)/*: void*/ {
		$this->id = $id;
	}


	/**
	 * @inheritdoc
	 */
	public function getNotificationId(): int {
		return $this->notification_id;
	}


	/**
	 * @inheritdoc
	 */
	public function setNotificationId(int $notification_id)/*: void*/ {
		$this->notification_id = $notification_id;
	}


	/**
	 * @inheritdoc
	 */
	public function getLanguage(): string {
		return $this->language;
	}


	/**
	 * @inheritdoc
	 */
	public function setLanguage(string $language)/*: void*/ {
		$this->language = $language;
	}


	/**
	 * @inheritdoc
	 */
	public function getSubject(): string {
		return $this->subject;
	}


	/**
	 * @inheritdoc
	 */
	public function setSubject(string $subject)/*: void*/ {
		$this->subject = $subject;
	}


	/**
	 * @inheritdoc
	 */
	public function getText(): string {
		return $this->text;
	}


	/**
	 * @inheritdoc
	 */
	public function setText(string $text)/*: void*/ {
		$this->text = $text;
	}


	/**
	 * @inheritdoc
	 */
	public function getCreatedAt(): ilDateTime {
		return $this->created_at;
	}


	/**
	 * @inheritdoc
	 */
	public function setCreatedAt(ilDateTime $created_at)/*: void*/ {
		$this->created_at = $created_at;
	}


	/**
	 * @inheritdoc
	 */
	public function getUpdatedAt(): ilDateTime {
		return $this->updated_at;
	}


	/**
	 * @inheritdoc
	 */
	public function setUpdatedAt(ilDateTime $updated_at)/*: void*/ {
		$this->updated_at = $updated_at;
	}
}
