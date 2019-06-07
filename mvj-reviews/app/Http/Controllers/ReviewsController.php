<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;

class ReviewsController extends Controller
{

  public function index ()
  {
      $reviews = Review::all();
      return view('Review.index', compact('reviews'));
  }
}
