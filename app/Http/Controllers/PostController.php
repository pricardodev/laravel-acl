<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PostController extends Controller
{
    private $posts;
    public function __construct(Post $posts)
    {
        $this->posts = $posts;
    }
    
    public function index()
    {
        $posts = $this->posts->all();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        /*if(!Auth::user()->hasPermissionTo('Cadastrar Artigo'))
        {
            throw new UnauthorizedException('403', 'Apenas Administradores do sistema');
        }*/

        if(!Auth::user()->hasRole('Administrador'))
        {
            throw new UnauthorizedException('403', 'Apenas Administradores do sistema');
        }

        return view('posts.create');
    }

    public function store(Request $request)
    {
        $post = $this->posts;
        $post->title = $request->title;
        $post->content = $request->content;

        if(!empty($request->published)) {
            $post->published = $request->published;
        }

        $post->save();

        return redirect()->route('post.edit', [
            'post' => $post->id,
        ]);
    }

    public function show(Post $post)
    {
        //
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $post->title = $request->title;
        $post->content = $request->content;

        if(isset($request->published)) {
            $post->published = $request->published;
        }

        $post->save();
        return redirect()->route('post.edit', [
            'post' => $post->id,
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index');
    }
}
