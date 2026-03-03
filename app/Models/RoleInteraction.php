<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleInteraction extends Model
{
    protected $fillable = ['role_key', 'ip_address', 'type', 'updated_at'];

    /**
     * Benzersiz IP tıklaması kaydet.
     */
    public static function logClick(string $roleKey, string $ipAddress): void
    {
        try {
            static::updateOrCreate(
                ['role_key' => $roleKey, 'ip_address' => $ipAddress, 'type' => 'click'],
                ['updated_at' => now()]
            );
        } catch (\Exception $e) {
            // Unique constraint hatası gelirse (zaten tıklandıysa) bir şey yapma
        }
    }

    /**
     * Rol bazlı benzersiz tıklama (ilgi) sayısını getir.
     */
    public static function getUniqueClicks(string $roleKey): int
    {
        return static::where('role_key', $roleKey)->where('type', 'click')->count();
    }

    /**
     * Rol bazlı gerçek kayıt (kota) sayısını getir.
     */
    public static function getRegistrations(string $roleKey): int
    {
        return static::where('role_key', $roleKey)->where('type', 'registration')->count();
    }
}
