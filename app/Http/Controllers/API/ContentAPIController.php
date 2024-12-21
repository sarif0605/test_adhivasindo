<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Content;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ContentAPIController extends Controller
{
    public function showThreeContent(){
        $contents = Content::with('user')->orderBy('created_at', 'DESC')->limit(3)->get();
        return response()->json([
            'success' => true,
            'data' => $contents
        ]);
    }

    public function show(string $id){
        $content = Content::with('user')->find($id);
        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $content
        ]);
    }

    public function index(){
        $contents = Content::with('user')->orderBy('created_at', 'DESC')->get();
        return response()->json([
            'success' => true,
            'data' => $contents
        ]);
    }

    public function dashboard(){
        $user = auth()->user();
        $contents = Content::with('user')->where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        return response()->json([
            'success' => true,
            'data' => $contents
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);

        $cloudinaryImage = $request->file('image')->storeOnCloudinary('products');
        $url = $cloudinaryImage->getSecurePath();
        $public_id = $cloudinaryImage->getPublicId();

        $content = new Content([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_url' => $url,
            'image_public_id' => $public_id,
            'user_id' => $user->id,
        ]);

        $content->save();

        return response()->json([
           'message' => 'berhasil menambahkan data',
           'data' => $content
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $content = Content::find($id);
        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }
        $validated = $request->validate([
            'title' => 'nullable',
            'content' => 'nullable',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);
        if($request->hasFile('image')){
            Cloudinary::destroy($content->image_public_id);
            $cloudinaryImage = $request->file('image')->storeOnCloudinary('products');
            $url = $cloudinaryImage->getSecurePath();
            $public_id = $cloudinaryImage->getPublicId();
            $content->update([
                'image_url' => $url,
                'image_public_id' => $public_id,
            ]);
        }
        $content->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);
        return response()->json([
            'message' => 'berhasil update data',
            'data' => $content
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $content = Content::find($id);

        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Content gagal dihapus. Data tidak ditemukan.',
            ], 404); // Menggunakan kode status HTTP 404 untuk resource not found
        }
        Cloudinary::destroy($content->image_public_id);
        $content->delete();
        return response()->json([
            'success' => true,
            'message' => 'Content berhasil dihapus.',
        ], 200);
    }
}
