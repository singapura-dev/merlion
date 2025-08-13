<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers\Concerns;

use Illuminate\Support\Arr;

/**
 * @mixin AsCurdController
 *
 */
trait HasDestroy
{
    public function destroy(...$args)
    {
        $id = Arr::last($args);
        $model = app($this->getModel())->findOrFail($id);

        $this->authorize('delete', $model);

        $model->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'action' => 'refresh',
                'message' => __('merlion::base.deleted')
            ]);
        }

        return back();
    }

    public function restore(...$args)
    {
        $id = Arr::last($args);
        $model = app($this->getModel())->withTrashed()->findOrFail($id);

        $this->authorize('restore', $model);

        $model->restore();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'action' => 'refresh',
                'message' => __('merlion::base.restored')
            ]);
        }

        return back();
    }
}
