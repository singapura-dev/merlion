<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers;

use Storage;

class UploadController
{
    public function __invoke()
    {
        if (request()->hasFile('file')) {
            $multiple = request('multiple', false);
            if ($multiple) {
                $urls = [];
                foreach (request()->file('file') as $file) {
                    $path   = $file->store('uploads');
                    $urls[] = Storage::url($path);
                }
                return [
                    'success' => true,
                    'url'     => $urls,
                ];
            }
            $path = request()->file('file')->store('uploads');
            return [
                'success' => true,
                'url'     => Storage::url($path),
            ];
        }
        return request()->all();
    }
}
