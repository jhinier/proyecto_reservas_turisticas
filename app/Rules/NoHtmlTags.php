<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoHtmlTags implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Lista de patrones peligrosos
        $patrones = [
            '/<script/i',           // <script> tags
            '/<iframe/i',           // <iframe> tags
            '/<img/i',              // <img> tags
            '/javascript:/i',       // javascript: protocol
            '/<style/i',            // <style> tags
            '/<svg/i',              // <svg> tags
            '/onerror=/i',          // onerror attribute
            '/onload=/i',           // onload attribute
            '/onclick=/i',          // onclick attribute
            '/onmouseover=/i',      // onmouseover attribute
            '/<embed/i',            // <embed> tags
            '/<object/i',           // <object> tags
        ];

        foreach ($patrones as $patron) {
            if (preg_match($patron, $value)) {
                $fail("El campo $attribute contiene etiquetas HTML o código no permitido.");
                return;
            }
        }
    }
}
