<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FilippoToso\PdfWatermarker\Support\Pdf;
use FilippoToso\PdfWatermarker\Facades\ImageWatermarker;
use FilippoToso\PdfWatermarker\Watermarks\ImageWatermark;
use FilippoToso\PdfWatermarker\PdfWatermarker;
use FilippoToso\PdfWatermarker\Facades\TextWatermarker;
use FilippoToso\PdfWatermarker\Support\Position;

use \Carbon\Carbon;
use DNS1D;
use DNS2D;

class TestingController extends Controller
{
    public function testing_pdf()
    {
        // Specify path to the existing pdf
        $pdf = new Pdf(public_path('berkas/SOPIT.pdf'));
        // Specify path to image. The image must have a 96 DPI resolution.
        $watermark = new ImageWatermark(public_path('berkas/Terkendali-Rahasia-Edit.png'));
        // Create a new watermarker
        $watermarker = new PDFWatermarker($pdf, $watermark);
        
        $position = new Position(Position::BOTTOM_CENTER, 0, 0);
        $watermarker->setPosition($position);
        // Save the new PDF to its specified location
        $watermarker->save(public_path('berkas/output.pdf'));
    }

    public function testing2(Request $request)
    {
        // return ImageWatermarker::input(public_path('berkas/SOPIT.pdf'))
        //                     ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
        //                     ->output(public_path('berkas/output.pdf'))
        //                     ->position(Position::BOTTOM_CENTER, -50, -10)
        //                     ->asBackground()
        //                     ->resolution(300)
        //                     ->save();

        $barcode = \Storage::disk('barcode')->put('test3.png',base64_decode(DNS2D::getBarcodePNG("Dokumen telah diverifikasi oleh sistem tanggal ".Carbon::now()->isoFormat('dddd, D MMMM YYYY'), "QRCODE", 6,6)));
        ImageWatermarker::input(public_path('berkas/SOPIT.pdf'))
                        // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
                        // ->watermark(public_path('berkas/Terkendali-Rahasia-barcode.png'))
                        ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
                        ->output(public_path('berkas/output.pdf'))
                        ->position(Position::BOTTOM_CENTER, 5.5, -2)
                        // ->asBackground()
                        // ->pageRange(3, 4)
                        ->resolution(300) // 300 dpi
                        ->save();
        
        // barcode stamp
        ImageWatermarker::input(public_path('berkas/output.pdf'))
                        // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
                        ->watermark(public_path('barcode/test3.png'))
                        // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
                        ->output(public_path('berkas/output1.pdf'))
                        ->position(Position::BOTTOM_CENTER, -92, -5)
                        // ->asBackground()
                        // ->pageRange(3, 4)
                        ->resolution(300) // 300 dpi
                        ->save();

        // return ImageWatermarker::input(public_path('berkas/IT.PPIC.SOP.12.pdf'))
        //                 // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
        //                 ->watermark(public_path('berkas/Terkendali-Rahasia-barcode.png'))
        //                 // ->watermark(public_path('berkas/Terkendali-Rahasia-Edit.png'))
        //                 ->output(public_path('berkas/IT.PPIC.SOP.12.pdf'))
        //                 ->position(Position::BOTTOM_CENTER, -11.5, -2)
        //                 // ->asBackground()
        //                 // ->pageRange(3, 4)
        //                 ->resolution(270) // 300 dpi
        //                 ->save();

        // dd(Carbon::createFromDate(2023,10,14)->format('Y-m-d'));

        // return TextWatermarker::input(public_path('berkas/SOPIT.pdf'))
        //                 ->output(public_path('berkas/output.pdf'))
        //                 ->position(Position::BOTTOM_CENTER, 0,0)
        //                 // ->asBackground()
        //                 // ->pageRange(1, 2)
        //                 ->text('Hello World 123456789')
        //                 ->angle(25)
        //                 ->font(public_path('berkas/arial.ttf'))
        //                 ->size('38')
        //                 ->color('#CC00007F')
        //                 ->resolution(250) // 300 dpi
        //                 ->stream();
        // return '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG('4', 'QRCODE') . '" alt="barcode"   />';
        // return DNS2D::getBarcodeSVG('4445645656', 'QRCODE');
        // return \Storage::disk('public')->put('test.png',DNS2D::getBarcodeHTML('4445645656', 'QRCODE'));
        
        // $data['barcode'] = DNS2D::getBarcodeHTML("Dokumen telah diverifikasi oleh sistem tanggal ".Carbon::now()->format('d-m-Y'), "QRCODE");
        // return response(view('barcode.layout',$data));
        // return response(view('barcode.layout',$data))->header('Content-type','image/png');

        // \Storage::disk('barcode')->put('test.png',DNS2D::getBarcodePNG("Dokumen telah diverifikasi oleh sistem tanggal 21-02-2024", "QRCODE"));
        // \Storage::disk('barcode')->put('test.png',base64_decode(DNS2D::getBarcodePNG("Dokumen telah diverifikasi oleh sistem tanggal 21-02-2024", "QRCODE")));
        // return \Storage::disk('local')->put('example.txt', 'Contents');
        
        // return \Storage::disk('barcode')->put('test11.png',base64_decode(view('barcode.layout',$data)));

        // dd($request->device());
       
    }
    
}
