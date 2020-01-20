<?php

namespace Quyen\Cmspackage;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Quyen\Cmspackage\AdminHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $baseModel;
    public $route;
    public $validateRule = [];
    public $filterHtml = [];

    public function ajaxRespond($code, $message='', $data=[])
    {

        return Response::json(
            [
            'code' => $code,
            'message' => $message,
            'data' => $data,
            ]
        );
    }

    public function processDataTable(Request $request, $items)
    {   
        //Update list status field
        if ($request->ajax() && $request->action == 'update_status_list') {
            $this->authorize('permission', $this->route.'.publish');
            
            $ids = explode(",", $request->id);
            $this->baseModel->whereIn('id', $ids)->update(
                [$request->field => $request->value]
            );

            return $this->ajaxRespond(1, '', AdminHelper::statusGroup($request->field, $request->id, $request->value));
        }

        // Update status field
        if ($request->ajax() && $request->action == 'update_status') {
            $this->authorize('permission', $this->route.'.publish');

            $this->baseModel->find($request->id)->update(
                [$request->field => $request->value]
            );

            return $this->ajaxRespond(1, '', AdminHelper::statusGroup($request->field, $request->id, $request->value));
        }

        // Update yesno field
        if ($request->ajax() && $request->action == 'update_yesno') {
            $this->baseModel->find($request->id)->update(
                [$request->field => $request->value]
            );

            return $this->ajaxRespond(1, '', AdminHelper::yesNoGroup($request->field, $request->id, $request->value));
        }

        // Update default field
        if ($request->ajax() && $request->action == 'update_default') {
            $this->baseModel->where('default', 1)->update(
                [$request->field => 0]
            );

            $this->baseModel->find($request->id)->update(
                [$request->field => 1]
            );

            return $this->ajaxRespond(1, '', AdminHelper::defaultGroup($request->field, $request->id, $request->value));
        }

        // Update ordering field
        if ($request->ajax() && $request->action == 'update_ordering') {
            $this->baseModel->setOrder($request->id, $request->value);

            return $this->ajaxRespond(1, '', AdminHelper::orderingBtn($request->field, $request->id, $request->value));
        }

        // Reload data table
        if ($request->ajax()) {
            return $this->ajaxRespond(
                1,
                '',
                view($this->route . '.index_table')
                    ->with('route', $this->route)
                    ->with('items', $items)
                    ->render()
            );
        }
    }

    public function filterData($request)
    {
        // Trim all input
        $allFields = $request->all();
        foreach ($allFields as $k => &$field) {
            if (is_string($field)) {
                $field = trim($field);
                $request->merge([$k => $field]);
            }
        }

        // Filter string data
        if ($this->baseModel) {
            $fields = $this->baseModel->getFillable();
            foreach ($fields as $field) {
                if (!$request->input($field, '')) { continue;
                }

                if (in_array($field, $this->filterHtml)) {
                    // Clean html

                }else{
                    // Clean tags
                    $request->merge([$field => strip_tags($request->input($field, ''))]);
                }
            }
        }
    }

    public function getCreateItem($request)
    {
        $item = (object) $request->old();
        $item->id = 0;
        $fields = $this->baseModel->getFillable();
        foreach ($fields as $field) {
            if (!isset($item->{$field})) {
                $item->{$field} = null;
            }
        }

        return $item;
    }
}
