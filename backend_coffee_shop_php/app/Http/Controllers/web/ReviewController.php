<?php

namespace App\Http\Controllers\web;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $reviewsQuery = Review::query()->latest();

        if ($search !== '') {
            $reviewsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('comment', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('id', 'like', $search);
            });
        }

        $pagination_limit = pagination_limit();

        $reviews = $reviewsQuery->paginate($pagination_limit)->appends(['search' => $search]);

        return view('review-admin', compact('reviews'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('review-client');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'rating'  => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'name'    => 'required|string|max:255',
            'phone'   => [
                'nullable',
                'regex:/^(?:\+212|0|00212)[6-7]\d{8}$/',
            ],
        ]);


        Review::create($data);

        return back()->with('success', 'Thank you for your review!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
