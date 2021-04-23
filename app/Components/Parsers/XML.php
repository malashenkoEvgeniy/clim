<?php

namespace App\Components\Parsers;

use SimpleXMLElement;

/**
 * Trait XML
 *
 * @package App\Components\Parsers
 */
trait XML
{
    /**
     * Устанавливаем значение для какого-то свойства из аттрибутов внешнего источника
     *
     * @param SimpleXMLElement $element
     * @param $key
     * @param string $type
     * @param null $default
     * @return array|float|int|null|string
     */
    protected function getElementFromAttribute(SimpleXMLElement $element, $key, $type = 'string', $default = null)
    {
        if (isset($element[$key]) === false) {
            $value = $default;
        } else {
            $value = $this->getValue($element[$key], $type);
        }
        return is_string($value) ? trim($value) : $value;
    }
    
    /**
     * Устанавливаем значение для какого-то свойства из свойства внешнего источника
     *
     * @param SimpleXMLElement|SimpleXMLElement[] $element
     * @param $key
     * @param string $type
     * @param null $default
     * @return array|float|int|null|string
     */
    protected function getElementFromProperty(SimpleXMLElement $element, $key, $type = 'string', $default = null)
    {
        if (isset($element->{$key}) === false) {
            return $default;
        }
        return $this->getValue($element->{$key}, $type, $default);
    }
    
    /**
     * Приводим значение к определенному типу
     *
     * @param $value
     * @param $type
     * @param mixed $default
     * @return array|float|int|string
     */
    private function getValue($value, $type, $default = null)
    {
        switch ($type) {
            case 'int':
            case 'integer':
                return (int)$value;
            case 'array':
                return (array)$value;
            case 'float':
                return (float)$value;
            case 'bool':
            case 'boolean':
                return $this->toBoolean($value);
        }
        return trim((string)$value) ?: $default;
    }
    
    /**
     * Преобразовываем в булевое значение
     *
     * @param string $string
     * @return bool
     */
    private function toBoolean($string)
    {
        return trim((string)$string) === 'true';
    }
    
    /**
     * @param $url
     * @return bool|string
     * @throws \Exception
     */
    private function curl($url)
    {
        $userAgent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
        curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
        curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);  // user agent
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа
        $content = curl_exec($ch);
        $headers = curl_getinfo($ch);
        $headers['error_number'] = (int)curl_errno($ch);
        $headers['error_message'] = curl_error($ch);
        curl_close($ch);
        if (isset($headers['http_code']) === false || (int)$headers['http_code'] !== 200) {
            throw new \Exception("Содержимое страницы $url не является XML файлом");
        }
        if ((int)$headers['error_number'] > 0) {
            throw new \Exception($headers['error_message']);
        }
        return $content;
    }
    
}
