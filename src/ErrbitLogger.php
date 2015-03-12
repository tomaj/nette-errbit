<?php
namespace Tomaj\Errbit;

use Tracy\Debugger as TDebugger;
use Tracy\Logger;

class ErrbitLogger extends Logger
{
    /** @var array */
    private static $priorities = array(
        'error',
        'exception'
    );

    /** @var array */
    private static $ignoredMessages = array();

    /**
     * Register logger to \Tracy\Debugger
     * @param array $config
     */
    public static function register($config)
    {

        if ($config['send_errors']) {
            unset($config['send_errors']);

            $logger = new self(TDebugger::$logDirectory);
            $logger->email = & TDebugger::$email;

            TDebugger::setLogger($logger);

            \Errbit::instance()
                ->configure($config);
//                ->start();
        }
    }

    /**
     *
     * @param array $priorities
     */
    public static function setLogPriorities($priorities = array())
    {
        if (empty($priorities)) {
            return;
        }

        self::$priorities = $priorities;
    }

    /**
     * Add new ignored message
     * @param string $message
     */
    public static function addIgnoreMessage($message)
    {
        self::$ignoredMessages[$message] = $message;
    }

    /**
     * Ignore all php notice messages
     */
    public static function ignoreNotices()
    {
        self::addIgnoreMessage('PHP Notice');
    }

    /**
     * Wrapper for log function
     * @param array $message
     * @param string $priority
     * @return bool
     */
    public function log($message, $priority = null)
    {
        // If message contains one of ignored messages, shut down
        foreach (self::$ignoredMessages as $ignoredMessage) {
            if (strpos($message[1], $ignoredMessage) !== false) {
                return true;
            }
        }

        // Log to file
        $response = parent::log($message, $priority);

        if (in_array($priority, self::$priorities)) {
            if ($message instanceof \Exception) {
                \Errbit::instance()->notify($message);
            } else {
                \Errbit::instance()->notify(
                    new \Exception($priority . ' ' . $message)
                );
            }
        }

        return $response;
    }
}
