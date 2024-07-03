<?php

namespace App\Http\Controllers\AdminControllers;

use App\Helpers\MediaHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $aQuery = $request->query();
        $aRows = Category::filter()->orderBy('id', 'desc')->paginate(request('paginate') ?: 20);
        return view('admin.categories.index', compact('aRows', 'aQuery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = array();
        return view('admin.categories.manage', compact('aRow'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aUser = \Auth::guard('admin')->user();
        $messages = [
            'required' => ':attribute is required',
            'numeric' => 'Only Numeric',
        ];
        $rules = [
            'image' => 'mimes:jpeg,bmp,png,gif',
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->all('name', 'description');
        if ($request->hasFile('image')) {
            $image_name = MediaHelper::uploadImageMedia($request->file('image'), Media::$directory[Media::CATEGORIES]);
            if (!$image_name) {
                return redirect()->back()->withError('invalid media file');
            }
            $image_name['media_type'] = Media::CATEGORIES;
            $media_obj = Media::create($image_name);
            $aData['image'] = $media_obj->id;
        }
        Category::create($aData);
        return redirect()->route('admin.category.index')->with('success', 'Category add SuccessFully');
    }

    /**
     * view the specified resource.
     *
     * @param  App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $parent_category_list = array();
        $category::$get_media_name = true;
        $aRow = $category;      

        return view('admin.categories.manage', compact('aRow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $messages = [
            'required' => ':attribute is required',
        ];
        $rules = [
            'image[]' => 'mimes:jpeg,bmp,png,gif',
            'name' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules, $messages);
        if ($validation->fails()) {
            return back()->withErrors($validation->errors());
        }

        $aData = $request->all();
        if ($request->hasFile('image')) {
            $image_name = MediaHelper::uploadImageMedia($request->file('image'), Media::$directory[Media::CATEGORIES]);
            if (!$image_name) {
                return redirect()->back()->withError('invalid media file');
            }
            $category->media?->delete();
            $image_name['media_type'] = Media::CATEGORIES;
            $media_obj = Media::create($image_name);
            $aData['image'] = $media_obj->id;
        }
        $category->update($aData);
        return redirect()->route('admin.category.index')->with('success', 'Update request SuccessFully');
    }
}
