<?php

declare(strict_types=1);

namespace Minicli\Output\Filter;

use Minicli\Output\OutputFilterInterface;
use DateTime;

class TimestampOutputFilter implements OutputFilterInterface
{
    /**
     * adds timestamp to the message
     *
     * @param string $message
     * @param string|null $style
     * @return string
     */
    public function filter(string $message, ?string $style = null): string
    {
        $datetime = new DateTime();
        $style ??= 'Y-m-d H:i:S';
        return $datetime->format("[{$style}]").$message;
    }
}
