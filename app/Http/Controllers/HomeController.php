<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PortfolioRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var \App\Repositories\PortfolioRepository
     */
    public $repository;

    public function __construct(PortfolioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $portfolios = app()->call([$this->repository, 'getAll']);

        return view('index', compact('portfolios'));
    }

    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('index');
    }
}
