<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\SettingCreateRequest;
use App\Http\Requests\SettingUpdateRequest;
use App\Repositories\SettingRepository;
use App\Validators\SettingValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use function app;
use function redirect;
use function request;
use function response;
use function view;

/**
 * Class SettingsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SettingsController extends Controller
{
    /**
     * @var SettingRepository
     */
    protected $repository;

    /**
     * @var SettingValidator
     */
    protected $validator;

    /**
     * SettingsController constructor.
     *
     * @param SettingRepository $repository
     * @param SettingValidator $validator
     */
    public function __construct(SettingRepository $repository, SettingValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $settings = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $settings,
            ]);
        }

        return view('settings.index', compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SettingCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SettingCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $setting = $this->repository->create($request->all());

            $response = [
                'message' => 'Setting created.',
                'data'    => $setting->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $setting = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $setting,
            ]);
        }

        return view('settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = $this->repository->find($id);

        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SettingUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SettingUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $setting = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Setting updated.',
                'data'    => $setting->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Setting deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Setting deleted.');
    }
}
