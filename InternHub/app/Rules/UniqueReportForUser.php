<?php

namespace App\Rules;

use Closure;
use App\Models\ProgressReport;
use Illuminate\Contracts\Validation\ValidationRule;


class UniqueReportForUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $userId = auth()->id();

        // Check if a report with the same period and user ID already exists
        if (ProgressReport::where('s_id', $userId)
            ->where('period', $value)
            ->exists()) {
            // Report for this period already exists, so indicate a validation failure
            $fail("A report for this period already exists.");
        }
    }
}
