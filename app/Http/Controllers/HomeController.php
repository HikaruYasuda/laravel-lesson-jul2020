<?php

namespace App\Http\Controllers;

use App\Repositories\PortfolioRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $portfolios = resolve(PortfolioRepository::class)->getAll();

        return view('index', compact('portfolios'));
    }

    public function store(Request $request)
    {
        resolve(PortfolioRepository::class)->create($request->all());

        return redirect()->route('index');
    }
}
