<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
 use HasFactory;

 protected $table ='usuarios';
 protected $primaryKey ='usu_id';

 protected $fillable=[
    'usu_nome',
    'usu_email',
    'usu_senha'
 ];

 public function produtos()
 {
    return $this->hasMany(Produtos::class, 'usu_id', 'usu_id');
 }

 public function dashboard()
 {
    return $this->hasOne(Dashboard::class, 'usuario_id', 'usu_id');
 }

 public function account()
 {
    return $this->hasOne(Account::class, 'usuario_id', 'usu_id');
 }

}