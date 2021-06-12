<?php

namespace App\Http\Controllers\Base;

use App\Resources\Base\SuccessResource;
use App\Services\Base\BaseServiceInterface;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    protected $service;
    protected $storeRequestFile;
    protected $updateRequestFile;
    protected $relations = [];
    protected $resource;
    protected $pagination;
    protected $scopes = [];

    public function __construct(BaseServiceInterface $service)
    {
        $this->service = $service;
        $this->constructRepository();
    }

    public function index()
    {
        return $this->service->index();
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        return new SuccessResource($data);
    }

    public function store()
    {
        $request = $this->storeRequestFile ? resolve($this->storeRequestFile) : request();
        $data = $this->service->store($request->all());

        return new SuccessResource($data, __('general.success_create'), Response::HTTP_CREATED);
    }

    public function update($id)
    {
        $request = $this->updateRequestFile ? resolve($this->updateRequestFile) : request();
        $this->service->update($request->all(), $id);

        return new SuccessResource([], __('general.success_update'), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return new SuccessResource([], __('general.success_distroy'), Response::HTTP_OK);
    }

    private function constructRepository()
    {
        $this->service->setRelations($this->relations);
        $this->service->setResource($this->resource);
        $this->service->setPagination(request('per_page') ?? ($this->pagination ?? 20));
        $this->service->setScopes($this->scopes);
    }
}
