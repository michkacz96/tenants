<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SellItem;
use App\Models\User;

class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return all avialable categories as [key => value]
     */
    public static function getListOfCategories(){
        $categories = Category::select('id', 'category_name')->where('user_id', auth()->user()->id)->where('cat_type', '0')->get();
        $tmp = [];
        foreach($categories as $category){
            $tmp[$category->id] = $category->category_name;
        }

        return $tmp;
    }

    /**
     * Return all avialable purchase categories as [key => value]
     */
    public static function getListOfPurchaseCategories(){
        $categories = Category::select('id', 'category_name')->where('user_id', auth()->user()->id)->where('cat_type', '1')->get();
        $tmp = [];
        foreach($categories as $category){
            $tmp[$category->id] = $category->category_name;
        }

        return $tmp;
    }

    /**
     * Display a listing of the resource.
     * !! ONLY FOR TESTING AND TROUBLESHOOTING !!
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'List of categories',
            'categories_sales' => Category::where('user_id', auth()->user()->id)->where('cat_type', '0')->orderBy('category_name', 'asc')->get(),
            'categories_purchases' => Category::where('user_id', auth()->user()->id)->where('cat_type', '1')->orderBy('category_name', 'asc')->get()
        );
        return view('categories.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Add new category',
            'cat_type' => Category::getCatType()
        );
        return view('categories.create')->with($data);
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
            'category_name' => 'required',
            'cat_type' => 'required'
        ]);

        //create category
        $category = new Category;
        $category->category_name = $request->input('category_name');
        $category->cat_type = $request->input('cat_type');
        $category->user_id = auth()->user()->id;

        $category->save();

        return redirect('/categories')->with('success', 'Category '.$category->category_name.' added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $data = array(
            'title' => 'Edit',
            'cat_type' => Category::getCatType(),
            'category' => $category
        );

        return view("categories.edit")->with($data);
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
        $this->validate($request, [
            'category_name' => 'required',
            'cat_type' => 'required'
        ]);

        //create category
        $category = Category::find($id);
        $category->category_name = $request->input('category_name');
        $category->cat_type = $request->input('cat_type');
        //$category->user_id = auth()->user()->id;

        $category->save();

        return redirect('/categories')->with('success', 'Category updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        //check for correct user and delete
        if(auth()->user()->id !== $category->user_id){
            return redirect('/categories')->with('error', 'Unauthorized page');
        }

        $category->delete();
        return redirect('/categories')->with('success', 'Category '.$category->category_name.' removed');
    }
}
