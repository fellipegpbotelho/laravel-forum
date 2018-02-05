<?php

namespace App\Observers;

use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use Image;

class PhotoUserObserver
{
    public function creating(User $user)
    {
        if (is_a($user->photo, UploadedFile::class) and $user->photo->isValid()) {
            $this->upload($user);
        }
    }

    public function deleting(User $user)
    {
        Storage::delete($user->photo);
    }

    public function updating(User $user)
    {
        if (is_a($user->photo, UploadedFile::class) and $user->photo->isValid()) {
            $previousImage = $user->getOriginal('photo');
            $this->upload($user);
            Storage::delete($previousImage);
        }
    }

    protected function upload(User $user)
    {
        $extension = $user->photo->extension();
        $allowedExtensions = [
            'png', 'gif', 'jpg', 'jpeg', 'bmp',
        ];

        if ( ! in_array($extension, $allowedExtensions)){
            throw new Exception('Extension now allowed!');
        }

        $name = bin2hex(openssl_random_pseudo_bytes(8));
        $name = $name.'.'.$extension;
        $name = 'avatars/' . $name;

        $user->photo->storeAs('', $name);

        $image = Image::make($user->photo->getRealPath());
        $image->fit(250, 250)->save(public_path('/thumb/' . $name));

        $user->photo = $name;
    }
}