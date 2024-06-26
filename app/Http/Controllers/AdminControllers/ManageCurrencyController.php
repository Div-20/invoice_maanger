<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\ManageCurrency;
use Illuminate\Http\Request;

class ManageCurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aRows = ManageCurrency::orderBy('id', 'desc')->paginate(20);
        return view('admin.currencies.index', compact('aRows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = [];
        return view('admin.currencies.manage', compact('aRow'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => "required",
            'code' => "required",
            'symbol' => "required",
            'thousand_separator' => "required",
            'decimal_separator' => "required",
            'exchange_rate' => "required|integer"
        ], [
            'name.required' => "Title is Required",
            'code.required' => "Invalid Required",
            'symbol.required' => "Invalid Required",
            'thousand_separator.required' => "Invalid Required",
            'decimal_separator.required' => "Invalid Required",
            'exchange_rate.required' => "Invalid Required",
        ]);

        $aData = $request->only('name', 'code', 'symbol', 'thousand_separator', 'decimal_separator', 'exchange_rate');
        $check_model = ManageCurrency::where('code', 'like', "%" . $aData['code'] . "%")->first();
        if ($check_model) {
            return redirect()->back()->withInput()->withError('Code already registered.');
        }
        ManageCurrency::create($aData);
        return redirect()->route('admin.currencies.index')->with('success', 'Request save Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ManageCurrency  $manageCurrency
     * @return \Illuminate\Http\Response
     */
    public function edit($manageCurrency)
    {
        $aRow = ManageCurrency::where('id', $manageCurrency)->first();
        if (!$aRow) {
            return redirect()->route('admin.currencies.index')->withError('Invalid Request');
        }
        return view('admin.currencies.manage', compact('aRow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $manageCurrency = ManageCurrency::where('id', $id)->first();
        if (!$manageCurrency) {
            return redirect()->back()->withInput()->withError('Invalid request.');
        }

        $this->validate($request, [
            'name' => "required",
            'code' => "required",
            'symbol' => "required",
            'thousand_separator' => "required",
            'decimal_separator' => "required",
            'exchange_rate' => "required|integer",
        ], [
            'name.required' => "Title is Required",
            'code.required' => "Invalid Required",
            'symbol.required' => "Invalid Required",
            'thousand_separator.required' => "Invalid Required",
            'decimal_separator.required' => "Invalid Required",
            'exchange_rate.required' => "Invalid Required",
        ]);

        $aData = $request->only('name', 'code', 'symbol', 'thousand_separator', 'decimal_separator', 'exchange_rate');
        $check_model = ManageCurrency::where('code', 'like', "%" . $aData['code'] . "%")->where('id', '!=', $manageCurrency->id)->first();
        if ($check_model) {
            return redirect()->back()->withInput()->withError('Code already registered.');
        }

        $manageCurrency->update($aData);
        return redirect()->route('admin.currencies.index')->with('success', 'Request save Successfully');
    }

    /* activate and deactivate currencies */
    public function activate_currency($id)
    {
        $manageCurrency = ManageCurrency::where('id', $id)->first();
        if (!$manageCurrency) {
            return redirect()->back()->withInput()->withError('Invalid request.');
        }
        ManageCurrency::where('active', 1)->update(['active' => 0]);
        $manageCurrency->update(['active' => 1]);
        return redirect()->route('admin.currencies.index')->with('success', 'Request save Successfully');
    }
}
