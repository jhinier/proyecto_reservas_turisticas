<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Creamos la nueva tabla del "Carrito" (Detalles)
        Schema::create('reserva_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained('reservas')->onDelete('cascade');
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            
            // Las fechas se mudan aquí (puedo reservar hotel del 1 al 5, y un tour solo el día 2)
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            
            // Cantidad (Ej: 2 habitaciones, o 4 personas para un almuerzo)
            $table->integer('cantidad'); 

            // 🔥 REGLA DE ORO FINANCIERA: Snapshot del precio
            // Si el emprendedor sube el precio mañana, esta reserva YA pagada no debe alterarse.
            $table->decimal('precio_unitario', 8, 2); 
            $table->decimal('subtotal', 8, 2); // cantidad * precio_unitario

            $table->timestamps();
        });

        // 2. Limpiamos la tabla Reservas (Cabecera)
        // Le quitamos los campos que ahora pertenecen al detalle
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropForeign(['servicio_id']); // Rompemos la relación vieja
            $table->dropColumn([
                'servicio_id', 
                'fecha_inicio', 
                'fecha_fin', 
                'numero_personas'
            ]);
        });
    }

    public function down(): void
    {
        // Revertir (por si necesitas hacer rollback)
        Schema::table('reservas', function (Blueprint $table) {
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->onDelete('cascade');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('numero_personas')->nullable();
        });

        Schema::dropIfExists('reserva_detalles');
    }
};