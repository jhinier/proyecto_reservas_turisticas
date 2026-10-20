<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class SanitizeTextInputs
{
    /**
     * @var array<int, string>
     */
    private array $excludedKeys = [
        '_token',
        '_method',
        'csrf',
        'token',
        'password',
        'password_confirmation',
        'current_password',
        'remember_token',
        'signature',
        'file',
        'foto',
        'imagen',
        'imagenes',
        'documento',
        'comprobante',
        'snapshot',
        'checksum',
        'effects',
        'memo',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET')) {
            return $next($request);
        }

        if (is_array($request->input('components'))) {
            $payload = $request->all();
            $payload['components'] = $this->sanitizeLivewireComponents($payload['components']);
            $request->replace($payload);

            return $next($request);
        }

        $request->merge($this->sanitizeArray($request->all()));

        return $next($request);
    }

    private function sanitizeLivewireComponents(array $components): array
    {
        foreach ($components as $index => $component) {
            if (! is_array($component)) {
                continue;
            }

            if (isset($component['updates']) && is_array($component['updates'])) {
                $components[$index]['updates'] = $this->sanitizeArray($component['updates']);
            }

            if (isset($component['calls']) && is_array($component['calls'])) {
                foreach ($component['calls'] as $callIndex => $call) {
                    if (isset($call['params']) && is_array($call['params'])) {
                        $components[$index]['calls'][$callIndex]['params'] = $this->sanitizeArray($call['params']);
                    }
                }
            }
        }

        return $components;
    }

    private function sanitizeArray(array $values): array
    {
        foreach ($values as $key => $value) {
            if ($this->shouldSkip((string) $key, $value)) {
                continue;
            }

            if (is_array($value)) {
                $values[$key] = $this->sanitizeArray($value);
                continue;
            }

            if (is_string($value)) {
                $values[$key] = strip_tags($value);
            }
        }

        return $values;
    }

    private function shouldSkip(string $key, mixed $value): bool
    {
        if ($value instanceof UploadedFile) {
            return true;
        }

        $normalizedKey = strtolower($key);

        foreach ($this->excludedKeys as $excludedKey) {
            if (str_contains($normalizedKey, $excludedKey)) {
                return true;
            }
        }

        return false;
    }
}
