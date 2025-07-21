<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="BookkingMenu",
 *     type="object",
 *     title="BookkingMenu",
 *     required={"id", "booking_id", "menu_id", "quantity"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="booking_id", type="integer", example=1, description="Foreign key ke tabel bookings"),
 *     @OA\Property(property="menu_id", type="integer", example=1, description="Foreign key ke tabel menus"),
 *     @OA\Property(property="quantity", type="integer", example=2),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * )
 */
class BookkingMenu {}