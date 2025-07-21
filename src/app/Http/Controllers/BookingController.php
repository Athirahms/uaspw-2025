<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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

class BookingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/bookings",
     *     operationId="getbookings",
     *     tags={"bookings"},
     *     summary="Get all bookings",
     *     description="Returns a list of all bookings.",
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
     *                 @OA\Items(ref="#/components/schemas/booking")
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
        $data = Booking::all();

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
     *     path="/api/bookings",
     *     operationId="storebooking",
     *     tags={"bookings"},
     *     summary="Create a new booking",
     *     description="Stores a new booking and returns the encrypted response.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price"},
     *             @OA\Property(property="name", type="string", example="booking A"),
     *             @OA\Property(property="price", type="number", format="float", example=199.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="booking created",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error storing booking",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error storing booking: ...")
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
            $Booking = Booking::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
            ]);

            $responseData = [
                'message' => 'Booking created successfully',
                'data' => $Booking,
            ];

            $encryptedResponse = EncryptionHelper::encrypt(json_encode($responseData));

            return response()->json(['data' => $encryptedResponse]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error storing Booking: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/bookings/{id}",
     *     operationId="getbookingById",
     *     tags={"bookings"},
     *     summary="Get a booking by ID",
     *     description="Returns a single booking",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="booking ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="booking not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function show($id)
    {
        $Booking = Booking::find($id);

        if (!$Booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $responseData = [
            'message' => 'success',
            'data' => $Booking,
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Put(
     *     path="/api/bookings/{id}",
     *     operationId="updatebooking",
     *     tags={"bookings"},
     *     summary="Update a booking",
     *     description="Updates an existing booking",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="booking ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated booking"),
     *             @OA\Property(property="price", type="number", format="float", example=299.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="booking updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="booking not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        $Booking = Booking::find($id);

        if (!$Booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
        ]);

        $Booking->update($validated);

        $responseData = [
            'message' => 'Booking updated successfully',
            'data' => $Booking,
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Delete(
     *     path="/api/bookings/{id}",
     *     operationId="deletebooking",
     *     tags={"bookings"},
     *     summary="Delete a booking",
     *     description="Deletes a booking by ID",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="booking ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="booking deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="eyJpdiI6In...")
     *         )
     *     ),
     *     @OA\Response(response=404, description="booking not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function destroy($id)
    {
        $Booking = Booking::find($id);

        if (!$Booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $Booking->delete();

        $responseData = [
            'message' => 'Booking deleted successfully',
            'data' => ['id' => $id],
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($responseData));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Post(
     *     path="/api/bookings/decrypt",
     *     operationId="decryptbookingResponse",
     *     tags={"bookings"},
     *     summary="Decrypt encrypted booking data",
     *     description="Decrypts the encrypted booking response.",
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
     *                 @OA\Items(ref="#/components/schemas/booking")
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
