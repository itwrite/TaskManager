<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Repositories\TaskRepository;
use App\Validators\TaskValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use function app;
use function redirect;
use function request;
use function response;
use function view;

/**
 * Class TasksController.
 *
 * @package namespace App\Http\Controllers;
 */
class TasksController extends Controller
{
    /**
     * @var TaskRepository
     */
    protected $repository;

    /**
     * @var TaskValidator
     */
    protected $validator;

    /**
     * TasksController constructor.
     *
     * @param TaskRepository $repository
     * @param TaskValidator $validator
     */
    public function __construct(TaskRepository $repository, TaskValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }
}
