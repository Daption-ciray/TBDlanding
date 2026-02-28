<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleClick extends Model
{
    protected $fillable = ['role_key', 'click_count'];
    
    // role_key'i id gibi kullanmak istiyoruz ama id'miz de var. 
    // Pratiklik için role_key üzerinden erişelim.
    public static function incrementRole(string $roleKey): void
    {
        static::updateOrCreate(
            ['role_key' => $roleKey],
            ['click_count' => \DB::raw('click_count + 1')]
        );
    }
}
