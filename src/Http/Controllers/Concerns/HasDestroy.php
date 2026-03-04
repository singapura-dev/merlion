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
        $this->callMethods('beforeDestroy', ...$args);

        $id    = Arr::last($args);
        $model = app($this->getModel())->findOrFail($id);

        $this->authorize('delete', $model);

        $model->delete();

        $this->callMethods('afterDestroy', ...$args);

        admin()->success(__('merlion::base.action_performace_success'));
        if (request()->wantsJson() || request()->ajax()) {
            $data = [
                'success' => true,
                'message' => __('merlion::base.deleted'),
                'request' => request()->all()
            ];
            if (request('redirect')) {
                $data['action'] = 'redirect';
                $data['url']    = request('redirect');
            } else {
                $data['action'] = 'refresh';
            }
            return response()->json($data);
        }

        return redirect(request('redirct'), $this->route('index'));
    }

    public function restore(...$args)
    {
        $id    = Arr::last($args);
        $model = app($this->getModel())->withTrashed()->findOrFail($id);

        $this->authorize('restore', $model);

        $model->restore();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'action'  => 'refresh',
                'message' => __('merlion::base.restored'),
            ]);
        }

        return back();
    }

    public function batchDestroy()
    {
        $ids = request('ids');
        $this->callMethods('beforeBatchDestroy', $ids);
        $this->getQueryBuilder()->whereIn('id', $ids)->delete();
        admin()->success(__('merlion::base.batch_delete_success'));
        $this->callMethods('afterBatchDestroy');
        return response([
            'success' => true,
            'action'  => 'refresh',
        ]);
    }
}
