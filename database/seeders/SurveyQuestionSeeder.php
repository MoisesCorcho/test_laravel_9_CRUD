<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SurveyQuestion;
use App\Models\Survey;

class SurveyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*El array de opciones que van en el apartado de "data" lo convertimos
        a formato JSON para poder almacenarlo en BD*/
        $proposito = [
                [
                    'uuid' => 'e3ce4b92-acbb-4b04-957f-705454100d0b',
                    'text' => 'Vender / Promoción de productos / Documentos de crédito'
                ],
                [
                    'uuid' => 'a3ebf45d-11cc-4c20-afd8-90951f84a830',
                    'text' => 'Recaudo de cartera / Acuerdos de Pago'
                ],
        ];

        $questions = [
            [
                'id' => 1,
                'type' => 'select',
                'question' => '¿Es nuevo el cliente?',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => "newclient",
                'data' => json_encode([])
            ],
            [
                'id' => 2,
                'type' => 'select',
                'question' => 'Cliente',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => "organization",
                'data' => json_encode([])
            ],
            [
                'id' => 3,
                'type' => 'select',
                'question' => 'Nombre de contacto',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => "member",
                'data' => json_encode([])
            ],
            [
                'id' => 4,
                'type' => 'select',
                'question' => 'Cargo de contacto',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => "memberPosition",
                'data' => json_encode([])
            ],
            [
                'id' => 5,
                'type' => 'select',
                'question' => 'Proposito',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => null,
                'data' => json_encode($proposito)
            ],
            [
                'id' => 6,
                'type' => 'select',
                'question' => '¿Realizó venta?',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => null,
                'data' => json_encode([
                    [
                        'uuid' => '8cc93d6c-fe19-4a18-8c9e-cd663d809bcc',
                        'text' => 'Si'
                    ],
                    [
                        'uuid' => '20c879fe-c6e3-4408-b205-5e68dfb6c066',
                        'text' => 'No'
                    ],
                ])
            ],
            [
                'id' => 7,
                'type' => 'select',
                'question' => '¿El cliente realizó pago?',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => null,
                'data' => json_encode([
                    [
                        'uuid' => '768a310d-3cf0-47a7-98e8-011f83458934',
                        'text' => 'Si'
                    ],
                    [
                        'uuid' => 'dd06ca73-c511-4034-b38a-a98d98789b0e',
                        'text' => 'No'
                    ],
                ])
            ],
            [
                'id' => 8,
                'type' => 'select',
                'question' => '¿Se obtuvo un logro?',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => null,
                'data' => json_encode([
                    [
                        'uuid' => '96b66a1b-16de-4c3c-88f3-eef69dac6afc',
                        'text' => 'Si'
                    ],
                    [
                        'uuid' => 'b844c7d8-4e58-41f1-b812-05009a65b058',
                        'text' => 'No'
                    ],
                ])
            ],
            [
                'id' => 9,
                'type' => 'text',
                'question' => 'Breve descripción SI obtuvo algún logro',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => null,
                'data' => json_encode([])
            ],
            [
                'id' => 10,
                'type' => 'text',
                'question' => 'Breve observación entorno a la visita',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => null,
                'data' => json_encode([])
            ],
            [
                'id' => 11,
                'type' => 'text',
                'question' => 'Tarea y/o Pendiente',
                'description' => null,
                'questionOfThingsToDo' => 1,
                "tableType" => null,
                'data' => json_encode([])
            ],
            [
                'id' => 12,
                'type' => 'text',
                'question' => 'Hora de Inicio',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => "HoraDeInicio",
                'data' => json_encode([])
            ],
            [
                'id' => 13,
                'type' => 'text',
                'question' => 'Hora de Finalización',
                'description' => null,
                'questionOfThingsToDo' => 0,
                "tableType" => "HoraDeFin",
                'data' => json_encode([])
            ]
        ];

        $survey = Survey::first();

        foreach ($questions as $question) {
            if (!SurveyQuestion::where('id', $question['id'])->first()) {
                $response = new SurveyQuestion;
                $response->type                 = $question['type'];
                $response->question             = $question['question'];
                $response->data                 = $question['data'];
                $response->questionOfThingsToDo = $question['questionOfThingsToDo'];
                $response->tableType            = $question['tableType'];
                $response->survey()->associate($survey);
                $response->save();
            }
        }

    }
}
