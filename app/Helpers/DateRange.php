<?php

namespace App\Helpers;

use Carbon\Carbon;

readonly class DateRange
{
    public function __construct(
        public Carbon $start,
        public Carbon $end,
        public string $label
    ) {}

    public function previous(): self
    {
        $diff = $this->start->diffInDays($this->end) + 1;

        return new self(
            $this->start->copy()->subDays($diff),
            $this->end->copy()->subDays($diff),
            $this->label
        );
    }
}
