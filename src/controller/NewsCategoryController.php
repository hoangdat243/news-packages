<?php

namespace Vinsofts\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $category= NewsCategory::all();
        
        return view('v::category.category',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('v::category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate
        $request->validate([
            'txtName' => 'required|unique:news_categories,name|max:255',
            'txtMetaTitle' => 'required|max:60',
            'txtDescription' => 'required|max:255',
            'txtSlug' => 'unique:news_categories,name|max:255'
            
        ],[
            'txtName.required'  => 'Chưa nhập tên',
            'txtName.unique'    => 'Tên đã tồn tại',
            'txtName.max'       => 'Tên phải ít hơn 255 kí tự',
            'txtMetaTitle.required' => 'Chưa nhập Meta Title',
            'txtMetaTitle.max'    => 'Meta Title không được quá 60 kí tự',
            'txtDescription.required' => 'Chưa nhập mô tả',
            'txtSlug.unique' => 'Slug đã tồn tại',
            'txtName.max' => 'Slug vượt quá 255 kí tự',
        ]);


        $category= new NewsCategory;
        $category->name= $request->txtName;
        if (isset($request->txtSlug)) {
            $category->slug= $request->txtSlug;
        }
        else{
            $category->slug= str_slug($request->txtName,'-');
        }
        $category->meta_title= $request->txtMetaTitle;
        $category->meta_description= $request->txtDescription;
        //add image
        if (isset($request->fImage)) {
            $file = $request->fImage;
            $name=$file -> getClientOriginalName();
            $file -> getClientOriginalExtension();
            $tmp=$file -> getRealPath();
            $file -> move('uploads/images', $file->getClientOriginalName());
            $category -> image=  "/uploads/images/".$name;
        }else{ $category -> image='';}
        $category->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data= NewsCategory::find($id);
        return view('v::category.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'txtName' => 'required|max:255',
            'txtMetaTitle' => 'required|max:60',
            'txtDescription' => 'required|max:255',
            'txtSlug' => 'max:255'
        ],[
            'txtName.required'  => 'Chưa nhập tên',
            'txtName.max'       => 'Tên phải ít hơn 255 kí tự',
            'txtMetaTitle.required' => 'Chưa nhập Meta Title',
            'txtMetaTitle.max'    => 'Meta Title không được quá 60 kí tự',
            'txtDescription.required' => 'Chưa nhập mô tả',
            'txtName.max' => 'Slug vượt quá 255 kí tự',
        ]);
        $category = NewsCategory::find($id);
        $category->name= $request->txtName;
        if (isset($request->txtSlug)) {
            $category->slug= $request->txtSlug;
        }
        else{
            $category->slug= str_slug($request->txtName,'-');
        }
        $category->meta_title= $request->txtMetaTitle;
        $category->meta_description= $request->txtDescription;
        if (isset($request->fImage)) {
            $file = $request->fImage;
            $name=$file->getClientOriginalName();
            $file->getClientOriginalExtension();
            $tmp=$file->getRealPath();
            $file->move('uploads/images', $file->getClientOriginalName());
            $category->image=  "/uploads/images/".$name;
        }
        $category->save();
        return redirect('news-categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        NewsCategory::destroy($id);
        return redirect()->back();
    }
    public function search(Request $request)
    {
        $tag= NewsCategory::where('name','like','%'.$request->key.'%')->get();
       return view('v::category.search',compact('tag'));
    }
    
}
