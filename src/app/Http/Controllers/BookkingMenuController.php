<?php

namespace App\Http\Controllers;

use App\Models\BookkingMenu;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Helper\EncryptionHelper;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="Dokumentasi API Uji Coba"
 * )
 */

class BookkingMenuController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/bookking_menus",
     *     operationId="getbookking_menus",
     *     tags={"bookking_menus"},
     *     summary="Get all bookking_menus",
     *     description="Returns a list of all bookking_menus.",
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
     *                 @OA\Items(ref="#/components/schemas/bookking_menu")
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
     *     path="/api/bookking_menus",
     *     operationId="storebookking_menu",
     *     tags={"bookking_menus"},
     *     summary="Create a new bookking_menu",
     *     description="Stores a new bookking_menu and returns the encrypted response.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price"},
     *             @OA\Property(property="name", type="string", example="bookking_menu A"),
     *             @OA\Property(property="price", type="number", format="float", example=199.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="bookking_menu created",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error storing bookking_menu",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error storing bookking_menu: ...")
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
     *     path="/api/bookking_menus/{id}",
     *     operationId="getbookking_menuById",
     *     tags={"bookking_menus"},
     *     summary="Get a bookking_menu by ID",
     *     description="Returns a single bookking_menu",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="bookking_menu ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="bookking_menu not found"),
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
     *     path="/api/bookking_menus/{id}",
     *     operationId="updatebookking_menu",
     *     tags={"bookking_menus"},
     *     summary="Update a bookking_menu",
     *     description="Updates an existing bookking_menu",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="bookking_menu ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated bookking_menu"),
     *             @OA\Property(property="price", type="number", format="float", example=299.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="bookking_menu updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="bookking_menu not found"),
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
     *     path="/api/bookking_menus/{id}",
     *     operationId="deletebookking_menu",
     *     tags={"bookking_menus"},
     *     summary="Delete a bookking_menu",
     *     description="Deletes a bookking_menu by ID",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="bookking_menu ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="bookking_menu deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="bookking_menu not found"),
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
     *     path="/api/bookking_menus/decrypt",
     *     operationId="decryptbookking_menuResponse",
     *     tags={"bookking_menus"},
     *     summary="Decrypt encrypted bookking_menu data",
     *     description="Decrypts the encrypted bookking_menu response.",
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
     *                 @OA\Items(ref="#/components/schemas/bookking_menu")
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
