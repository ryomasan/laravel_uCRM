<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'kana', 'tel', 'email', 'birthday', 'address', 'postcode', 'gender', 'memo'];
    public function scopeSearchedCustomers($query, $input = null)
    {
        if (!empty($input)) {
            if (Customer::where('name', 'like', $input . '%')
                ->orWhere('kana', 'like', $input . '%')
                ->orWhere('tel', 'like', $input . '%')->exists()
            ) {
                return $query->where('name', 'like', $input . '%')
                    ->orWhere('kana', 'like', $input . '%')
                    ->orWhere('tel', 'like', $input . '%');
            }
        }
    }
}
