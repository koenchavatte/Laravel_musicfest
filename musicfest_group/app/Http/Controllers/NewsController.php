<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the news items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsItems = News::orderBy('published_at', 'desc')->get();
        return view('news.index', compact('newsItems'));
    }

    /**
     * Show the form for creating a new news item.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created news item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'content' => 'required|string',
            'published_at' => 'required|date',
        ]);

        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;
        $news->published_at = $request->published_at;
        $news->user_id = Auth::id();

        if ($request->hasFile('cover_image')) {
            $news->cover_image = $request->file('cover_image')->store('cover_images', 'public');
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'News item created successfully.');
    }

    /**
     * Display the specified news item.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news item.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified news item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'content' => 'required|string',
            'published_at' => 'required|date',
        ]);

        $news->title = $request->title;
        $news->content = $request->content;
        $news->published_at = $request->published_at;

        if ($request->hasFile('cover_image')) {
            // Verwijder de oude afbeelding als er een nieuwe wordt geüpload...
            if ($news->cover_image) {
                Storage::disk('public')->delete($news->cover_image);
            }

            $news->cover_image = $request->file('cover_image')->store('cover_images', 'public');
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'News item updated successfully.');
    }

    /**
     * Remove the specified news item from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        // Verwijder de afbeelding van de opslag als deze bestaat anders problemz
        if ($news->cover_image) {
            Storage::disk('public')->delete($news->cover_image);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'News item deleted successfully.');
    }
}
