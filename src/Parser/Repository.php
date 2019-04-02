<?php

namespace srag\Notifications4Plugin\Parser;

use srag\DIC\DICTrait;
use srag\Notifications4Plugin\Exception\Notifications4PluginException;
use srag\Notifications4Plugin\Notification\AbstractNotification;
use srag\Notifications4Plugin\Utils\Notifications4PluginTrait;

/**
 * Class Repository
 *
 * @package srag\Notifications4Plugin\Parser
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Repository {

	use DICTrait;
	use Notifications4PluginTrait;
	/**
	 * @var self
	 */
	protected static $instance = null;


	/**
	 * @return self
	 */
	public static function getInstance(): self {
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * @var array
	 */
	protected static $parsers = [
		twigParser::class => twigParser::NAME
	];


	/**
	 * Repository constructor
	 */
	private function __construct() {

	}


	/**
	 * @return Factory
	 */
	public function factory(): Factory {
		return Factory::getInstance();
	}


	/**
	 * @return Parser[]
	 */
	public function getPossibleParsers(): array {
		return self::$parsers;
	}


	/**
	 * @param string $parser_class
	 *
	 * @return Parser
	 *
	 * @throws Notifications4PluginException
	 */
	public function getParserByClass(string $parser_class): Parser {
		if (isset($this->getPossibleParsers()[$parser_class])) {
			return new $parser_class();
		} else {
			throw new Notifications4PluginException("Invalid parser class $parser_class");
		}
	}


	/**
	 * @param AbstractNotification $notification
	 *
	 * @return Parser
	 *
	 * @throws Notifications4PluginException
	 */
	public function getParserForNotification(AbstractNotification $notification): Parser {
		return $this->getParserByClass($notification->getParser());
	}


	/**
	 * @param Parser               $parser
	 * @param AbstractNotification $notification
	 * @param array                $placeholders
	 * @param string               $language
	 *
	 * @return string
	 *
	 * @throws Notifications4PluginException
	 */
	public function parseSubject(Parser $parser, AbstractNotification $notification, array $placeholders = array(), string $language = ""): string {
		return $parser->parse($notification->getSubject($language), $placeholders);
	}


	/**
	 * @param Parser               $parser
	 * @param AbstractNotification $notification
	 * @param array                $placeholders
	 * @param string               $language
	 *
	 * @return string
	 *
	 * @throws Notifications4PluginException
	 */
	public function parseText(Parser $parser, AbstractNotification $notification, array $placeholders = array(), string $language = ""): string {
		return $parser->parse($notification->getText($language), $placeholders);
	}
}