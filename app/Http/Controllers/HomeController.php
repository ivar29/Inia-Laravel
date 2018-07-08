<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
class HomeController extends Controller
{

  public function downloadPDF()

    {

    	$pdf = PDF::loadView('pdfView');

		return $pdf->download('invoice.pdf');

    }
    public function vistaPdf()
    {
        return view('pdfView');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
