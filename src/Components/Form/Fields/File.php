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
        if ($request->hasFile($name)) {
            $disk = $this->getDisk();
            $path = $request->file($name)->store($this->getPath(), [
                'disk'       => $disk,
                'visibility' => $this->getVisibility(),
            ]);
            return Storage::disk($disk)->url($path);
        }
        return parent::getDataFromRequest($request);
    }

    public function getDisk(): string
    {
        if (empty($this->disk)) {
            return config('filesystems.default');
        }

        return $this->evaluate($this->disk);
    }
}
