<?php

namespace App\Classes;

use Carbon\Carbon;

class WriteToFile
{
    const LOG_TYPE_ERROR = 0;
    const LOG_TYPE_WARNING = 1;
    const LOG_TYPE_INFO = 2;

    /**
     * @param string $file
     * @param string $message
     * @param bool   $clearLog
     * @param bool   $splitByDate
     */
    public static function logMessage(string $file, string $message, bool $clearLog = false, bool $splitByDate = false)
    {
        // TODO: add log level consideration
        self::checkDir($file);
        if ($splitByDate) {
            $path = pathinfo($file);
            $today = Carbon::now()->toDateString();
            $file = $path['dirname'] . '/' . $path['filename'] . '_' . $today . '.' . $path['extension'];
        }
        $message = Carbon::Now()->toDateTimeString() . ": " . $message;
        if ($clearLog) {
            file_put_contents($file, $message . "\r\n");
        } else {
            file_put_contents($file, $message . "\r\n", FILE_APPEND);
        }
    }

    /**
     * @param $message
     * @param $clearLog
     */
    public static function writeOnce(string $file, string $content)
    {
        self::checkDir($file);
        file_put_contents($file, $content);
    }

    /**
     * @param $message
     * @param $clearLog
     */
    public static function write(string $file, string $content)
    {
        self::checkDir($file);
        file_put_contents($file, $content, FILE_APPEND);
    }

    protected static function checkDir($file)
    {
        $dir = pathinfo($file)['dirname'];
        if (!is_dir($dir)) {
            mkdir($dir);
        }
    }
}
