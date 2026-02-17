<?php

use Illuminate\Support\Facades\Route;
use App\Models\suggestions;

Route::view('/', 'welcome');
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::view('/services', 'services',[
  // 'services' => ['Web Development', 'Mobile App Development', 'UI/UX Design'],
  'services' => [],
  'name' => request()->query('name', 'Guest'),
  'image' => 'https://www.w3schools.com/w3images/avatar2.png'
]);
Route::get('/suggestion', function () {
  $message = session('message');
  // $suggestions = session('suggestions', []);
  // $suggestions = DB::table('suggestions')->get();
  $suggestions = suggestions::all();
  // return $suggestions[0];
  return view('suggestions.index', [
    'message' => $message,
    'suggestions' => $suggestions
  ]);
});
Route::get('/suggestion/{id}', function ($id  = null) {
  $suggestions = suggestions::find($id);
  return view('suggestions.show', [
    'suggestions' => $suggestions
  ]);
});

Route::post('/submit-suggestion', function () {
  // $suggestion = request()->input('suggestion');
  suggestions::create([
    'suggestion' => request('suggestion'),
    'user_id' => null,
    'created_at' => now(),
    'updated_at' => now(),
    'status' => 'pending'
  ]);
  // session()->flash('message', 'Thank you for your suggestion:>> ' . $suggestion);
  // session()->push('suggestions', $suggestion);
  return redirect('/suggestion');
  // dd($suggestion);
  // dd(request()->all());
});
// Temporary route to clear suggestions for testing purposes
Route::get('/delete-suggestions', function () {
  // session()->forget('suggestions');
  suggestions::truncate();
  return redirect('/suggestion');
});
