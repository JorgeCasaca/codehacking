<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostsCreateRequest;
use App\Photo;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //


        $posts = Post::paginate(2);



        return view('admin.posts.index', compact('posts','categories'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


        $categories = Category::pluck('name','id')->all();


        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        //

        $input = $request->all();


        $user = Auth::user();


        if($file = $request->file('photo_id')){


            $name = time() . $file->getClientOriginalName();


            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);


            $input['photo_id'] = $photo->id;


        }




        $user->posts()->create($input);




        return redirect('/admin/posts');






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
        //

        $post = Post::findOrFail($id);

        $categories = Category::pluck('name','id')->all();

        return view('admin.posts.edit', compact('post','categories'));


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
        //

        $input = $request->all();



        if($file = $request->file('photo_id')){


            $name = time() . $file->getClientOriginalName();


            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);


            $input['photo_id'] = $photo->id;


        }


      Auth::user()->posts()->whereId($id)->first()->update($input);


        return redirect('/admin/posts');




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //Experiencia1
        //$post = Post::findOrFail($id);

//        if ($deleted = Post::delete('public/images/' . $product . '/'. $post->photo->file))
//        {
//            $status = $image->delete();
//
//            if ($status)
//            {
//                return 'deleted from database and file system';
//            }
//
//            return 'Not deleted from database';
//        }
//
//        return 'Unsuccessful operation';
//    }

        //Experiencia 2
//        if(file_exists(public_path('images'))){
//            unlink(public_path('images'). DIRECTORY_SEPARATOR . $post->photo->file);
//        }else{
//            dd('File does not exists.');
//        }

        $post = Post::findOrFail($id);

        $image_path = "/images/";  // Value is not URL but directory file path

        if(Post::exists($image_path)) {
            $post->delete($image_path);
        }

        //Experiencia 3
//        $post = Post::findOrFail($id);
//
//        unlink(public_path("images") . '/' . $post->photo->file);
//
//        $post->delete();

        Session::flash('deleted_user','The user has been deleted');

        return redirect('/admin/posts');


    }


    public function post($slug){


        $post = Post::findBySlugOrFail($slug);

        $comments = $post->comments()->whereIsActive(1)->get();


        return view('post', compact('post','comments'));


    }



}
