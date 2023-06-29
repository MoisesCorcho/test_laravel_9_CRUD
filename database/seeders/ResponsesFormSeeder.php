<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Visit;

use App\Models\Survey;
use App\Models\Organization;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use Illuminate\Database\Seeder;
use App\Models\SurveyQuestionAnswer;
use App\Http\Requests\Survey\StoreSurveyAnswerRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResponsesFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Vendedor 1:
        $responsesMaira = [
            // Respuesta 1
            [
                "answers" => [
                    "1"=>  ["Si"],
                    "2"=>  ["INSTITUTO DEL RIÑON DE CORDOBA"],
                    "3"=>  ["Juan posada"],
                    "4"=>  ["Compras"],
                    "5"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  ["No"],
                    "9"=>  "",
                    "10"=> "El señor Juan. Posada era el encargado de compras de la clínica Imat hace un tiempo y es quien ahora está en el instituto del riñón",
                    "11"=> "",
                    "12"=> "15:30",
                    "13"=> "16:10"
                ]
            ],

            // Respuesta 2
            /*
            [
                "answers" => [
                    "1"=>  ["FUNDACION OPORTUNIDAD Y VIDA"],
                    "2"=>  ["Rosemberg toro"],
                    "3"=>  ["Pagador - Financiero - Tesorería/Jurídica"],
                    "4"=>  ["Recaudo de cartera / Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Mi objetivo principal en la visita era poder conversar con el gerente el señor Wilmer pinto no se encontraba y me tomé la tarea de escribirle a su número el muy amablemente me respondió diciendo que para este mes realiza el pago doble  de lo que tenía programado",
                    "10"=> "Frecuencia de visita",
                    "11"=> "11:00",
                    "12"=> "12:00"
                ]
            ],

            // Respuesta 3

            [
                "answers" => [
                    "1"=>  ["CENTRO CARDIOINFANTIL  IPS SAS"],
                    "2"=>  ["Margarita watt"],
                    "3"=>  ["Pagador - Financiero - Tesorería/Jurídica"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "El cliente manifiesta que le mantengamos un stock de los salbutamol inhalador ventilan",
                    "10"=> "",
                    "11"=> "09:14",
                    "12"=> "10:14"
                ]
            ],

            // Respuesta 4
            [
                "answers" => [
                    "1"=>  ["MACRO SUMINISTROS DEL SINU S.A.S"],
                    "2"=>  ["Karol soto"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Es un cliente que está dentro de los prospecto nos envío cotización no paso orden de compra estoy trabajando para q convertirlo en cliente potencial para Surtimed",
                    "10"=> "",
                    "11"=> "10:10",
                    "12"=> "11:10"
                ]
            ],

            // Respuesta 5
            [
                "answers" => [
                    "1"=>  ["DIAC LTDA Y/O SALIM MIGUEL HADDAD GARCIA"],
                    "2"=>  ["Wilder blanco"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "El cliente manifiesta que el precio de nosotros está por encima de otros proveedores",
                    "10"=> "",
                    "11"=> "10:00",
                    "12"=> "11:00"
                ]
            ],

            // Respuesta 6
            [
                "answers" => [
                    "1"=>  ["MACRO SUMINISTROS DEL SINU S.A.S"],
                    "2"=>  ["Karol soto"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Es un cliente que está dentro de los prospecto nos envío cotización no paso orden de compra estoy trabajando para q convertirlo en cliente potencial para Surtimed",
                    "10"=> "",
                    "11"=> "11:00",
                    "12"=> "12:00"
                ]
            ],

            // Respuesta 7
            [
                "answers" => [
                    "1"=>  ["MEDISINU IPS S.A.S"],
                    "2"=>  ["Ramiro Benítez"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "El cliente manifiesta que hemos mejorado mucho en cuanto a inventario según los cotizado y en precio somos los mejores dentro de sus proveedores",
                    "10"=> "",
                    "11"=> "14:00",
                    "12"=> "15:00"
                ]
            ],

            // Respuesta 8
            [
                "answers" => [
                    "1"=>  ["CLINICA MATERNO INFANTIL CASA DEL NIÑO LTDA"],
                    "2"=>  ["Patricia Granados"],
                    "3"=>  ["Pagador / Financiero / Tesorería/Jurídica"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "La señora Patricia del área de contabilidad me informa que estamos en los pagos programados",
                    "10"=> "Llamar asistente de gerencia para acordar cita con gerencia",
                    "11"=> "15:00",
                    "12"=> "17:00"
                ]
            ],

            // Respuesta 9
            [
                "answers" => [
                    "1"=>  ["CLINICA ZAYMA S.A.S."],
                    "2"=>  ["Erika González"],
                    "3"=>  ["Pagador / Financiero / Tesorería/Jurídica"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "La señora Erika me informa que está semana cuando entre el recursos nos realizarán un abono",
                    "10"=> "",
                    "11"=> "17:00",
                    "12"=> "18:00"
                ]
            ],

            // Respuesta 10
            [
                "answers" => [
                    "1"=>  ["CLINICA MONTERIA S.A"],
                    "2"=>  ["Hernán Noriega"],
                    "3"=>  ["Farmacia / Regente de Farmacia / Bodega / Almacén"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["Sí"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Recuperacion de cliente",
                    "9"=> "Ofrecerle al señor Hernán Noriega un cupo por 8.000.000 para recuperar nuevamente nuestro vínculo comercial",
                    "10"=> "",
                    "11"=> "09:00",
                    "12"=> "10:20"
                ]
            ],

            // Respuesta 11
            [
                "answers" => [
                    "1"=>  ["FUNDACION OPORTUNIDAD Y VIDA"],
                    "2"=>  ["Rosemberg toro"],
                    "3"=>  ["Pagador / Financiero / Tesorería/Jurídica"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Están a la espera de el recuerdo de cajacopi para poder realizaron el pago del acuerdo pactado",
                    "10"=> "Frecuencia de visita para hablar directamente con gerencia",
                    "11"=> "10:20",
                    "12"=> "11:20"
                ]
            ],

            // Respuesta 12
            [
                "answers" => [
                    "1"=>  ["UROCLINICA DE CORDOBA S.A.S"],
                    "2"=>  ["JOHANNA GONZALEZ"],
                    "3"=>  ["Pagador / Financiero / Tesorería/Jurídica"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "LA ME SEÑORA JOHANNA ME  INFORMA QUE NO PUDIERON REALIZAR PAGO A FIN DE MES PORQ AUN ESTAN A LA ESPERA DE LOS RECUERSOS LOS PROXIMO PAGO ESTA INCLUIDO SURTIMED POR UN VALOR DE 2.626.671",
                    "10"=> "PROGRAMAR VISITA PARA EL DIA LUNES 10 DE OCTUBRE 2022",
                    "11"=> "11:20",
                    "12"=> "12:20"
                ]
            ],

            // Respuesta 13
            [
                "answers" => [
                    "1"=>  ["CENTRAL DE URGENCIAS DE TRAUMA S.A.S"],
                    "2"=>  ["JENNIFER PEREZ"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Obsequios / Cumpleaños/No relacionado con venta o Recaudo"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "EL SEÑOR GERENTE SE ENCONTRABA DE CUMPLEAÑOS LE HICIMOS ENTREGA DE UNA TORTA POR PARTE DE SURTIMED SUMINISTROS S.A.S",
                    "10"=> "",
                    "11"=> "14:00",
                    "12"=> "15:00"
                ]
            ],

            // Respuesta 14
            [
                "answers" => [
                    "1"=>  ["CMP PHARMA"],
                    "2"=>  ["LUBIS POLO"],
                    "3"=>  ["Farmacia / Regente de Farmacia / Bodega / Almacén"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "LA SEÑORA LUBIS ME COMENTA QUE ESTA EN PROGRAMACION DE PAGO",
                    "10"=> "",
                    "11"=> "15:00",
                    "12"=> "17:00"
                ]
            ],

            // Respuesta 15
            [
                "answers" => [
                    "1"=>  ["E.S.E HOSPITAL UNIVERSITARIO DE CARTAGENA"],
                    "2"=>  ["PAOLA VERGARA"],
                    "3"=>  ["Pagador / Financiero / Tesorería/Jurídica"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "LA SEÑORA PAOLA VERGARA TESORERA SE DIRIGIA A UNA REUNION CON GERENCIA Y ME SOLICITO QUE LE ENVIARA CERTIFICACION BANCARIA PARA QUE AL MOMENTO QUE LE AUTORIZARAN EL PAGO",
                    "10"=> "",
                    "11"=> "07:00",
                    "12"=> "08:20"
                ]
            ],

            // Respuesta 16
            [
                "answers" => [
                    "1"=>  ["FUNDACION OPORTUNIDAD Y VIDA"],
                    "2"=>  ["ROSEMBERG TORO"],
                    "3"=>  ["Pagador / Financiero / Tesorería/Jurídica"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "ME DIRIJO HASTA LA IPS PUESTO QUE EL PAGO NO HA ENTRADO A SURTIMED EL SEÑOR ROSEMBERG ME HABIA DADO FECHA Y HORA Y AUN NO HA LLEGADO TRANFERENCIA",
                    "10"=> "",
                    "11"=> "07:00",
                    "12"=> "08:10"
                ]
            ],

            // Respuesta 17
            [
                "answers" => [
                    "1"=>  ["CLINICA DE REFERENCIA"],
                    "2"=>  ["JENNIFER PEREZ"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Obsequios / Cumpleaños/No relacionado con venta o Recaudo"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "ENTREGA DE DOCUMENTOS DE SOLICUTD DE CREDITO PARA APERTURA NUEVO CLIENTE",
                    "9"=> "",
                    "10"=> "RESPUESTA CUPO APROBADO",
                    "11"=> "14:00",
                    "12"=> "16:00"
                ]
            ],

            // Respuesta 18
            [
                "answers" => [
                    "1"=>  ["MEDICINA INTEGRAL S.A."],
                    "2"=>  ["MANUEL RAMOS"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "",
                    "9"=> "EL SEÑOR MANUEL SE ENCONTRABA OCUPADO EN DISPENSACION",
                    "10"=> "PROGRAMAR NUEVA VISITA",
                    "11"=> "14:00",
                    "12"=> "15:00"
                ]
            ],

            // Respuesta 19
            [
                "answers" => [
                    "1"=>  ["FUNDACION OPORTUNIDAD Y VIDA"],
                    "2"=>  ["ROSEMBERG TORO"],
                    "3"=>  ["Pagador / Financiero / Tesorería/Jurídica"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "REALIZARON PAGO DE FACTURAS  4286-4631 POR UN VALOR DE 2.266.009",
                    "10"=> "ESPERAR TIEMPOS ACH DONDE SE REFLEJA EL PAGO",
                    "11"=> "07:00",
                    "12"=> "09:00"
                ]
            ],

            // Respuesta 20
            [
                "answers" => [
                    "1"=>  ["CLINICA CARDIOVASCULAR DEL CARIBE S.A.S"],
                    "2"=>  ["KAREN MESTRA"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "LA SEÑORA KAREN SE ENCONTRABA OCUPADA NO PUDO ASTENDER MI VISITA",
                    "10"=> "PROGRAMAR VISITA PARA PROXIMA SEMANA",
                    "11"=> "09:00",
                    "12"=> "09:20"
                ]
            ]
            */
        ];

        $visitsMaira = [

            // Visita 1
            [
                'visitDate' => '2022-10-07',
                'status'    => 'visited',
            ],

            /*
            // Visita 2
            [
                'visitDate' => '2022-10-07',
                'status'    => 'visited',
            ],

            // Visita 3
            [
                'visitDate' => '2022-10-07',
                'status'    => 'visited',
            ],

            // Visita 4
            [
                'visitDate' => '2022-10-07',
                'status'    => 'visited',
            ],

            // Visita 5
            [
                'visitDate' => '2022-10-06',
                'status'    => 'visited',
            ],

            // Visita 6
            [
                'visitDate' => '2022-10-06',
                'status'    => 'visited',
            ],

            // Visita 7
            [
                'visitDate' => '2022-10-06',
                'status'    => 'visited',
            ],

            // Visita 8
            [
                'visitDate' => '2022-10-06',
                'status'    => 'visited',
            ],

            // Visita 9
            [
                'visitDate' => '2022-10-05',
                'status'    => 'visited',
            ],

            // Visita 10
            [
                'visitDate' => '2022-10-05',
                'status'    => 'visited',
            ],

            // Visita 11
            [
                'visitDate' => '2022-10-05',
                'status'    => 'visited',
            ],

            // Visita 12
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ],

            // Visita 13
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ],

            // Visita 14
            [
                'visitDate' => '2022-10-03',
                'status'    => 'visited',
            ],

            // Visita 15
            [
                'visitDate' => '2022-10-03',
                'status'    => 'visited',
            ],

            // Visita 16
            [
                'visitDate' => '2022-09-30',
                'status'    => 'visited',
            ],

            // Visita 17
            [
                'visitDate' => '2022-09-28',
                'status'    => 'visited',
            ],

            // Visita 18
            [
                'visitDate' => '2022-09-27',
                'status'    => 'visited',
            ],

            // Visita 19
            [
                'visitDate' => '2022-09-27',
                'status'    => 'visited',
            ],

            // Visita 20
            [
                'visitDate' => '2022-09-26',
                'status'    => 'visited',
            ]
            */
        ];

        //Vendedor 2:
        $responsesHector = [
            // Respuesta 1
            [
                "answers" => [
                    "1"=>  ["Si"],
                    "2"=>  ["E.S.E. VIDA SINU"],
                    "3"=>  ["Karen Peña"],
                    "4"=>  ["Farmacia / Regente de Farmacia / Bodega / Almacén"],
                    "5"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "6"=>  ["Sí"],
                    "7"=>  ["No"],
                    "8"=>  ["Sí"],
                    "9"=>  "Se acordaron los productos que estaban pendientes para hacer la facturación que nos hace falta del contrato No 051",
                    "10"=> "",
                    "11"=> "Organizar el archivo en Excel para poder hacer los cruces correspondientes y hacer la facturación",
                    "12"=> "16:10",
                    "13"=> "17:10"
                ]
            ],
            /*
            // Respuesta 2
            [
                "answers" => [
                    "1"=>  ["E.S.E. VIDA SINU"],
                    "2"=>  ["E.S.E. VIDASINU"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Organizar las remisiones entregadas y hacer la relación para poder hacer la factura correspondiente del saldo que tenemos en el contrato No 051",
                    "10"=> "Organizar la factura con Claudia posterior a la autorización de Vidasinu ",
                    "11"=> "14:00",
                    "12"=> "18:00"
                ]
            ],

            // Respuesta 3
            [
                "answers" => [
                    "1"=>  ["E.S.E. VIDA SINU"],
                    "2"=>  ["Leidy Montesino"],
                    "3"=>  ["Gerente / Administrador"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Hablé con la Dra Leidy para preguntarle sobre nuevos procesos de contratación de medicamentos y dispositivos y consultarle sobre el contrato del Instrumental Odontológico.",
                    "10"=> "Organizar los documentos para que apenas salga la convocatoria para el contrato del Instrumental poder presentar de manera oportuna.",
                    "11"=> "09:00",
                    "12"=> "09:25"
                ]
            ],

            // Respuesta 4
            [
                "answers" => [
                    "1"=>  ["E.S.E. VIDA SINU"],
                    "2"=>  ["Karen Peña"],
                    "3"=>  ["Farmacia / Regente de Farmacia / Bodega / Almacén"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["Sí"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se hizo la legalización y/o radicación de las últimas facturas correspondientes al contrato No 051 de medicamentos y dispositivos médicos",
                    "9"=> "",
                    "10"=> "Organizar la cuenta de cobro final para legalizar con Dina.",
                    "11"=> "10:00",
                    "12"=> "10:25"
                ]
            ],

                // Respuesta 5
                [
                "answers" => [
                    "1"=>  ["E.S.E. VIDA SINU"],
                    "2"=>  ["E.S.E. VIDASINU"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Organizar el archivo de los productos de Instrumental Odontológico con los costos y el proveedor al que se le debe pedir cada producto y se le hizo el envío al área de compras para que inicie con su proceso.",
                    "9"=> "",
                    "10"=> "Estar al pendiente con el área de compras para que los productos nos lleguen de manera oportuna y así hacer las entregas a nuestro cliente en los tiempos estimados",
                    "11"=> "10:00",
                    "12"=> "12:30"
                ]
            ],

                // Respuesta 6
                [
                "answers" => [
                    "1"=>  ["E.S.E. VIDA SINU"],
                    "2"=>  ["E.S.E. VIDASINU"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Terminar de organizar las dos propuestas de las OPS que manejaríamos con Vidasinú para el contrato de PIC que ellos manejarán con la alcaldía.",
                    "9"=> "",
                    "10"=> "Estar al pendiente de cuando el área jurídica saque las OPS para hacer el despacho y facturación de los productos.",
                    "11"=> "10:00",
                    "12"=> "12:00"
                ]
            ],

            // Respuesta 7
            [
                "answers" => [
                    "1"=>  ["E.S.E. CAMU SAN PELAYO"],
                    "2"=>  ["Harving Espitia"],
                    "3"=>  ["Gerente / Administrador"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Estuve en la alcaldía de San Pelayo tratando de reunirme con el señor alcalde pero no me atendieron.",
                    "10"=> "Seguir haciendo seguimiento y visitas constantes hasta que nos cancelen el total de la cartera.",
                    "11"=> "14:00",
                    "12"=> "16:00"
                ]
            ],

                // Respuesta 8
                [
                "answers" => [
                    "1"=>  ["LABORATORIO CLINICO ANIMAL ELVELAS"],
                    "2"=>  ["Jorge Gonzalez"],
                    "3"=>  ["Gerente / Administrador"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se hizo la presentación y muestra de nuestro portafolio de productos y el señor Jorge se muestra bastante interesado y me notifica que ya nos había hecho algunas compras.",
                    "9"=> "Me comenta el señor Jorge que no le gusta tener muchos proveedores, que siempre le ha gustado comprar los productos que necesita en una sola parte y que si nosotros le podemos garantizar tenerle la disponibilidad él se fideliza con nosotros, tanto las compras que maneja con el laboratorio como las compras que se realizarían a nombre de la Universidad de Córdoba.",
                    "10"=> "Enviar documentos para solicitud de crédito y catálogo de los productos que él más maneja.",
                    "11"=> "14:00",
                    "12"=> "14:50"
                ]
            ],

            // Respuesta 9
            [
                "answers" => [
                    "1"=>  ["E.S.E. CAMU SAN PELAYO"],
                    "2"=>  ["Eduar Orozco"],
                    "3"=>  ["Gerente / Administrador"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Pude hablar con el señor Eduar Orozco y este me manifiesta que cuando ingresen los recursos del giro nos estarían haciendo un nuevo abono a la cartera.",
                    "9"=> "",
                    "10"=> "Estar al pendiente del ingreso de los giros para seguir haciendo monitoreo a la cartera hasta que logremos sacar el pago.",
                    "11"=> "14:00",
                    "12"=> "15:00"
                ]
            ],

            // Respuesta 10
            [
                "answers" => [
                    "1"=>  ["E.S.E. VIDA SINU"],
                    "2"=>  ["Ingrid Arcia"],
                    "3"=>  ["Pagador / Financiero / Tesorería/Jurídica"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se hizo entrega de una cotización de las que sirven como contrapropuestas en la cual habíamos tenido un error y hubo que corregirla.",
                    "9"=> "",
                    "10"=> "Hacer seguimiento al proceso de contratación para poder sacar el contrato lo antes posible para poder facturar todo lo que hemos despachado en remisión.",
                    "11"=> "09:00",
                    "12"=> "09:30"
                ]
            ],

            // Respuesta 11
            [
                "answers" => [
                    "1"=>  ["SERVICIO NACIONAL DE APRENDIZAJE - SENA"],
                    "2"=>  ["José Samir Obagi"],
                    "3"=>  ["Farmacia / Regente de Farmacia / Bodega / Almacén"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "",
                    "9"=> "Hablando con el señor José Samir me expresa que no han podido hacer el informe final de la entrega porque estaban en un proceso de cambio en el software y en los usuarios de las personas y por lo tanto el proceso estaba un poco retrasado, pero que en los próximos días todo quedaría solucionado.",
                    "10"=> "Seguir haciendo gestión tanto con el señor José Samir como con la señora Ludys para el pronto pago de lo pendiente.",
                    "11"=> "15:00",
                    "12"=> "16:00"
                ]
            ],

            // Respuesta 12
            [
                "answers" => [
                    "1"=>  ["DISTRISERVICIOS Y SUMINISTROS DEL BAJO SINU S.A.S"],
                    "2"=>  ["Alvaro Ortega Sibaja"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Se le explicó a Álvaro la diferencia y el porqué se da la diferencia que presentamos en estos momentos en la cartera y este me regala el número de celular de la contadora de ellos para que se pusieran de acuerdo ambas áreas contables y así solucionar la situación.",
                    "10"=> "Estar al pendiente de la solución de las áreas contables y tratar de llegar a un buen acuerdo.",
                    "11"=> "15:00",
                    "12"=> "15:30"
                ]
            ],

            // Respuesta 13
            [
                "answers" => [
                    "1"=>  ["E.S.E. CAMU SANTA TERESITA"],
                    "2"=>  ["Lenin Doria Burgos"],
                    "3"=>  ["Gerente / Administrador"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Logré que el Dr. Lenin Doria me atendiera, pero este  me informa que en el momento toda la contratación que tiene la E.S.E. la está manejando por medio de Coodescor y que los demás productos son comprados a Distriservicios.",
                    "9"=> "Noto que en el momento no tenemos oportunidad de venderle directamente al Camu Santa Teresita, debemos seguir manejando y afianzando las ventas con Distriservicios.",
                    "10"=> "",
                    "11"=> "09:00",
                    "12"=> "10:00"
                ]
            ],

            // Respuesta 14
            [
                "answers" => [
                    "1"=>  ["SOLUCIONES MEDICAS DEL SINU S.A.S"],
                    "2"=>  ["Monica Ortega"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Haciendo recordación a Mónica de nuestros productos me informa que en el momento tiene disponibilidad de la mayoría de los productos que ellos manejan como tal, pero que si llega a necesitar algo ella me pregunta enseguida.",
                    "10"=> "Seguir haciendo seguimiento al cliente para fortalecer las ventas",
                    "11"=> "10:00",
                    "12"=> "10:20"
                ]
            ],

            // Respuesta 15
            [
                "answers" => [
                    "1"=>  ["SOLUCIONES MEDICAS DEL SINU S.A.S"],
                    "2"=>  ["Marta Nieves"],
                    "3"=>  ["Pagador / Financiero / Tesorería/Jurídica"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Me informa la señora Marta que en cuanto le ingresaran los recursos a ellos de algunos pagos que tienen pendientes del hospital San Vicente de Paul ellos nos estarían haciendo el pago de la cartera que tenemos.",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "10:20",
                    "12"=> "10:30"
                ]
            ],

                // Respuesta 16
                [
                "answers" => [
                    "1"=>  ["E.S.E CAMU IRIS LOPEZ DURAN"],
                    "2"=>  ["María Angelica Blanco"],
                    "3"=>  ["Pagador / Financiero / Tesorería/Jurídica"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Hablando con María Angelica (secretaria de gerencia) me informa que la gerente no estaba en el Camu. Entonces, me regaló su número de celular para que la llamara en los próximos días y así apartar una cita con la Dra Eliana.",
                    "10"=> "Llamar en los próximos días para apartar la cita.",
                    "11"=> "10:40",
                    "12"=> "10:50"
                ]
            ],

            // Respuesta 17
            [
                "answers" => [
                    "1"=>  ["E.S.E CAMU IRIS LOPEZ DURAN"],
                    "2"=>  ["Francisco Javier López"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "Me dice Francisco que las cosas por la E.S.E. han estado pesadas, que actualmente el proveedor que les está suministrando es un recomendado político pero que la Dra Eliana quiere cambiar ese proveedor, que apenas él escuche algo nos apoya para que seamos nosotros quienes empecemos a hacer el suministro.",
                    "10"=> "",
                    "11"=> "11:00",
                    "12"=> "11:15"
                ]
            ],

            // Respuesta 18
            [
                "answers" => [
                    "1"=>  ["RADIOLOGOS ASOCIADOS DEL BAJO SINU S.A.S."],
                    "2"=>  ["Astrid Argel"],
                    "3"=>  ["Gerente / Administrador"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  "",
                    "9"=> "En conversación con Astrid me informa que ya ellos son cliente de nosotros y que los viene atendiendo mi compañera Verónica, de igual forma, yo le recordé nuestro portafolio de productos y/o servicios.",
                    "10"=> "",
                    "11"=> "11:15",
                    "12"=> "11:30"
                ]
            ],

            // Respuesta 19
            [
                "answers" => [
                    "1"=>  ["E.S.E. CAMU DEL PRADO"],
                    "2"=>  ["Ana María Doria"],
                    "3"=>  ["Gerente / Administrador"],
                    "4"=>  ["Recaudo de cartera /Acuerdos de Pago"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Me informa la señora Ana María que si el dinero que les va a girar la alcaldía no les alcanza a ingresar antes de que llegue el giro ellos nos hacen el pago total del contrato con los recursos que les ingresen por el giro directo.",
                    "9"=> "",
                    "10"=> "Seguir haciendo seguimiento constante hasta lograr el pago de los recursos.",
                    "11"=> "11:30",
                    "12"=> "12:30"
                ]
            ],

            // Respuesta 20
            [
                "answers" => [
                    "1"=>  ["E.S.E. CAMU DEL PRADO"],
                    "2"=>  ["Ana María Doria"],
                    "3"=>  ["Gerente / Administrador"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Me informa la señora Ana María que existe una gran posibilidad de que seamos nosotros quienes obtengamos el nuevo contrato de suministro hasta finalizar este año.",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "12:30",
                    "12"=> "12:40"
                ]
            ]
            */
        ];

        $visitsHector = [

            // Visita 1
            [
                'visitDate' => '2022-08-01',
                'status'    => 'visited',
            ],
            /*
            // Visita 2
            [
                'visitDate' => '2022-08-01',
                'status'    => 'visited',
            ],

            // Visita 3
            [
                'visitDate' => '2022-08-03',
                'status'    => 'visited',
            ],

            // Visita 4
            [
                'visitDate' => '2022-08-03',
                'status'    => 'visited',
            ],

            // Visita 5
            [
                'visitDate' => '2022-08-03',
                'status'    => 'visited',
            ],

            // Visita 6
            [
                'visitDate' => '2022-09-26',
                'status'    => 'visited',
            ],

            // Visita 7
            [
                'visitDate' => '2022-09-26',
                'status'    => 'visited',
            ],

            // Visita 8
            [
                'visitDate' => '2022-10-03',
                'status'    => 'visited',
            ],

            // Visita 9
            [
                'visitDate' => '2022-10-03',
                'status'    => 'visited',
            ],

            // Visita 10
            [
                'visitDate' => '2022-10-03',
                'status'    => 'visited',
            ],

            // Visita 11
            [
                'visitDate' => '2022-10-03',
                'status'    => 'visited',
            ],

            // Visita 12
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ],

            // Visita 13
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ],

                // Visita 14
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ],

            // Visita 15
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ],

            // Visita 16
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ],

            // Visita 17
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ],

                // Visita 18
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ],

            // Visita 19
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ],

            // Visita 20
            [
                'visitDate' => '2022-10-04',
                'status'    => 'visited',
            ]
            */
        ];

        //Vendedor 3:
        $responsesVeronica = [
            // Respuesta 1
            [
                "answers" => [
                    "1"=>  ["No"],
                    "2"=>  ["SOLUCIONES DIAGNOSTICAS DEL RIO S.A.S"],
                    "3"=>  ["Katherine Salas"],
                    "4"=>  ["Compras"],
                    "5"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "6"=>  ["No"],
                    "7"=>  ["No"],
                    "8"=>  ["No"],
                    "9"=>  "",
                    "10"=> "Presentación con encargada de compras",
                    "11"=> "Enviar portafolios o propuesta comer por correo suministrado",
                    "12"=> "07:00",
                    "13"=> "08:00"
                ]
            ],
            /*
            // Respuesta 2
            [
                "answers" => [
                    "1"=>  ["MULTISUMINISTROS Y ASESORIAS S.A.S."],
                    "2"=>  ["Lina Correa"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos/ Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Establecer contacto con persona encargada de compras",
                    "9"=> "",
                    "10"=> "Pendiente por revisar agotados y generar pedido",
                    "11"=> "14:00",
                    "12"=> "15:00"
                ]
            ],

            // Respuesta 3
            [
                "answers" => [
                    "1"=>  ["KIDS CENTER UNIDAD PEDIATRICA S.A.S"],
                    "2"=>  ["Ingrid Oviedo"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se estableció contacto con encargada de compras",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "09:00",
                    "12"=> "10:30"
                ]
            ],

            // Respuesta 4
            [
                "answers" => [
                    "1"=>  ["FUNDACION LA MANO DE DIOS"],
                    "2"=>  ["Denis Madera"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se estableció contacto con persona encargada de compras",
                    "9"=> "",
                    "10"=> "Seguimiento frecuente",
                    "11"=> "15:10",
                    "12"=> "16:40"
                ]
            ],

            // Respuesta 5
            [
                "answers" => [
                    "1"=>  ["ESPECIALISTAS ASOCIADOS S.A"],
                    "2"=>  ["Lucia Ayazo"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se estableció contacto con persona encargada de compras, cliente solicita producto que en la actualidad está agotado",
                    "9"=> "",
                    "10"=> "Diligenciar producto pendiente para generar pedido",
                    "11"=> "14:10",
                    "12"=> "16:10"
                ]
            ],

            // Respuesta 6
            [
                "answers" => [
                    "1"=>  ["NORELA VAZQUEZ MONTOYA"],
                    "2"=>  ["Norela Vasquez"],
                    "3"=>  ["Gerente / Administrador"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["Sí"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se generó pedido",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "14:05",
                    "12"=> "15:05"
                ]
            ],

            // Respuesta 7
            [
                "answers" => [
                    "1"=>  ["VISALUD S.A.S"],
                    "2"=>  ["Nelly Argumedo"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se estableció contacto con persona encargada de compras",
                    "9"=> "Cliente estará pasando pedido antes del 7 de agosto",
                    "10"=> "Recordar al cliente pedido pendiente",
                    "11"=> "07:05",
                    "12"=> "08:35"
                ]
            ],

            // Respuesta 8
            [
                "answers" => [
                    "1"=>  ["SUMIDROGAS S.A.S"],
                    "2"=>  ["Jorge Fernando"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se estableció contacto con persona encargada de compras",
                    "9"=> "Encargado de compras manifiesta que te usará inventario para establecer pedido",
                    "10"=> "Seguimiento al cliente, recordándole pedido pendiente",
                    "11"=> "09:00",
                    "12"=> "10:10"
                ]
            ],

            // Respuesta 9
            [
                "answers" => [
                    "1"=>  ["LABORATORIO CLINICO DUNALAB I.P.S S.A.S"],
                    "2"=>  ["Diana Tamayo"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se estableció contacto con persona encargada de compras",
                    "9"=> "Cliente solicita portafolio por vía e-mail",
                    "10"=> "Enviar portafolios",
                    "11"=> "10:00",
                    "12"=> "11:00"
                ]
            ],

            // Respuesta 10
            [
                "answers" => [
                    "1"=>  ["MARIA PATRICIA SILVA ALEAN"],
                    "2"=>  ["Margarita Ospina"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se estableció contacto con persona encargada de compras",
                    "9"=> "",
                    "10"=> "Seguimiento a clientes",
                    "11"=> "10:00",
                    "12"=> "10:45"
                ]
            ],

            // Respuesta 11
            [
                "answers" => [
                    "1"=>  ["CENTRO AVANZADO DE ATENCION EN TRATAMIENTOS DE HERIDAS S.A.S"],
                    "2"=>  ["Sofia Torralbo"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["Sí"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Cliente realizó pedido",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "10:45",
                    "12"=> "11:15"
                ]
            ],

            // Respuesta 12
            [
                "answers" => [
                    "1"=>  ["INVERSIONES DISTRIAGRO S.A.S"],
                    "2"=>  ["Keila"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se estableció contacto con persona encargada de compras y se entregó acuerdo de pago",
                    "9"=> "Cliente manifiesta que realizará pago está semana y posteriormente realizará pedido",
                    "10"=> "Enviar portafolio de productos",
                    "11"=> "14:15",
                    "12"=> "15:15"
                ]
            ],

            // Respuesta 13
            [
                "answers" => [
                    "1"=>  ["ENTRE PERROS Y GATOS PETSHOP Y CONSULTA VERTERINARIA Y/O GAB"],
                    "2"=>  ["Gabriel Alvarez"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["Sí"],
                    "6"=>  ["Sí"],
                    "7"=>  ["Sí"],
                    "8"=>  "Cliente realizó compra de contado",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "15:15",
                    "12"=> "16:15"
                ]
            ],

            // Respuesta 14
            [
                "answers" => [
                    "1"=>  ["CENTRAL DE COOPERATIVAS DE SERVICIOS INTEGRALES DE CORDOBA LOS OLIVOS"],
                    "2"=>  ["Tulia Muñoz"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["Sí"],
                    "6"=>  ["Sí"],
                    "7"=>  ["Sí"],
                    "8"=>  "Compra de contado",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "16:15",
                    "12"=> "16:45"
                ]
            ],

            // Respuesta 15
            [
                "answers" => [
                    "1"=>  ["CLINICA VETERINARIA MOMO"],
                    "2"=>  ["Victoria"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Hacer la respectiva presentación con la persona encargada de compras",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "16:45",
                    "12"=> "17:45"
                ]
            ],

            // Respuesta 16
            [
                "answers" => [
                    "1"=>  ["CENTRO VETERINARIO ALEAN LORA"],
                    "2"=>  ["Viviana Doria"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["Sí"],
                    "6"=>  ["Sí"],
                    "7"=>  ["Sí"],
                    "8"=>  "Cliente realiza compra de contado",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "09:30",
                    "12"=> "10:30"
                ]
            ],

            // Respuesta 17
            [
                "answers" => [
                    "1"=>  ["MONTERRICO VETERIANARIA Y SPA Y/O JUAN SALLEG TABOADA"],
                    "2"=>  ["Julieth florez"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Se estableció contacto con persona encargada de compras",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "10:30",
                    "12"=> "12:00"
                ]
            ],

            // Respuesta 18
            [
                "answers" => [
                    "1"=>  ["SCANER S.A"],
                    "2"=>  ["Rubiela Diaz"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["Sí"],
                    "6"=>  ["Sí"],
                    "7"=>  ["Sí"],
                    "8"=>  "Cliente Realiza compra de contado",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "14:00",
                    "12"=> "15:00"
                ]
            ],

            // Respuesta 19
            [
                "answers" => [
                    "1"=>  ["COMERCIALIZADORA BETT- MEDICAL Y/O JORGE LUIS BETTIN ROJAS"],
                    "2"=>  ["Jorge Betin"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Presentación ante persona encargada",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "15:00",
                    "12"=> "16:00"
                ]
            ],

            // Respuesta 20
            [
                "answers" => [
                    "1"=>  ["CENTRO OFTALMOLOGICO DEL SINU S.A.S"],
                    "2"=>  ["Jennifer Paternina"],
                    "3"=>  ["Compras"],
                    "4"=>  ["Vender / Promoción de productos / Documentos de crédito"],
                    "5"=>  ["No"],
                    "6"=>  ["No"],
                    "7"=>  ["Sí"],
                    "8"=>  "Presentación ante persona encargada de compras",
                    "9"=> "",
                    "10"=> "",
                    "11"=> "16:00",
                    "12"=> "17:00"
                ]
            ]
            */
        ];

        $visitsVeronica = [

            // Visita 1
            [
                'visitDate' => '2022-08-01',
                'status'    => 'visited',
            ],
            /*
            // Visita 2
            [
                'visitDate' => '2022-08-01',
                'status'    => 'visited',
            ],

            // Visita 3
            [
                'visitDate' => '2022-08-02',
                'status'    => 'visited',
            ],

            // Visita 4
            [
                'visitDate' => '2022-08-02',
                'status'    => 'visited',
            ],

            // Visita 5
            [
                'visitDate' => '2022-08-02',
                'status'    => 'visited',
            ],

            // Visita 6
            [
                'visitDate' => '2022-08-02',
                'status'    => 'visited',
            ],

            // Visita 7
            [
                'visitDate' => '2022-08-03',
                'status'    => 'visited',
            ],

            // Visita 8
            [
                'visitDate' => '2022-08-03',
                'status'    => 'visited',
            ],

            // Visita 9
            [
                'visitDate' => '2022-08-03',
                'status'    => 'visited',
            ],

            // Visita 10
            [
                'visitDate' => '2022-08-04',
                'status'    => 'visited',
            ],

            // Visita 11
            [
                'visitDate' => '2022-08-04',
                'status'    => 'visited',
            ],

            // Visita 12
            [
                'visitDate' => '2022-08-08',
                'status'    => 'visited',
            ],

            // Visita 13
            [
                'visitDate' => '2022-08-08',
                'status'    => 'visited',
            ],

            // Visita 14
            [
                'visitDate' => '2022-08-08',
                'status'    => 'visited',
            ],

            // Visita 15
            [
                'visitDate' => '2022-08-09',
                'status'    => 'visited',
            ],

            // Visita 16
            [
                'visitDate' => '2022-08-09',
                'status'    => 'visited',
            ],

            // Visita 17
            [
                'visitDate' => '2022-08-09',
                'status'    => 'visited',
            ],

            // Visita 18
            [
                'visitDate' => '2022-08-09',
                'status'    => 'visited',
            ],

            // Visita 19
            [
                'visitDate' => '2022-08-09',
                'status'    => 'visited',
            ],

            // Visita 20
            [
                'visitDate' => '2022-08-09',
                'status'    => 'visited',
            ]
            */
        ];


        $survey = Survey::query()->where('title', 'Surtimed - clientes')->first();

        //Llenamos visitas del vendedor Kaled
        $seller = User::query()->where('dni', '1005478123')->first(); //Kaled
        foreach ($visitsMaira as $key => $visit) {
            // dd($responsesMaira[$key]['answers'][2][0]);

            try {
                $organization = Organization::query()->where('name', $responsesMaira[$key]['answers'][2][0])->first();
            } catch (\Throwable $th) {
                dd(
                    'Maira', 'organizacion', $visit, $key, $visitsHector, $th
                );
            }


            try {
                $response = new Visit();
                $response->visitDate = $visit['visitDate'];
                $response->status    = $visit['status'];
                $response->seller()->associate($seller);
                $response->organization()->associate($organization);
                $response->survey()->associate($survey);
                $response->save();
            } catch (\Throwable $th) {
                dd(
                    'Maira', 'visita', $responsesMaira[$key]['answers'][2][0], $key, $th
                );
            }
        }

        // LLenamos las respuestas al formulario hecho en los seeders de Forms
        foreach ($responsesMaira as $key1 => $res) {
            $this->storeAnswer($res, 1, $visitsMaira[$key1]['visitDate'], $seller);
        }


        //Llenamos visitas del vendedor Jose Alvarez
        $seller2 = User::query()->where('dni', '1005472347')->first(); //Jose

        foreach ($visitsHector as $key => $visit) {

            try {
                $organization = Organization::query()->where('name', $responsesHector[$key]['answers'][2][0])->first();
            } catch (\Throwable $th) {
                dd(
                    'hector', 'organizacion', $visit, $key, $visitsHector, $th
                );
            }

            try {
                $response = new Visit();
                $response->visitDate = $visit['visitDate'];
                $response->status    = $visit['status'];
                $response->seller()->associate($seller2);
                $response->organization()->associate($organization);
                $response->survey()->associate($survey);
                $response->save();
            } catch (\Throwable $th) {
                dd(
                    'Hector', 'visita', $seller, $responsesHector[$key]['answers'][2][0], $key, $th
                );
            }
        }

        // LLenamos las respuestas al formulario hecho en los seeders de Forms
        foreach ($responsesHector as $key2 => $res2) {
            $this->storeAnswer($res2, 1, $visitsHector[$key2]['visitDate'], $seller2);
        }


        $seller3 = User::query()->where('dni', '1005479536')->first(); //Ramiro
        foreach ($visitsVeronica as $key => $visit) {

            try {
                $organization = Organization::query()->where('name', $responsesVeronica[$key]['answers'][2][0])->first();
            } catch (\Throwable $th) {
                dd(
                    'Veronica', 'organizacion', $visit, $key, $visitsHector, $th
                );
            }


            try {
                $response = new Visit();
                $response->visitDate = $visit['visitDate'];
                $response->status    = $visit['status'];
                $response->seller()->associate($seller3);
                $response->organization()->associate($organization);
                $response->survey()->associate($survey);
                $response->save();

            } catch (\Throwable $th) {
                dd(
                    'Veronica', 'visita', $responsesVeronica[$key]['answers'][2][0], $key, $th
                );
            }
        }

        // LLenamos las respuestas al formulario hecho en los seeders de Forms
        foreach ($responsesVeronica as $key3 => $res3) {
            $this->storeAnswer($res3, 1, $visitsVeronica[$key3]['visitDate'], $seller3);
        }

    }

    public function storeAnswer($request, $id, $date, $seller)
    {
        // $id = 1;
        $validated = $request;
        $survey = Survey::find($id);

        //Almacenamos cuando se guardó la respuesta y a cual survey pertenece
        $surveyAnswer = SurveyAnswer::create([
            'date'   => $date,
            'surveyId'  => $survey->id,
            'sellerId' => $seller->id
        ]);

        //Guardamos las respuestas
        foreach ($validated['answers'] as $questionId => $answer) {

            $question = SurveyQuestion::where(['id' => $questionId, 'surveyId' => $survey->id])->get();

            if (!$question) {
                return response()->json([
                    403,
                    'No existe la pregunta.'
                ]);
            }

            $data = [
                'answer'           => is_array($answer) ? json_encode($answer, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ) : $answer,
                'surveyQuestionId' => $questionId,
                'surveyAnswerId'   => $surveyAnswer->id,
                'state'            => 0
            ];

            try {
                $question[0]['questionOfThingsToDo'];
            } catch (\Throwable $th) {
                dd(
                    'id del formulario' , $id,
                    'Objeto pregunta' , $question ,
                    'Id de la pregunta' , $questionId ,
                    'Respuesta del id pregunta' , $answer,
                    'Error',$th,
                    'Request' , $validated
                );
            }

            //Si la respuesta es para una pregunta de tareas pendientes, le cambiamos el estado a 1 (activa)
            if ( $question[0]['questionOfThingsToDo'] == 1 and strlen(trim($answer)) != 0) {
                $data['state'] = 1;
                SurveyQuestionAnswer::create($data);
            } else {
                SurveyQuestionAnswer::create($data);
            }

        }
        return response()->json([
            200,
            'Respuesta registrada satisfactoriamente.'
        ]);
    }
}
