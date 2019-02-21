<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller {

  public function __construct() {
    return $this->middleware('auth');
  }

  public function index() {
    $posts = Post::all();

    return view('index', compact('posts'));
  }

  public function create() {
    return view('post');
  }

  public function store(Request $request) {
    $validator = Validator::make($request->all(), [
          'title' => ['required', "max:30", Rule::unique('posts', 'title')->where(function ($query) {
                })],
          'image' => 'required|image|mimes:jpeg,png,jpg',
          'body' => 'required',
    ]);
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator->errors(), 'postErrors')->withInput($request->all());
    } else {
      try {
        $post = new Post;
        $post->title = $request->get('title');
        $post->body = $request->get('body');

        $imageFile = $request->file('image');
        $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
        $folderName = 'postImages';
        Storage::disk('public')->put($folderName . '/' . $imageName, file_get_contents($imageFile));
        $post->image = 'storage/' . $folderName . '/' . $imageName;

        $post->save();

        return redirect('posts');
      } catch (\Exception $ex) {

        return redirect()->back()->withErrors($ex->getMessage(), 'error');
      }
    }
  }

  public function show($id) {
    $post = Post::find($id);

    return view('show', compact('post'));
  }

}
