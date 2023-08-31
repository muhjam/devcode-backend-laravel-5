<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\contact;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('hello', function () {
    return response()->json([
        'message' => 'Hello world'
    ]);
});

Route::get('/contacts', function () {
    $contacts = contact::all();
    return response()->json([
        'status' => 'Success',
        'data' => $contacts,
    ]);
});

// TODO: tambahkan validasi duplicate dan blank
Route::post('/contacts', function (Request $request) {
    $validated = $request->all();
    if(!isset($validated['full_name'])||!isset($validated['phone_number'])||!isset($validated['email'])){
        return response()->json([
            'status'=> 'Failed',
            'message'=> 'full_name, phone_number, and email is required',
        ], 400);
    }

    $isExist = Contact::where('email', $validated['email'])->first();
    if ($isExist) {
        return response()->json([
            'status' => 'Failed',
            'message' => 'full_name, phone_number, and email is duplicate',
        ], 400); 
    }

    $contact = new contact();
    $contact->full_name = $validated['full_name'];
    $contact->phone_number = $validated['phone_number'];
    $contact->email = $validated['email'];
    $contact->save();
    $response = response()->json([
        'status' => 'Success',
        'message' => 'Contact created',
        'data' => $contact,
    ]);
    return $response;
});

// TODO: tambahkan validasi not found dan blank
Route::put('/contacts/{id}', function (Request $request, $id) {
    $isExist = Contact::where('id', $id)->first();   
    if (!$isExist) {
        return response()->json([
            'status' => 'Failed',
            'message' => 'Contact with id '.$id.' is not found',
        ], 400);
    }
    
    if (empty($request['email'])) {
        return response()->json([
            'status' => 'Failed',
            'message' => 'no contact updated',
        ], 400);
    }

    $contact = contact::findOrFail($id);
    $contact->update($request->all());
    
    $response = response()->json([
        'message' => 'Contact updated',
        'status' => 'Success',
        'data' => $contact,
    ]);

    return $response;
});


// TODO: tambahkan validasi not found
Route::delete('/contacts/{id}', function ($id) {
    $isExist = Contact::where('id', $id)->first();   
    if (!$isExist) {
        return response()->json([
            'status' => 'Failed',
            'message' => 'Contact with id '.$id.' is not found',
        ], 400);
    }
    
    $contact = contact::findOrFail($id);
    $contact->delete();
    $response = response()->json([
        'status' => 'Success',
        'message' => 'Contact deleted',
        'deletedId'=> $contact->id,
    ]);
    return $response;
});