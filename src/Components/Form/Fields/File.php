<?php
declare(strict_types=1);

namespace Merlion\Components\Form\Fields;

use Closure;
use Illuminate\Support\Facades\Storage;

/**
 * @method $this accept(string|Closure $accept) Set accept
 * @method $this multiple(bool|Closure $multiple) Set multiple
 * @method string getAccept()
 * @method string getPath()
 * @method string getVisibility()
 * @method boolean getMultiple()
 */
class File extends Text
{
    public mixed $disk = null;
    public mixed $accept = '*';
    public mixed $path = '';
    public mixed $visibility = null;
    public mixed $multiple = false;

    public function getDataFromRequest($request = null)
    {
        $request = $request ?: request();
        $name    = $this->getName();

        $multiple = $this->getMultiple();

        if (!$multiple) {
            if ($request->hasFile($name)) {
                $disk = $this->getDisk();
                $path = $request->file($name)->store($this->getPath(), [
                    'disk'       => $disk,
                    'visibility' => $this->getVisibility(),
                ]);
                return Storage::disk($disk)->url($path);
            }
            if ($request->input($name . '_deleted') == 1) {
                return null;
            }
            return $request->input($name . '_original');
        }

        $files = $request->input($name . '_original');

        if ($request->hasFile($name)) {
            foreach ($request->file($name) as $file) {
                $disk    = $this->getDisk();
                $path    = $file->store($this->getPath(), [
                    'disk'       => $disk,
                    'visibility' => $this->getVisibility(),
                ]);
                $files[] = Storage::disk($disk)->url($path);
            }
        }

        return $files;
    }

    public function getDisk(): string
    {
        if (empty($this->disk)) {
            return config('filesystems.default');
        }

        return $this->evaluate($this->disk);
    }
}
