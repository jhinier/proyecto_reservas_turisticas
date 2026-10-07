<?php

namespace App\Livewire\Settings;

use App\Livewire\Settings\Concerns\UsesSettingsLayout;
use App\Models\Emprendimiento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Throwable;

#[Title('Datos del emprendimiento')]
class DatosEmprendimiento extends Component
{
    use UsesSettingsLayout;
    use WithFileUploads;

    public string $nombre = '';

    public string $descripcion = '';

    /** @var array<int, array{id: string, url: string}> */
    public array $redes = [];

    public ?TemporaryUploadedFile $imagen = null;

    public ?string $imagenActual = null;

    public function mount(): void
    {
        $emprendimiento = $this->emprendimientoActual();

        $this->nombre = $emprendimiento->nombre;
        $this->descripcion = $emprendimiento->descripcion;
        $this->imagenActual = $emprendimiento->imagen;
        $this->cargarRedes($emprendimiento->enlaces ?? []);
    }

    public function render()
    {
        return view('livewire.settings.datos-emprendimiento')
            ->layout($this->settingsLayout());
    }

    public function agregarRedSocial(): void
    {
        if (count($this->redes) >= 10) {
            $this->addError('redes', 'Puedes registrar hasta 10 redes sociales.');

            return;
        }

        $this->redes[] = $this->nuevaRed();
        $this->resetValidation('redes');
    }

    public function eliminarRedSocial(string $id): void
    {
        $this->redes = collect($this->redes)
            ->reject(fn (array $red) => ($red['id'] ?? null) === $id)
            ->values()
            ->all();

        $this->resetValidation('redes');
    }

    public function guardar(): void
    {
        $emprendimiento = $this->emprendimientoActual();
        $this->descripcion = trim($this->descripcion);

        foreach ($this->redes as $index => $red) {
            $this->redes[$index]['url'] = trim((string) ($red['url'] ?? ''));
        }

        $validated = $this->validate([
            'descripcion' => ['required', 'string', 'min:10', 'max:300'],
            'redes' => ['array', 'max:10'],
            'redes.*.id' => ['required', 'uuid'],
            'redes.*.url' => ['nullable', 'url:http,https', 'max:255', 'distinct'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'descripcion.required' => 'La descripcion es obligatoria.',
            'descripcion.min' => 'La descripcion debe tener al menos 10 caracteres.',
            'descripcion.max' => 'La descripcion no puede superar los 300 caracteres.',
            'redes.max' => 'Puedes registrar hasta 10 redes sociales.',
            'redes.*.url.url' => 'Ingresa un enlace valido que comience con http:// o https://.',
            'redes.*.url.max' => 'El enlace no puede superar los 255 caracteres.',
            'redes.*.url.distinct' => 'No puedes repetir el mismo enlace.',
            'imagen.image' => 'El archivo seleccionado debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe estar en formato JPG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede pesar mas de 5 MB.',
        ]);

        $enlaces = collect($validated['redes'])
            ->pluck('url')
            ->filter()
            ->values()
            ->all();

        $imagenAnterior = $emprendimiento->imagen;
        $nuevaRuta = null;

        try {
            if ($this->imagen) {
                $nuevaRuta = $this->imagen->store('emprendimientos', 'public');
            }

            $emprendimiento->update([
                'descripcion' => $validated['descripcion'],
                'enlaces' => $enlaces === [] ? null : $enlaces,
                ...($nuevaRuta ? ['imagen' => $nuevaRuta] : []),
            ]);
        } catch (Throwable $exception) {
            if ($nuevaRuta) {
                Storage::disk('public')->delete($nuevaRuta);
            }

            throw $exception;
        }

        $emprendimiento->refresh();

        if ($nuevaRuta && $imagenAnterior && $imagenAnterior !== $nuevaRuta) {
            Storage::disk('public')->delete($imagenAnterior);
        }

        $this->descripcion = $emprendimiento->descripcion;
        $this->imagenActual = $emprendimiento->imagen;
        $this->reset('imagen');
        $this->cargarRedes($enlaces);

        $this->dispatch('emprendimiento-updated');
    }

    private function emprendimientoActual(): Emprendimiento
    {
        $user = Auth::user();

        abort_unless($user instanceof User && $user->hasRole('emprendimiento'), 403);

        return $user->emprendimiento()->firstOrFail();
    }

    /** @param array<int, string> $enlaces */
    private function cargarRedes(array $enlaces): void
    {
        $this->redes = collect($enlaces)
            ->filter(fn ($url) => is_string($url) && trim($url) !== '')
            ->map(fn (string $url) => $this->nuevaRed($url))
            ->values()
            ->all();

        if ($this->redes === []) {
            $this->redes[] = $this->nuevaRed();
        }
    }

    /** @return array{id: string, url: string} */
    private function nuevaRed(string $url = ''): array
    {
        return [
            'id' => (string) Str::uuid(),
            'url' => $url,
        ];
    }
}
