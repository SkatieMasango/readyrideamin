<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return Media::class;
    }

    /**
     * Store a file from a request.
     *
     * @param  UploadedFile  $file  The file to store
     * @param  string  $path  The path to store the file
     * @param  string|null  $type  The type of the file
     */
    public static function storeByRequest(UploadedFile $file, string $path, string $type, $mediableId): Media
    {
        $path = Storage::disk('public')->put('/'.trim($path, '/'), $file);

        $existFile = self::query()->where('mediable_type', get_class($mediableId))
            ->where('mediable_id', $mediableId->id)
            ->first();

        if($existFile){
            Storage::delete($existFile->path);
            $existFile->update([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'type' => $type,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);

            return $existFile;
        }

        $media = self::query()->updateOrCreate([
            'mediable_type' => get_class($mediableId),
            'mediable_id' => $mediableId->id,
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'type' => $type,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return $media;
    }
}
