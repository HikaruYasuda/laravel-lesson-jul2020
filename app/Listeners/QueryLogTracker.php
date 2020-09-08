<?php

namespace App\Listeners;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueryLogTracker
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  QueryExecuted  $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        $sql = $this->replaceQueryPlaceholder($event->sql, $event->bindings);
        $time = sprintf('%01.3fs', $event->time / 1000);
        logger("($time)\n$sql");
    }

    private function replaceQueryPlaceholder($sql, array $bindings)
    {
        static $QUOTE = "'";
        static $SLASH = "\\";
        static $PLACEHOLDER = '?';
        $result = '';
        $seek = 0;
        $length = strlen($sql);
        $escaped = $quoted = false;
        $index = 0;

        for (; $seek < $length; $seek++) {
            $c = $sql{$seek};
            if ($c === $QUOTE && !$escaped) {
                $quoted = !$quoted;
            } elseif ($c === $SLASH) {
                $escaped = !$escaped;
            } elseif ($c === $PLACEHOLDER && !$quoted) {
                $value = $bindings[$index++];
                if ($value instanceof Carbon) {
                    $value = $value->toDateTimeString();
                } elseif ($value instanceof DateTimeInterface) {
                    $value = $value->format('Y-m-d H:i:s');
                }
                $c = var_export($value, true);
            }
            $result .= $c;
        }
        return $result;
    }
}
