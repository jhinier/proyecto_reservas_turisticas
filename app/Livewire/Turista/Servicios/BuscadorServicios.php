<?php

namespace App\Livewire\Turista\Servicios;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\TipoServicio;
use App\Models\Emprendimiento;

class BuscadorServicios extends Component
{
    use WithPagination;

    public $busqueda = '';

    #[Url]
    public $tipoServicioSeleccionado = null;

    // Movemos el diccionario aquí para usarlo en varias partes del archivo
    private $mapaCategorias = [
        // Guianza (ID 1)
        'guia' => 1, 'guianza' => 1, 'tour' => 1, 'caminata' => 1, 
        'recorrido' => 1, 'sendero' => 1, 'ruta' => 1, 'expedicion' => 1, 
        'trekking' => 1, 'paseo' => 1, 'montañismo' => 1, 'exploracion' => 1,

        // Paquetes Turísticos (ID 2)
        'paquete' => 2, 'viaje' => 2, 'excursion' => 2, 'plan' => 2, 
        'promo' => 2, 'promocion' => 2, 'feriado' => 2, 'full day' => 2, 
        'aventura' => 2, 'turismo' => 2,

        // Alimentación (ID 3)
        'comida' => 3, 'comer' => 3, 'almuerzo' => 3, 'desayuno' => 3, 
        'restaurante' => 3, 'cena' => 3, 'merienda' => 3, 'plato' => 3, 
        'asado' => 3, 'fritada' => 3, 'hornado' => 3, 'trucha' => 3, 
        'parrillada' => 3, 'comedor' => 3, 'gastronomia' => 3, 'bebida' => 3, 
        'cafe' => 3, 'cafeteria' => 3, 'bar' => 3, 'picanteria' => 3, 'hueca' => 3,

        // Hospedaje (ID 4)
        'dormir' => 4, 'hospedaje' => 4, 'hotel' => 4, 'habitacion' => 4, 
        'hostal' => 4, 'posada' => 4, 'camping' => 4, 'carpa' => 4, 
        'cabaña' => 4, 'alojamiento' => 4, 'refugio' => 4, 'cuarto' => 4, 
        'cama' => 4, 'estancia' => 4, 'motel' => 4, 'hosteria' => 4,

        // Alquiler de Equipos (ID 5)
        'equipo' => 5, 'alquiler' => 5, 'botas' => 5, 'casco' => 5, 
        'cuerda' => 5, 'bicicleta' => 5, 'bici' => 5, 'sleeping' => 5, 
        'tienda' => 5, 'linterna' => 5, 'bastones' => 5, 'alquilar' => 5, 
        'renta' => 5, 'rentar' => 5, 'accesorios' => 5
    ];

    public function updatedBusqueda($value)
    {
        $this->resetPage();
        
        $palabraBuscada = strtolower(trim($value));

        if (array_key_exists($palabraBuscada, $this->mapaCategorias)) {
            $this->tipoServicioSeleccionado = $this->mapaCategorias[$palabraBuscada];
        }
    }

    public function updatedTipoServicioSeleccionado()
    {
        $this->resetPage();
        // Limpiamos la búsqueda de texto al cambiar de categoría desde el menú
        $this->busqueda = '';
    }

    #[Layout('layouts.turista')]
    public function render()
    {
        $tiposServicio = TipoServicio::all();
        
        $tipoActual = $this->tipoServicioSeleccionado 
            ? $tiposServicio->where('id', $this->tipoServicioSeleccionado)->first() 
            : null;
            
        $nombreCategoria = $tipoActual ? $tipoActual->nombre : 'Todos los resultados';

        $query = Emprendimiento::query();

        // 1. Filtrar por categoría
        if ($this->tipoServicioSeleccionado) {
            $query->whereHas('tiposServicios', function ($q) {
                $q->where('tipo_servicio_id', $this->tipoServicioSeleccionado);
            });
        }

        // 2. Filtrar por texto
        $palabraLimpia = strtolower(trim($this->busqueda));
        $esPalabraClave = array_key_exists($palabraLimpia, $this->mapaCategorias);

        // Solo busca en nombre/descripción si NO es una palabra del diccionario
        if (!empty($this->busqueda) && !$esPalabraClave) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->busqueda . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->busqueda . '%');
            });
        }

        return view('livewire.turista.servicios.buscador-servicios', [
            'tiposServicio' => $tiposServicio,
            'resultados' => $query->paginate(10),
            'nombreCategoria' => $nombreCategoria,
        ]);
    }
}