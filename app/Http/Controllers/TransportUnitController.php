<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransportUnit;


class TransportUnitController extends Controller
{
    public function index(Request $request)
	{
		$request->validate([
			'type' => 'required|in:truck,trailer',
			'search' => 'nullable|string|max:100',
		]);

		$query = TransportUnit::where('type', $request->type);

		if ($request->filled('search')) {
			$query->where('name', 'LIKE', '%' . $request->search . '%');
		}
		return $query->paginate(10);
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:100',
			'type' => 'required|in:truck,trailer',
		]);

		return response()->json(TransportUnit::create($request->only('name', 'type')), 201);
	}


}
