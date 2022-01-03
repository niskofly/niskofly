<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Email;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class PageEmails extends MainController
{
    public function index(Request $request)
    {

        $emails = Email::orderBy('created_at', 'desc')->get()->groupBy('type')->map(function ($item) {
            return $item;
        })->toArray();

        $this->seoParams['title'] = 'Список заявок | Компания «Вектор» ';
        $this->seoParams['description'] = '';


        parent::index($request);

        return view('pages/emails', [
            'emails' => $emails,
            'types' => Email::GetTypeEmails()
        ]);
    }

    public function export(Request $request)
    {


        \Maatwebsite\Excel\Facades\Excel::create('"Экспорт заявок"', function ($excel) {


            // Set the title
            $excel->setTitle('Экспорт заявок Вектор');

            // Chain the setters
            $excel->setCreator('Maatwebsite')
                ->setCompany('Вектор');

            foreach (Email::GetTypeEmails() as $code => $Type) {


                $excel->sheet(str_limit($Type, 25), function ($sheet) use ($code) {

                    $emails = Email::get()->groupBy('type')->map(function ($item) {
                        return $item;
                    })->toArray();

                    $i = 2;

                    $sheet->cell('A1', function ($cell) {
                        $cell->setValue('ID');
                    });

                    $sheet->cell('B1', function ($cell) {
                        $cell->setValue('Дата');
                    });

                    $sheet->cell('C1', function ($cell) {
                        $cell->setValue('Имя');
                    });

                    $sheet->cell('D1', function ($cell) {
                        $cell->setValue('Номер телефона');
                    });

                    $sheet->cell('E1', function ($cell) {
                        $cell->setValue('Email');
                    });

                    $sheet->cell('F1', function ($cell) {
                        $cell->setValue('Комментарий');
                    });

                    if ($code == 'product') {
                        $sheet->cell('G1', function ($cell) {
                            $cell->setValue('Товары');
                        });
                    }

                    if ($code == 'share') {
                        $sheet->cell('G1', function ($cell) {
                            $cell->setValue('Акция');
                        });
                    }

                    if ($code == 'project') {
                        $sheet->cell('G1', function ($cell) {
                            $cell->setValue('Готовый комплект');
                        });
                    }

                    if ($code == 'zapchasti') {
                        $sheet->cell('G1', function ($cell) {
                            $cell->setValue('Запчасти');
                        });
                    }

                    if ($code == 'calculateKit') {
                        $sheet->cell('G1', function ($cell) {
                            $cell->setValue('Параметры расчёта');
                        });
                    }

                    foreach ($emails[$code] as $email) {

                        $sheet->cell('A' . $i, function ($cell) use ($email) {
                            $cell->setValue($email['id']);
                        });

                        $sheet->cell('B' . $i, function ($cell) use ($email) {
                            $cell->setValue($email['created_at']);
                        });

                        $sheet->cell('C' . $i, function ($cell) use ($email) {
                            $cell->setValue($email['name']);
                        });

                        $sheet->cell('D' . $i, function ($cell) use ($email) {
                            $cell->setValue($email['phone']);
                        });

                        $sheet->cell('E' . $i, function ($cell) use ($email) {
                            $cell->setValue($email['email']);
                        });

                        $sheet->cell('F' . $i, function ($cell) use ($email) {
                            $cell->setValue($email['comment']);
                        });

                        if ($code == 'product') {

                            if (!empty($email['id_product'])) {
                                $sheet->cell('G' . $i, function ($cell) use ($email) {
                                    $cell->setValue(\App\Models\Product::getInfoExcel($email['id_product']));
                                });
                            }

                            if (!empty($email['id_product_list'])) {
                                $sheet->cell('G' . $i, function ($cell) use ($email) {
                                    $cell->setValue(\App\Models\Product::getInfoExcel($email['id_product_list']));
                                });
                            }

                        }

                        if ($code == 'share') {

                            $sheet->cell('G' . $i, function ($cell) use ($email) {
                                $cell->setValue(\App\Models\Share::getInfoExcel($email['id_share']));
                            });

                        }

                         if ($code == 'project') {

                             $sheet->cell('G' . $i, function ($cell) use ($email) {
                                 $cell->setValue(\App\Models\Email::GetEmailFinishProject($email['id_finished_project']));
                             });

                         }

                        if ($code == 'zapchasti') {

                            $sheet->cell('G' . $i, function ($cell) use ($email) {
                                $cell->setValue("Подробная информация в письме #$email[id]");
                            });

                        }

                        if ($code == 'calculateKit') {

                            $sheet->cell('G' . $i, function ($cell) use ($email) {
                                $cell->setValue("Подробная информация в письме #$email[id]");
                            });

                        }
                        $i++;
                    }

                });
            }


        })->download('xls');
    }
}
