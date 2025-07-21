<?php

namespace App\Http\Controllers;

use App\Models\BookkingMenu;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Helper\EncryptionHelper;

class BookkingMenuController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/BookkingMenus",
     *     operationId="getBookkingMenus",
     *     tags={"BookkingMenus"},
     *     summary="Get all BookkingMenus",
     *     description="Returns a list of all BookkingMenus.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/BookkingMenu")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid API Key"
     *     )
     * )
     */
    public function index()
    {
        $data = BookkingMenu::all();

        $responseData = [
            'message' => 'success',
            'data' => $data,
        ];

        $encryptResponse = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json([
            'data' => $encryptResponse,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/BookkingMenus",
     *     operationId="storeBookkingMenu",
     *     tags={"BookkingMenus"},
     *     summary="Create a new BookkingMenu",
     *     description="Stores a new BookkingMenu and returns the encrypted response.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price"},
     *             @OA\Property(property="name", type="string", example="BookkingMenu A"),
     *             @OA\Property(property="price", type="number", format="float", example=199.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="BookkingMenu created",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error storing BookkingMenu",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error storing BookkingMenu: ...")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        try {
            $BookkingMenu = BookkingMenu::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
            ]);

            $responseData = [
                'message' => 'BookkingMenu created successfully',
                'data' => $BookkingMenu,
            ];

            $encryptedResponse = EncryptionHelper::encrypt(json_encode($responseData));

            return response()->json(['data' => $encryptedResponse]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error storing BookkingMenu: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/BookkingMenus/{id}",
     *     operationId="getBookkingMenuById",
     *     tags={"BookkingMenus"},
     *     summary="Get a BookkingMenu by ID",
     *     description="Returns a single BookkingMenu",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="BookkingMenu ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="BookkingMenu not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function show($id)
    {
        $BookkingMenu = BookkingMenu::find($id);

        if (!$BookkingMenu) {
            return response()->json(['message' => 'BookkingMenu not found'], 404);
        }

        $responseData = [
            'message' => 'success',
            'data' => $BookkingMenu,
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Put(
     *     path="/api/BookkingMenus/{id}",
     *     operationId="updateBookkingMenu",
     *     tags={"BookkingMenus"},
     *     summary="Update a BookkingMenu",
     *     description="Updates an existing BookkingMenu",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="BookkingMenu ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated BookkingMenu"),
     *             @OA\Property(property="price", type="number", format="float", example=299.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="BookkingMenu updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="BookkingMenu not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        $BookkingMenu = BookkingMenu::find($id);

        if (!$BookkingMenu) {
            return response()->json(['message' => 'BookkingMenu not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
        ]);

        $BookkingMenu->update($validated);

        $responseData = [
            'message' => 'BookkingMenu updated successfully',
            'data' => $BookkingMenu,
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Delete(
     *     path="/api/BookkingMenus/{id}",
     *     operationId="deleteBookkingMenu",
     *     tags={"BookkingMenus"},
     *     summary="Delete a BookkingMenu",
     *     description="Deletes a BookkingMenu by ID",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="BookkingMenu ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="BookkingMenu deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="BookkingMenu not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function destroy($id)
    {
        $BookkingMenu = BookkingMenu::find($id);

        if (!$BookkingMenu) {
            return response()->json(['message' => 'BookkingMenu not found'], 404);
        }

        $BookkingMenu->delete();

        $responseData = [
            'message' => 'BookkingMenu deleted successfully',
            'data' => ['id' => $id],
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Post(
     *     path="/api/BookkingMenus/decrypt",
     *     operationId="decryptBookkingMenuResponse",
     *     tags={"BookkingMenus"},
     *     summary="Decrypt encrypted BookkingMenu data",
     *     description="Decrypts the encrypted BookkingMenu response.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"data"},
     *             @OA\Property(property="data", type="string", example="eyJpdiI6IjFPU2h...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Decrypted response",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/BookkingMenu")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Decryption failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Decrypt Failed"),
     *             @OA\Property(property="error", type="string", example="The payload is invalid.")
     *         )
     *     )
     * )
     */
    public function decryptResponse(Request $request)
    {
        $encryptData = $request->input('data');

        try {
            $decryptedJson = EncryptionHelper::decrypt($encryptData);
            $decoded = json_decode($decryptedJson, true);

            return response()->json($decoded);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Decrypt Failed',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

}
