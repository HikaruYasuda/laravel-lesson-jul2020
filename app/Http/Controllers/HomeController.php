<?php

namespace App\Http\Controllers;

use App\Models\Thing;
use App\Repositories\Contracts\ThingRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var \App\Repositories\Contracts\ThingRepository
     */
    public $repository;

    public function __construct(ThingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $things = $this->repository->search($request->query());

        return view('index', compact('things'));
    }

    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('index');
    }

    public function edit(Thing $thing)
    {
        return view('edit', compact('thing'));
    }

    public function update(Thing $thing, Request $request)
    {
        $this->repository->update($thing, $request->all());

        return redirect()->route('index');
    }

    public function destroy(Thing $thing)
    {
        $this->repository->delete($thing);

        return redirect()->route('index');
    }
}
