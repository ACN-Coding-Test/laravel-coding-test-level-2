<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

trait PaginateTrait
{
    function setDatatable($request, $query,$sort_by)
    {
        $pageIndex      = $request->pageIndex ? $request->pageIndex : 0;
        $pageSize       = $request->pageSize ? $request->pageSize : 3;
        $sortBy         = $request->sortBy ? $request->sortBy : $sort_by;
        $sortDirection  = $request->sortDirection ? $request->sortDirection :  'ASC';
     
        $query = $query->orderBy($sortBy, $sortDirection);

        $listResult                 = $query->paginate($pageSize, ['*'], 'page', $pageIndex);

        $defaultMeta["page"]        =  $listResult->currentPage();
        $defaultMeta["pages"]       =  $listResult->lastPage();
        $defaultMeta["perpage"]     =  $listResult->perPage();
        $defaultMeta["total"]       =  $listResult->total();
        $defaultMeta["initNumber"]  =  1 + (($listResult->currentPage() - 1) * $listResult->perPage());

        return $listResult;
    }
}