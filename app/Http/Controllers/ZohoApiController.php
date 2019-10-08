<?php

namespace App\Http\Controllers;

use App\Services\ZohoApiService;
use App\Http\Requests\{DealRequest, TaskRequest};
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ZohoApiController extends Controller
{
    /**
     * @var ZohoApiService
     */
    private $apiService;

    /**
     * Controller constructor
     *
     * @param ZohoApiService $apiService
     */
    public function __construct(ZohoApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Action index
     *
     * @return View
     */
    public function index(): View
    {
        return view('welcome', [
            'getCodeUrl' => $this->apiService->getCodeUrl(),
        ]);
    }

    /**
     * Create deal action
     *
     * @param  DealRequest $request
     * @return RedirectResponse
     */
    public function dealCreate(DealRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->apiService->dealCreate($validated);

        return redirect()->route('home');
    }

    /**
     * Create task action
     *
     * @param  TaskRequest $request
     * @return RedirectResponse
     */
    public function taskCreate(TaskRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->apiService->taskCreate($validated);

        return redirect()->route('home');
    }

    /**
     * Action callback
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function callback(Request $request): RedirectResponse
    {
        if ($code = $request->get('code', false)) {
            $this->apiService->generateToken($code);
        }

        return redirect()->route('home');
    }
}
