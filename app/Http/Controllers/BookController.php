<?php


namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JeroenNoten\LaravelAdminLte\View\Components\Tool\Datatable;

class BookController extends Controller
{
public function index(Request $request)
{
    if ($request->ajax()) {
        $books = Book::with('author', 'category')->select('books.*');

        return DataTables::of($books)
            ->addColumn('author_name', fn($book) => $book->author->name ?? 'Unknown')
            ->addColumn('category_name', fn($book) => $book->category->name ?? 'Unknown')
            ->addColumn('action', function ($row) {
                return view('books.partials.actions', compact('row'))->render();
            })
            ->rawColumns(['action']) //makes render in action
            ->make(true);
    }

    return view('books.index');
}



public function create(){
    $authors= Author::all();
    $categories=Category::all();
    return view('admin.books.create',compact('authors','categories'));

}


public function store(Request $request)
{
    $request->validate([
        'title'=>'required|string|max:255',
        'description'=>'required',
        'author_id'=>'required|exists:authors,id',
        'category_id'=>'required|exists:categorues,id',
        'published_at'=>'nullable|date',
        'uploaded_at'=>'nullable|date',
        'file_path'=>'required|string|max:10240',
        'cover_image'=>'nullable|image|mimes:jpg,png,jpeg|max:2048' //mimes to identify the type of the file
    ]);
    $data= $request->except('cover_image','file_path');
    if ($request->hasFile('cover_image')){
        $data['cover_image']=$request->file('cover_image')->store('covers','public');

    }
    if($request->except('file_path')){
        $data['file_path']=$request->file('file_path')->store('books','public');
    }
    Book::create($data);
    return redirect()->route('books.index')->with('success','Book creates!');
}


public function update(Request $request,Book $book){

 $request->validate([
        'title'=>'required|string|max:255',
        'description'=>'required',
        'author_id'=>'required|exists:authors,id',
        'category_id'=>'required|exists:categorues,id',
        'published_at'=>'nullable|date',
        'uploaded_at'=>'nullable|date',
        'file_path'=>'required|string|max:10240',
        'cover_image'=>'nullable|image|mimes:jpg,png,jpeg|max:2048' //mimes to identify the type of the file
    ]);
    $data= $request->except('cover_image','file_path');
    if ($request->hasFile('cover_image')){
        $data['cover_image']=$request->file('cover_image')->store('covers','public');

    }
    if($request->except('file_path')){
        $data['file_path']=$request->file('file_path')->store('books','public');
    }
    Book::create($data);
    return redirect()->route('books.index')->with('success','Book creates!');
}
public function show(Book $book){
    return view('books.show',compact('books'))->with('',$book);
}


public function destroy(Book $book){
    $book->delete();
    return redirect()->route('books.index')->with('success','Book is archived');
}

public function edit(){
    $authors=Author::all();
    $categories=Category::all();
    return view('books.edit',compact('book', 'authors', 'categories'));
}
public function download(Book $book)
{
    $book->increment ('down_count');
    $file=storage_path('app/public/'. $book->file_path);
    if(!file_exists($file)){
        abort(404,'File not Found!');
}
return response()->download($file,$book->title.'.pdf');
}
}
