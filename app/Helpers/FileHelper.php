<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * Remove '@' and everything behind it, return clean email name
     *
     * @param mixed $user 'user' default = null
     * @return string
     */
    public static function getNameFromEmail($user = null)
    {
        if (!is_null($user)) {
            return explode('@', $user->email)[0];
        } else {
            return explode('@', Auth::user()->email)[0];
        }
    }

    /**
     * Get clean file name without it's extension
     *
     * @param mixed $file
     * @return string
     */
    public static function getFileName($file)
    {
        $lastDot = strrpos($file->getClientOriginalName(), '.');
        $name = substr($file->getClientOriginalName(), 0, $lastDot);

        return $name;
    }

    /**
     * Store file in public folder
     *
     * @param mixed $file
     * @param string $location 'location' accepted 'songs' or 'lyrics' or 'avatars' or 'thumbnails'
     * @return bool
     */
    public static function store(UploadedFile $file, string $location)
    {
        try {
            if (is_null($file)) {
                return false;
            }
            if ($location != 'songs' &&
                $location != 'lyrics' &&
                $location != 'thumbnails' &&
                $location != 'avatars') {
                return false;
            }
            $fullPath = 'uploads/' . self::getNameFromEmail() . '/' . $location;
            $targetPath = public_path($fullPath . '/' . $file->getClientOriginalName());
            $file->move(dirname($targetPath), basename($targetPath));

            return true;
        } catch (\Throwable $th) {
            Log::error($th);

            return false;
        }
    }

    /**
     * Get assets url, currently can get url from songs, lyrics, song's thumbnail
     *
     * @param string $location 'location' accepted 'songs' or 'lyrics' or 'thumbnails'
     * @param mixed $data
     * @return string|null
     */
    public static function getUrl(string $location, $data)
    {
        if (!is_null($data)) {
            $path = asset('uploads/' . self::getNameFromEmail($data->author) . "/$location/");
            switch ($location) {
                case 'songs':
                    return $path . '/' . $data->name . '.mp3';
                case 'lyrics':
                    return $path . $data->lyrics;
                case 'thumbnails':
                    return $path . $data->thumbnail;
                default:
                    return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Get lyrics from song
     *
     * @param mixed $song
     * @return string[]
     */
    public static function getLyrics($song)
    {
        $path = 'uploads/' . self::getNameFromEmail($song->author) . '/lyrics' . $song->lyrics;
        $file = Storage::disk('public-api')->get($path);
        $_file = explode(',', str_replace("\n", ',', $file));

        return $_file;
    }

    /**
     * Get song's property url
     *
     * @param mixed $song
     * @return null
     */
    public static function getSongUrl($song)
    {
        if (!is_null($song)) {
            $song->song_path = self::getUrl('songs', $song);
            $song->lyrics_path = self::getUrl('lyrics', $song);
            $song->thumbnail_path = self::getUrl('thumbnails', $song);
            $song->author->avatar_path = self::getAvatar(User::find($song->author_id));
            $song->category->thumbnail_path = self::getThumbnail('category', $song->category);
            if (!is_null($song->playlist)) {
                $song->playlist->thumbnail_path = self::getThumbnail('playlist', $song->playlist);
                $song->playlist->author->avatar_path = self::getAvatar($song->playlist->author);
            }
            $song->list_lyric = self::getLyrics($song);
        } else {
            return null;
        }
    }

    /**
     * Get user avatar url
     *
     * @param mixed $user
     * @return string
     */
    public static function getAvatar($user = null)
    {
        if (!is_null($user)) {
            return asset('uploads/' . self::getNameFromEmail($user) . '/avatars' . $user->avatar);
        } else {
            return asset('uploads/' . self::getNameFromEmail() . '/avatars' . Auth::user()->avatar);
        }
    }

    /**
     * Get thumbnail url from 'playlist' or 'category'
     *
     * @param string $type 'type' accepted 'playlist' or 'category'
     * @param mixed $data
     * @return string|null
     */
    public static function getThumbnail(string $type, $data)
    {
        if (!is_null($data)) {
            switch ($type) {
                case 'playlist':
                    $author = User::find($data->author_id);

                    return asset('uploads/' . self::getNameFromEmail($author) . '/thumbnails' . $data->thumbnail);
                case 'category':
                    return asset('assets/categories/thumbnails' . $data->thumbnail);
                default:
                    return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Get all artists avatar url
     *
     * @param mixed $artists
     * @return null
     */
    public static function getArtistsUrl($artists)
    {
        if (!is_null($artists)) {
            foreach ($artists as $artist) {
                $artist->avatar_path = self::getAvatar($artist);
            }
        } else {
            return null;
        }
    }

    /**
     * Get all songs's url
     *
     * @param mixed $songs
     * @return null
     */
    public static function getSongsUrl($songs)
    {
        if (!is_null($songs)) {
            foreach ($songs as $song) {
                $song->song_path = self::getUrl('songs', $song);
                $song->lyrics_path = self::getUrl('lyrics', $song);
                $song->thumbnail_path = self::getUrl('thumbnails', $song);
                $song->author->avatar_path = self::getAvatar(User::find($song->author_id));
                $song->category->thumbnail_path = self::getThumbnail('category', $song->category);
                if (!is_null($song->playlist)) {
                    $song->playlist->thumbnail_path = self::getThumbnail('playlist', $song->playlist);
                    $song->playlist->author->avatar_path = self::getAvatar($song->playlist->author);
                }
                $song->list_lyric = self::getLyrics($song);
            }
        } else {
            return null;
        }
    }

    /**
     * Get all playlists's url
     *
     * @param mixed $playlists
     * @return null
     */
    public static function getPlaylistsUrl($playlists)
    {
        if (!is_null($playlists)) {
            foreach ($playlists as $playlist) {
                $playlist->thumbnail_path = self::getThumbnail('playlist', $playlist);
                $playlist->author->avatar_path = self::getAvatar($playlist->author);
            }
        } else {
            return null;
        }
    }

    /**
     * Read total file chunk
     * Usefull when working with uploading big file
     *
     * @param mixed $handle
     * @param mixed $chunkSize
     * @return string
     */
    public static function readFileChunk($handle, $chunkSize)
    {
        $byteCount = 0;
        $giantChunk = '';
        while (!feof($handle)) {
            $chunk = fread($handle, 8192);
            $byteCount += strlen($chunk);
            $giantChunk .= $chunk;
            if ($byteCount >= $chunkSize) {
                return $giantChunk;
            }
        }

        return $giantChunk;
    }
}
