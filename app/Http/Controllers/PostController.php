<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @return JsonResponse  
     */
    public function index(): JsonResponse
    {
        try {
            $posts = Post::all();

            return response()->json([
                'error' => false,
                'message' => 'Posts recuperados com sucesso.',
                'data' => $posts
            ]);
        } catch (Exception $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * @param String $id
     * @return JsonResponse  
     */
    public function show($id): JsonResponse
    {
        try {
            $post = Post::findOrFail($id);

            return response()->json([
                'error' => false,
                'message' => 'Post recuperado com sucesso.',
                'category' => $post->category,
                'data' => $post
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function create(PostRequest $request)
    {
        try {
            $data = $request->only([
                'title', 
                'image', 
                'content', 
                'publication_date', 
                'status', 
                'user_id', 
                'category_id'
            ]);

            $post = Post::create($data);

            return response()->json([
                'error' => false,
                'message' => 'Post criado com sucesso.',
                'data' => $post
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function update(PostRequest $request)
    {
        try {
            $data = $request->only([
                'title', 
                'image', 
                'content', 
                'publication_date', 
                'status'
            ]);

            $post = Post::findOrFail($request->id);

            $post->update($data);
            $post->save();

            return response()->json([
                'error' => false,
                'message' => 'Post atualizado com sucesso.',
                'data' => $post
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param String $id
     * @return JsonResponse  
     */
    public function remove($id): JsonResponse
    {
        try {
            $post = Post::where(["id" => $id])->delete();

            return response()->json([
                'error' => false,
                'message' => 'Post deletado com sucesso.',
                'data' => $post
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse  
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $search = $request->get('search');

            $post = Post::where('title', 'LIKE', "%{$search}%")->get();

            return response()->json([
                'error' => false,
                'message' => 'Busca de post recuperada com sucesso.',
                'data' => $post
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param String $id
     */
    public function downloadCsv($id)
    {
        try {
            $posts = Post::where(["user_id" => $id])->get();

            $filename = "application.csv";
            $fp = fopen($filename, "w+");
            fputcsv($fp, array('Titulo', 'Conteudo', 'Data de Publicacao'));

            foreach ($posts as $post) {
                fputcsv($fp, array($post->title, $post->content, $post->publication_date));
            }

            fclose($fp);
            $headers = array('Content-Type' => 'text/csv');

            return response()->download($filename, 'application.csv', $headers);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }
}
