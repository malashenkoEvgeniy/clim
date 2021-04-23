<?php namespace App\Helpers;

use App\Exceptions\WrongParametersException;

/**
 * Class Alert
 * Message on top of the page
 *
 * @package App\Helpers
 */
class Alert
{
    // Info type of the message
    const TYPE_INFO = 'info';
    
    // Success type of the message
    const TYPE_SUCCESS = 'success';
    
    // Danger type of the message
    const TYPE_DANGER = 'danger';
    
    // Warning type of the message
    const TYPE_WARNING = 'warning';
    
    /**
     * Key for session
     *
     * @var string
     */
    static $sessionKey = 'alert';
    
    /**
     * Alert constructor.
     * Save data to the session, will be used once
     *
     * @param  string $text
     * @param  string $type
     * @param  string|null $title
     * @param  string|null $icon
     * @throws WrongParametersException
     */
    public function __construct(string $text, string $type = null, $title = null, $icon = null)
    {
        $type = $type ?: static::TYPE_INFO;
        $types = [static::TYPE_INFO, static::TYPE_SUCCESS, static::TYPE_WARNING, static::TYPE_DANGER];
        if (in_array($type, $types) === false) {
            throw new WrongParametersException('Wrong alert type!');
        }
        if (!$text) {
            throw new WrongParametersException('Text can not be empty!');
        }
        request()->session()->flash(
            static::$sessionKey, [
                'type' => $type,
                'title' => $title,
                'text' => $text,
                'icon' => $icon,
            ]
        );
    }
    
    /**
     * Helper for creating message
     *
     * @param  string $text
     * @param  string $type
     * @param  string|null $title
     * @param  string|null $icon
     * @return Alert
     * @throws WrongParametersException
     */
    public static function create(string $text, string $type = 'info', string $title = null, string $icon = null)
    {
        return new Alert(trim($text), $type, trim($title) ?: null, trim($icon) ?: null);
    }
    
    /**
     * Helper for `danger` message
     *
     * @param  string $text
     * @param  null|string $title
     * @return Alert
     * @throws WrongParametersException
     */
    public static function danger(string $text, string $title = null)
    {
        return new Alert(trim($text), 'danger', trim($title) ?: null, 'ban');
    }
    
    /**
     * Helper for `success` message
     *
     * @param  string $text
     * @param  null|string $title
     * @return Alert
     * @throws WrongParametersException
     */
    public static function success(string $text, string $title = null)
    {
        return new Alert(trim($text), 'success', trim($title) ?: null, 'check');
    }
    
    /**
     * Helper for `info` message
     *
     * @param  string $text
     * @param  string|null $title
     * @return Alert
     * @throws WrongParametersException
     */
    public static function info(string $text, string $title = null)
    {
        return new Alert(trim($text), 'info', trim($title) ?: null, 'info');
    }
    
    /**
     * Helper for `warning` message
     *
     * @param  string $text
     * @param  string|null $title
     * @return Alert
     * @throws WrongParametersException
     */
    public static function warning(string $text, string $title = null)
    {
        return new Alert(trim($text), 'warning', trim($title) ?: null, 'warning');
    }
    
    /**
     * Get message to show
     *
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function get()
    {
        return session(static::$sessionKey);
    }
    
}
