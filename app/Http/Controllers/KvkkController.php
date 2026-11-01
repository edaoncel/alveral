<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KvkkController extends Controller
{
    /**
     * KVKK Aydınlatma Metni sayfasını gösterir.
     */
    public function kvkk()
    {
        return view('kvkk');
    }
}