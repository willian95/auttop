<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $status = new Status;
        $status->id = 1;
        $status->text = "orden creada";
        $status->save();

        $status = new Status;
        $status->id = 2;
        $status->text = "Presupuesto enviado";
        $status->save();

        $status = new Status;
        $status->id = 3;
        $status->text = "Presupuesto rechazado";
        $status->save();

        $status = new Status;
        $status->id = 4;
        $status->text = "Presupuesto aprobado";
        $status->save();

        $status = new Status;
        $status->id = 5;
        $status->text = "Auto en camino al taller";
        $status->save();

        $status = new Status;
        $status->id = 6;
        $status->text = "Auto en proceso";
        $status->save();

        $status = new Status;
        $status->id = 7;
        $status->text = "Selección de reparaciones";
        $status->save();

        $status = new Status;
        $status->id = 8;
        $status->text = "En espera de pago";
        $status->save();

        $status = new Status;
        $status->id = 9;
        $status->text = "Verificación de pago";
        $status->save();

        $status = new Status;
        $status->id = 10;
        $status->text = "Auto en proceso de lavado";
        $status->save();

        $status = new Status;
        $status->id = 11;
        $status->text = "Auto en camino a tu lugar";
        $status->save();

        $status = new Status;
        $status->id = 12;
        $status->text = "Finalizado";
        $status->save();

        $status = new Status;
        $status->id = 13;
        $status->text = "Orden cancelada";
        $status->save();

    }
}
