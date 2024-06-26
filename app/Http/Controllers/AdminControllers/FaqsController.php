<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Response;
use App\Models\Faq;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parent_name = $parent_id = null;
        $aRows = Faq::orderBy('id', 'desc')->whereNull('parent_id')->paginate(20);
        return view('admin.faqs.index', compact('aRows', 'parent_id', 'parent_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($parent = null)
    {
        $aRow = new Faq();
        if ($parent) {
            $parent_list = $aRow::where('id', $parent)->orderBy('order_by', 'ASC')->pluck('title', 'id')->toArray();
            $aRow->parent_id = $parent;
        } else {
            $parent_list = $aRow::where([['type', Faq::FAQ_TYPE_TITLE], ['status', Faq::STATUS_ACTIVE]])->orderBy('order_by', 'ASC')->pluck('title', 'id')->toArray();
        }
        return view('admin.faqs.manage', compact('aRow', 'parent_list', 'parent'));
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
            'title' => "required",
            'type' => "required",
        ], [
            'title.required' => "Title is Required",
            'type.required' => "Faq type is Required",
        ]);

        $aData = $request->only('title', 'type', 'description', 'parent_id');

        $parent = null;
        $route = route('admin.faqs.index');
        if ($aData['parent_id']) {
            $parent = Faq::where([['id', $aData['parent_id']], ['status', Faq::STATUS_ACTIVE]])->first();
            if (!$parent) {
                return redirect()->back()->withError('Select valid parent');
            }
            $aData['parent_id'] = $parent->id;
            $route = route('admin.faqs.show', $parent->id);
        }
        Faq::create($aData);
        return redirect($route)->with('success', 'Request save Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        $parent_id = $faq->id;
        $aRows = Faq::where('parent_id', $faq->id)->orderBy('order_by', 'ASC')->paginate(20);
        $parent_name = $faq->title;
        return view('admin.faqs.index', compact('aRows', 'parent_id', 'parent_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        $aRow = $faq;
        $parent_list = $aRow::where([['type', Faq::FAQ_TYPE_TITLE], ['status', Faq::STATUS_ACTIVE]])->whereNull('parent_id')->orderBy('order_by', 'ASC')->pluck('title', 'id')->toArray();
        return view('admin.faqs.manage', compact('aRow', 'parent_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $this->validate($request, [
            'title' => "required",
            'type' => "required",
        ], [
            'title.required' => "Title is Required",
            'type.required' => "Faq type is Required",
        ]);

        $aData = $request->only('title', 'type', 'description', 'parent_id');

        $parent = null;
        if ($aData['parent_id']) {
            $parent = Faq::where([['id', $aData['parent_id']], ['status', Faq::STATUS_ACTIVE]])->first();
            if (!$parent) {
                return redirect()->back()->withError('Select valid parent');
            }
            $aData['parent_id'] = $parent->id;
        }
        $faq->update($aData);
        return redirect()->route('admin.faqs.index')->with('success', 'Request Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function final_layout()
    {
        $aRows = Faq::orderBy('id', 'desc')->whereNull('parent_id')->get();
        return view('admin.faqs.final_layout', compact('aRows'));
    }
}
