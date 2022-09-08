<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskItemCreateRequest;
use App\Http\Requests\TaskItemUpdateRequest;
use App\Repositories\TaskItemRepository;
use App\Validators\TaskItemValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use function app;
use function redirect;
use function request;
use function response;
use function view;

/**
 * Class TaskItemsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TaskItemsController extends Controller
{
    /**
     * @var TaskItemRepository
     */
    protected $repository;

    /**
     * @var TaskItemValidator
     */
    protected $validator;

    /**
     * TaskItemsController constructor.
     *
     * @param TaskItemRepository $repository
     * @param TaskItemValidator $validator
     */
    public function __construct(TaskItemRepository $repository, TaskItemValidator $validator)
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
        $taskItems = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $taskItems,
            ]);
        }

        return view('taskItems.index', compact('taskItems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TaskItemCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TaskItemCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $taskItem = $this->repository->create($request->all());

            $response = [
                'message' => 'TaskItem created.',
                'data'    => $taskItem->toArray(),
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
        $taskItem = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $taskItem,
            ]);
        }

        return view('taskItems.show', compact('taskItem'));
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
        $taskItem = $this->repository->find($id);

        return view('taskItems.edit', compact('taskItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TaskItemUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TaskItemUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $taskItem = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TaskItem updated.',
                'data'    => $taskItem->toArray(),
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
                'message' => 'TaskItem deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TaskItem deleted.');
    }
}
