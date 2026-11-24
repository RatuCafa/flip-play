<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function collection(User $user): UserResource
    {
        $user->load('media');
        return new UserResource($user);
    }

    public function addToCollection(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'media_id' => 'required|integer|exists:media,id',
        ], [
            'media_id.required' => 'ID media wajib diisi.',
            'media_id.exists'   => 'Media dengan ID tersebut tidak ditemukan.',
        ]);

        $mediaId = $validated['media_id'];

        // Cek duplikasi: cegah menambahkan media yang sama dua kali (Status 409 Conflict)
        if ($user->media()->where('media_id', $mediaId)->exists()) {
            return response()->json([
                'message' => 'Media sudah ada di dalam koleksi pengguna ini.'
            ], 409);
        }

        $user->media()->attach($mediaId);

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi pengguna.'
        ], 201);
    }

    public function removeFromCollection(User $user, Media $media): JsonResponse
    {
        if (!$user->media()->where('media_id', $media->id)->exists()) {
            return response()->json([
                'message' => 'Media tersebut tidak ada di dalam koleksi pengguna.'
            ], 404);
        }

        $user->media()->detach($media->id);

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi pengguna.'
        ], 200);
    }
}
