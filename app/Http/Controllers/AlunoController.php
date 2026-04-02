<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class AlunoController extends Controller
{
    public function select(){
        echo "<h1>SELECT</h1>";
    }

    public function insert(){
        echo "<h1>INSERT</h1>";
    }

    public function update(){
        echo "<h1>UPDATE</h1>";
    }

    public function delete(){
        echo "<h1>DELETE</h1>";
    }

    public function sql(){
    
    }

}
