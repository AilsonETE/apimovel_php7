<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
    use HasFactory;
     protected $table = 'imoveis';
     protected $fillable = ['user_id', 'titulo', 'descricao', 'conteudo',
     'preco', 'banheiro', 'quarto', 'area_propriedade', 
                'total_area_propriedade', 'slug'];
   
   
    // chamando o relacionamento no modelo
  
  
    public function user(){
     return $this->belongsTo(User::class);
     }
   
     public function categoria(){
        return $this->belongsToMany(Catagoria::class, 'imoveis_categorias');
        }
        
    
}
