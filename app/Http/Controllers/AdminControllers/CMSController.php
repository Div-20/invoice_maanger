<?php

namespace App\Http\Controllers\AdminControllers;

use App\Helpers\CustomHelper;
use App\Http\Controllers\Controller;
use App\Models\CMS;
use Illuminate\Http\Request;

class CMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aRows = CMS::orderBy('id', 'desc')->paginate(20);
        return view('admin.cms.index', compact('aRows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = [];
        return view('admin.cms.manage', compact('aRow'));
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
            'slug' => "required",
        ], [
            'title.required' => "Title is Required",
            'slug.required' => "Invalid Required",
        ]);

        $aData = $request->only('title', 'sub_title', 'description', 'short_description', 'slug');
        $check_cms = CMS::where('slug', 'like', "%" . $aData['slug'] . "%")->first();
        if ($check_cms) {
            return redirect()->back()->withInput()->withError('Title already registered.');
        }
        CMS::create($aData);
        return redirect()->route('admin.cms.index')->with('success', 'Request save Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CMS  $cMS
     * @return \Illuminate\Http\Response
     */
    public function edit($cms)
    {
        $aRow = CMS::where('id', $cms)->first();
        if (!$aRow) {
            return redirect()->route('admin.cms.index')->withError('Invalid Request');
        }
        return view('admin.cms.manage', compact('aRow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CMS  $cMS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cms)
    {
        $this->validate($request, [
            'title' => "required",
            'slug' => "required",
        ], [
            'title.required' => "Title is Required",
            'slug.required' => "Invalid Required",
        ]);

        $cms = CMS::where('id', $cms)->first();
        if (!$cms) {
            return redirect()->route('admin.cms.index')->withError('Invalid Request');
        }
        $aData = $request->only('title', 'sub_title', 'description', 'short_description', 'slug');
        // $aData['slug'] = CustomHelper::seo_friendly_url($aData['slug']);

        $check_cms = CMS::where('id', '!=', $cms->id)->where('slug', 'like', "%" . $aData['slug'] . "%")->first();
        if ($check_cms) {
            return redirect()->back()->withInput()->withError('Title already registered.');
        }
        $cms->update($aData);
        return redirect()->route('admin.cms.index')->with('success', 'Request save Successfully');
    }

}
