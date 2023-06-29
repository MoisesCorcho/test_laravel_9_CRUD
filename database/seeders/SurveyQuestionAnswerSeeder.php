<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SurveyQuestionAnswer;

class SurveyQuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answersQuestions = [
            [
                'id'               => 1,
                'answer'           => '["No"]',
                'surveyQuestionId' => 1,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 2,
                'answer'           => '["E.S.E. VIDA SINU"]',
                'surveyQuestionId' => 2,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 3,
                'answer'           => '["Mayerly Trillos"]',
                'surveyQuestionId' => 3,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 4,
                'answer'           => '["Gerente - Administrador"]',
                'surveyQuestionId' => 4,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 5,
                'answer'           => '["Vender - Promocion de productos - Documentos de credito"]',
                'surveyQuestionId' => 5,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 6,
                'answer'           => '["No"]',
                'surveyQuestionId' => 6,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 7,
                'answer'           => '["No"]',
                'surveyQuestionId' => 7,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 8,
                'answer'           => '["Si"]',
                'surveyQuestionId' => 8,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 9,
                'answer'           => "Planeación de ruta y toma de pedido vía telefonica",
                'surveyQuestionId' => 9,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 10,
                'answer'           => "",
                'surveyQuestionId' => 10,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 11,
                'answer'           => "",
                'surveyQuestionId' => 11,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 12,
                'answer'           => "09:00",
                'surveyQuestionId' => 12,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],
            [
                'id'               => 13,
                'answer'           => "10:00",
                'surveyQuestionId' => 13,
                'surveyAnswerId'   => 1,
                'state'            => 0
            ],

            // Segunda Respuesta

            [
                'id'               => 14,
                'answer'           => '["Si"]',
                'surveyQuestionId' => 1,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 15,
                'answer'           => '["Clínica central de urgencias"]',
                'surveyQuestionId' => 2,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 16,
                'answer'           => '["Jennifer Pérez montes "]',
                'surveyQuestionId' => 3,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 17,
                'answer'           => '["Compras"]',
                'surveyQuestionId' => 4,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 18,
                'answer'           => '["Vender - Promocion de productos - Documentos de credito"]',
                'surveyQuestionId' => 5,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 19,
                'answer'           => '["No"]',
                'surveyQuestionId' => 6,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 20,
                'answer'           => '["No"]',
                'surveyQuestionId' => 7,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 21,
                'answer'           => '["Si"]',
                'surveyQuestionId' => 8,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 22,
                'answer'           => "Poder entablar conversación con la encargada de compra",
                'surveyQuestionId' => 9,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 23,
                'answer'           => "",
                'surveyQuestionId' => 10,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 24,
                'answer'           => "Recepción de documento para crear nuevo cliente ",
                'surveyQuestionId' => 11,
                'surveyAnswerId'   => 2,
                'state'            => 1
            ],
            [
                'id'               => 25,
                'answer'           => "15:20",
                'surveyQuestionId' => 12,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],
            [
                'id'               => 26,
                'answer'           => "16:00",
                'surveyQuestionId' => 13,
                'surveyAnswerId'   => 2,
                'state'            => 0
            ],

            // Tercera Respuesta

            // ¿Es nuevo el cliente?
            [
                'id'               => 27,
                'answer'           => '["No"]',
                'surveyQuestionId' => 1,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // Cliente
            [
                'id'               => 28,
                'answer'           => '["E.S.E. VIDA SINU"]',
                'surveyQuestionId' => 2,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // Nombre de contacto
            [
                'id'               => 29,
                'answer'           => '["Karen Peña"]',
                'surveyQuestionId' => 3,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // Cargo de contacto
            [
                'id'               => 30,
                'answer'           => '["Farmacia - Regente de Farmacia - Bodega - Almacén"]',
                'surveyQuestionId' => 4,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // Proposito
            [
                'id'               => 31,
                'answer'           => '["Vender - Promocion de productos - Documentos de credito"]',
                'surveyQuestionId' => 5,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // ¿Realizó venta?
            [
                'id'               => 32,
                'answer'           => '["Si"]',
                'surveyQuestionId' => 6,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // ¿El cliente realizó pago?
            [
                'id'               => 33,
                'answer'           => '["No"]',
                'surveyQuestionId' => 7,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // ¿Se obtuvo un logro?
            [
                'id'               => 34,
                'answer'           => '["Si"]',
                'surveyQuestionId' => 8,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // Breve descripción SI obtuvo algún logro
            [
                'id'               => 35,
                'answer'           => "Se acordaron los productos que estaban pendientes para hacer la facturación que nos hace falta del contrato No 051",
                'surveyQuestionId' => 9,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // Breve observación entorno a la visita
            [
                'id'               => 36,
                'answer'           => "",
                'surveyQuestionId' => 10,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // Tarea y/o Pendiente
            [
                'id'               => 37,
                'answer'           => "Organizar el archivo en Excel para poder hacer los cruces correspondientes y hacer la facturación",
                'surveyQuestionId' => 11,
                'surveyAnswerId'   => 3,
                'state'            => 1
            ],
            // Hora de Inicio
            [
                'id'               => 38,
                'answer'           => "16:20",
                'surveyQuestionId' => 12,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
            // Hora de Finalización
            [
                'id'               => 39,
                'answer'           => "17:20",
                'surveyQuestionId' => 13,
                'surveyAnswerId'   => 3,
                'state'            => 0
            ],
        ];

        foreach ($answersQuestions as $answersQuestion) {
            $response = new SurveyQuestionAnswer;
            $response->answer           = $answersQuestion['answer'];
            $response->surveyQuestionId = $answersQuestion['surveyQuestionId'];
            $response->surveyAnswerId   = $answersQuestion['surveyAnswerId'];
            $response->state            = $answersQuestion['state'];
            $response->save();
        }

    }
}
