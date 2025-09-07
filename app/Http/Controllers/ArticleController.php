<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
        public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('backend.cms.article.index', compact('articles'));
    }

    public function create()
    {
        $categories = Article::all();
        return view('backend.cms.article.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'nep_heading' => 'nullable|string|max:255',
            'article_category_id' => 'required|exists:article_categories,id',
            'body' => 'required|string',
            'nep_body' => 'nullable|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_status' => 'nullable|boolean'
        ]);

        try {
            // Generate unique slug
            $slug = Str::slug($validated['heading']);
            $originalSlug = $slug;
            $counter = 1;
            while (Article::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $validated['slug'] = $slug;

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePaths = [];
                foreach ($request->file('image') as $image) {
                    $path = $image->store('articles', 'public');
                    $imagePaths[] = $path;
                }
                $validated['image'] = json_encode($imagePaths);
            } else {
                $validated['image'] = json_encode([]);
            }

            Article::create($validated);

            return redirect()->route('articles.index')->with('success', 'Article created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Article $article)
    {
        return $article;
    }

    public function edit(Article $article)
    {
        $categories = Article::all();
        $article->images = json_decode($article->image, true) ?? [];
        return view('backend.cms.article.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'nep_heading' => 'nullable|string|max:255',
            'article_category_id' => 'required|exists:article_categories,id',
            'body' => 'required|string',
            'nep_body' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'removed_images' => 'nullable|array',
            'removed_images.*' => 'string',
        ]);

        // Decode old images
        $existingImages = json_decode($article->image, true) ?? [];

        // Get removed images
        $removedImages = $request->input('removed_images', []);

        // Remove deleted images from array and storage
        $updatedImages = array_filter($existingImages, function ($img) use ($removedImages) {
            return !in_array($img, $removedImages);
        });

        foreach ($removedImages as $img) {
            if (Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }
        }

        // Upload new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('articles', 'public');
                $updatedImages[] = $path;
            }
        }

        // Save all data
        $article->heading = $request->heading;
        $article->nep_heading = $request->nep_heading;
        $article->article_category_id = $request->article_category_id;
        $article->body = $request->body;
        $article->nep_body = $request->nep_body;
        $article->image = json_encode(array_values($updatedImages));
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article)
    {
        $images = json_decode($article->image, true) ?? [];

        // Delete images from public folder
        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }

        $article->delete();

        return redirect()->back()->with('success', 'Article deleted successfully');
    }

    public function statusupdate($id)
    {
        $article = Article::findOrFail($id);
        $article->published_status = !$article->published_status;
        $article->save();

        return redirect()->back()->with('success', 'Article status updated successfully.');
    }
}
