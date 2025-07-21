<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Helper\EncryptionHelper;

class MenuController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/Menus",
     *     operationId="getMenus",
     *     tags={"Menus"},
     *     summary="Get all Menus",
     *     description="Returns a list of all Menus.",
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
     *                 @OA\Items(ref="#/components/schemas/Menu")
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
        $data = Menu::all();

        $responseData = [
            'message' => 'success',
            'data' => $data,
        ];

        $encryptResponse = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json([
            'data' => $encryptResponse,
        ]);
        $items = Menu::all(); // ambil semua menu
        return view('livewire.home-page', compact('items'));

    }

    /**
     * @OA\Post(
     *     path="/api/Menus",
     *     operationId="storeMenu",
     *     tags={"Menus"},
     *     summary="Create a new Menu",
     *     description="Stores a new Menu and returns the encrypted response.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price"},
     *             @OA\Property(property="name", type="string", example="Menu A"),
     *             @OA\Property(property="price", type="number", format="float", example=199.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu created",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error storing Menu",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error storing Menu: ...")
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
            $Menu = Menu::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
            ]);

            $responseData = [
                'message' => 'Menu created successfully',
                'data' => $Menu,
            ];

            $encryptedResponse = EncryptionHelper::encrypt(json_encode($responseData));

            return response()->json(['data' => $encryptedResponse]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error storing Menu: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/Menus/{id}",
     *     operationId="getMenuById",
     *     tags={"Menus"},
     *     summary="Get a Menu by ID",
     *     description="Returns a single Menu",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Menu ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Menu not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function show($id)
    {
        $Menu = Menu::find($id);

        if (!$Menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $responseData = [
            'message' => 'success',
            'data' => $Menu,
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Put(
     *     path="/api/Menus/{id}",
     *     operationId="updateMenu",
     *     tags={"Menus"},
     *     summary="Update a Menu",
     *     description="Updates an existing Menu",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Menu ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Menu"),
     *             @OA\Property(property="price", type="number", format="float", example=299.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Menu not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        $Menu = Menu::find($id);

        if (!$Menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
        ]);

        $Menu->update($validated);

        $responseData = [
            'message' => 'Menu updated successfully',
            'data' => $Menu,
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Delete(
     *     path="/api/Menus/{id}",
     *     operationId="deleteMenu",
     *     tags={"Menus"},
     *     summary="Delete a Menu",
     *     description="Deletes a Menu by ID",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Menu ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Menu not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function destroy($id)
    {
        $Menu = Menu::find($id);

        if (!$Menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $Menu->delete();

        $responseData = [
            'message' => 'Menu deleted successfully',
            'data' => ['id' => $id],
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Post(
     *     path="/api/Menus/decrypt",
     *     operationId="decryptMenuResponse",
     *     tags={"Menus"},
     *     summary="Decrypt encrypted Menu data",
     *     description="Decrypts the encrypted Menu response.",
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
     *                 @OA\Items(ref="#/components/schemas/Menu")
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
