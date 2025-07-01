<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use App\Notifications\ContactRepliedNotification;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //authentication except home page for public view
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //retrieving data to display in home page
        $books              = Book::latest('created_at')->paginate(6);
        $featuredCategories = Category::latest('created_at')->paginate(6);
        $featuredBooks      = Book::inRandomOrder()->take(6)->get();                   // random featured books
        $popularBooks       = Book::orderBy('download_count', 'desc')->take(6)->get(); // example based on views
        $categories         = Category::all();

      $user = Auth::user();

    if ($user && $user->unreadNotifications->where('type', ContactRepliedNotification::class)->isNotEmpty()) {
        session()->flash('replied_notification', 'An admin has replied to your contact message!');
        $user->unreadNotifications
            ->where('type', ContactRepliedNotification::class)
            ->each(fn($n) => $n->markAsRead());
    }
        return view('home', compact('books', 'featuredBooks', 'popularBooks', 'categories', 'featuredCategories'));
    }
}

