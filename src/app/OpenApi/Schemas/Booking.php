<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Booking",
 *     type="object",
 *     title="Booking",
 *     required={"id", "nama_pelanggan", "email", "nomor_telepon", "jumlah_tamu", "hari", "waktu"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nama_pelanggan", type="string", example="Budi"),
 *     @OA\Property(property="email", type="string", format="email", example="budi@example.com"),
 *     @OA\Property(property="nomor_telepon", type="string", example="+628123456789"),
 *     @OA\Property(property="jumlah_tamu", type="integer", example=4),
 *     @OA\Property(property="hari", type="string", format="date", example="2024-07-22"),
 *     @OA\Property(property="waktu", type="string", format="time", example="19:00:00"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * )
 */
class Booking {}