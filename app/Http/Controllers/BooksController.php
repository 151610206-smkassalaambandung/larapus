<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use App\Book;

class BooksController extends Controller
{
    public function index(Request $request, Builder $htmlBuilder)
    {
    	if ($request->ajax()){
    		$books = Book::with('author');
    		return Datatables::of($books)
    			->addColumn('action', function($book){
    				return view('datatable._action',[
    					'model'				=> $book,
    					'form_url'			=> route('books.destroy', $book->id),
    					'edit_url'			=> route('books.edit', $book->id),
    					'confirm_message'	=> 'Yakin mau menghapus'. $book->title. '?'
    					]);
    			})->make(true);
    	}

		$html = $htmlBuilder
			->addColumn(['data'=>'title','name'=>'title','title'=>'judul'])
			->addColumn(['data'=>'amount','name'=>'amount','title'=>'jumlah'])
			->addColumn(['data'=>'author.name','name'=>'author.name','title'=>'penulis'])
			->addColumn(['data'=>'action','name'=>'action','title'=> '','orderable'=>false,'archable'=>false]);

				return view('books.index')->with(compact('html'));    	
    }

    public function create()
    {
    	return view('books.create');
    }
}
