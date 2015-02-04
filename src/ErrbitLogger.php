<?php
namespace Tomaj\Errbit;

use Tracy\Debugger as TDebugger;
use Tracy\Logger;

class ErrbitLogger extends Logger
{
  /** @var boolean */
  private static $ignoreNotice;

  /**
   * Register logger to \Tracy\Debugger
   * @param array $config
   * @param boolean $ignoreNotice
   */
  public static function register($config, $ignoreNotice = false)
  {
    self::$ignoreNotice = $ignoreNotice;

    if ($config['send_errors']) {
      unset($config['send_errors']);

      $logger = new self();
      $logger->directory = & TDebugger::$logDirectory;
      $logger->email = & TDebugger::$email;
      $logger->mailer = & TDebugger::$mailer;
      $logger->emailSnooze = & TDebugger::$emailSnooze;

      TDebugger::setLogger($logger);

      \Errbit::instance()
        ->configure($config);
//        ->start();
    }
  }

  /**
   * Wrapper for log function
   * @param array $message
   * @param string $priority
   * @return bool
   */
  public function log($message, $priority = NULL)
  {
    if (self::$ignoreNotice && (strpos($message, 'PHP Notice') !== false)) {
      return true;
    }

    $response = parent::log($message, $priority);

    \Errbit::instance()->notify(
      new \Exception($priority . ' ' . $message[1])
    );

    return $response;
  }
}
