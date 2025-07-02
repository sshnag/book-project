<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ContactRepliedNotification;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     * Applies auth middleware except for the home page.
     * Allows public viewing of the home page.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Show the application home page with latest, featured, and popular books.
     * Categories are also loaded for user browsing.
     * @author - SSA
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $books              = Book::latest('created_at')->paginate(6);
        $featuredCategories = Category::latest('created_at')->paginate(6);
        $featuredBooks      = Book::inRandomOrder()->take(6)->get();
        $popularBooks       = Book::orderBy('download_count', 'desc')->take(6)->get();
        $categories         = Category::all();

        $user = Auth::user();

        //  to notify user of unread contact replies
        // if ($user && $user->unreadNotifications->where('type', ContactRepliedNotification::class)->isNotEmpty()) {
        //     session()->flash('replied_notification', 'An admin has replied to your contact message!');
        //     $user->unreadNotifications
        //         ->where('type', ContactRepliedNotification::class)
        //         ->each(fn($n) => $n->markAsRead());
        // }

        return view('home', compact('books', 'featuredBooks', 'popularBooks', 'categories', 'featuredCategories'));
    }
}
