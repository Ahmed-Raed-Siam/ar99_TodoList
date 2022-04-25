<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(): mixed
    {
//        $items = Item::orderBy('created_at', 'desc')->paginate();
        return Item::orderBy('created_at', 'desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
//        dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'unique:items,name'],
//            'completed_at' => ['required', 'numeric'],
        ]);

        $item_name = $request->post('name');

        $item = Item::create([
            'name' => $item_name,
        ]);

        $message = 'New Item added successfully>';

        return response()->json([
            'data' => [
                'status_code' => Response::HTTP_CREATED,
                'message' => $message,
                'item' => $item,
            ],
        ], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $item = Item::find($id);
        $status_code = Response::HTTP_OK;

//        dd(
//          $request->all()
//        );

        if ($item === null):
            $message = 'Wrong Request ! Item Not Exists.';
            return response()->json([
                'data' => [
                    'status_code' => Response::HTTP_NOT_FOUND,
//                    'status_code' => http_response_code(),
                    'message' => $message,
                ],
            ], Response::HTTP_NOT_FOUND);
        endif;

        $request->validate([
            'name' => [
                'nullable',
                'string',
                Rule::unique('items', 'name')->ignore($item->id),
            ],
            'completed' => [
                'nullable',
                'boolean',
            ],
            'completed_at' => [
                'nullable',
                'date',
                Rule::unique('items', 'completed_at')->ignore($item->id),
            ],
        ]);

        $item_name_model = $item->name;
        $item_completed_model = $item->completed;
        $item_completed_at_model = $item->completed;

        $item_new_model = [];

        if ($request->post('name') && $request->post('name') !== $item_name_model):
            $item_new_model['name'] = $request->post('name');
        endif;

        if ($request->post('completed') !== null && (int)$request->post('completed') !== $item_completed_model):
//            dd('is Not Nullyy');
            $item_new_model['completed'] = (int)$request->post('completed');
        endif;

        if ($request->post('completed_at') && ($request->post('completed_at') !== $item_completed_at_model)):
            $item_new_model['completed_at'] = $request->post('completed_at');
        endif;

        $message = "Noting to be updated!";

//        dd(
//            count($item_new_model),
//            $item_new_model,
//        );

        /*If inputs is different from the original  Just Update */
        if (count($item_new_model) > 0):
            $item->update($item_new_model);
            $message = "$item_name_model item updated to {$request->post('name')} successfully>";
            $status_code = Response::HTTP_OK;
        endif;

        return response()->json([
            'data' => [
//                'item_new_model' => $item_new_model,
                'status_code' => $status_code,
                'message' => $message,
                'item' => $item,
            ],
        ], $status_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $item = Item::find($id);
        $data = [];

        if ($item === null):
            $data['message'] = 'Wrong Request ! Item Not Exists.';
            $data['status_code'] = Response::HTTP_NOT_FOUND;
        else:
            $item_name = $item->name;
            $data['message'] = "$item_name item deleted successfully>";
            $data['status_code'] = Response::HTTP_OK;
            $item->delete();
        endif;


        return response()->json([
            'data' => $data
        ], $data['status_code']);

    }
}
