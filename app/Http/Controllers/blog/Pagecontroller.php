<?php

namespace App\Http\Controllers\blog;

use App\Http\Controllers\blog\querys\QueryBlogPost;
use App\Http\Controllers\Controller;
use App\Models\blog\TabelaBlogPost;
use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function index(){
        return view('blog.index');
    }

    public function postage($idPostagem = null){

        $queryPostagens = new QueryBlogPost;
        $blogPost = $queryPostagens->blogPost($idPostagem);

        return view('blog.postagens', compact('blogPost'));
    }

    public function mensagem($idPostagem){

        $queryPostMsn = new QueryBlogPost;
        $blogPostMsn = $queryPostMsn->blogPost($idPostagem);

        return view('blog.mensagem', compact('blogPostMsn'));

    }

    public function update($idPostagem){
        $acao = substr($idPostagem, 0, 1);
        $id = substr($idPostagem, 1);

        switch ($acao) {
            case 'A':
                # ativar ...
                TabelaBlogPost::where('id_postagem', $id)->update(['deletar' => 0]);

                $msn = 'Ativado com sucesso';
                break;

            case 'D':
                # desativar...
                TabelaBlogPost::where('id_postagem', $id)->update(['deletar' => 1]);

                $msn = 'Desativado com sucesso';
                break;
            case 'E':
                # excluir...
                TabelaBlogPost::where('id_postagem', $id)->delete();

                $msn = 'Excluido com sucesso';
                break;
        }

        return redirect()->back()->with('success', $msn);

    }

    public function nova(){
        return view('blog.nova');
    }

    public function novaPostagem(Request $request){

        $request->validate([
            "imagem" => 'required|image|mimes:png,jpg,jpeg,gif',
        ]);

        $imageName = time().'.'.$request->imagem->extension();

        $request->imagem->move(public_path('blog/postagens'), $imageName);

        $inserindoPostagem = new TabelaBlogPost();
        $inserindoPostagem->id_post_user = auth()->user()->id;
        $inserindoPostagem->titulo = $request->titulo;
        $inserindoPostagem->mensagem = $request->mensagem;
        $inserindoPostagem->file_img = 'blog/postagens/'.$imageName;
        $inserindoPostagem->data = date('Y-m-d');

        if($request->dataExclusao){
            $inserindoPostagem->data_drop = $request->dataExclusao;
        }

        if($request->dataPostagem){
            $inserindoPostagem->data_postagem = $request->dataPostagem;
        }

        $inserindoPostagem->save();

        return redirect()->back()->with('success', 'Postado com sucesso!');
    }
}
