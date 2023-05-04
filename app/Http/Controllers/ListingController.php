<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //show all listings
    public function index(){
        return view('listings.index',[
            'listing'=>Listing::latest()->filter(request(['tag','search']))->get()
        ]);
    }

    //show single listing 
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show Create Form
    public function create() {
         return view('listings.create');
}

    //store listing data
    public function store(Request $request){
            $dataStore=$request->validate([
            'company' => ['required', Rule::unique('listings', 'company')],
            'title' => 'required',
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'tag' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $dataStore['logo'] = $request->file('logo')->store('logos','public');
        }
        
            $dataStore['user_id']= auth()->id();

       Listing::create($dataStore);
            return redirect('/')->with('message', 'Listing created successfully!');
    }

    //show edit form
    public function edit(Listing $listing){
        return view('listings.update',['listing'=>$listing]);
    }    
    //update listings
    public function update(Request $request, Listing $listing){

        //make sure user is login is owner
        if($listing->user_id != auth()->id()){
            abort(403,'unathorised action');
        }
        $dataStore=$request->validate([
        'company' => ['required'],
        'title' => 'required',
        'location' => 'required',
        'email' => ['required', 'email'],
        'website' => 'required',
        'tag' => 'required',
        'description' => 'required'
    ]);

    if($request->hasFile('logo')){
        $dataStore['logo'] = $request->file('logo')->store('logos','public');
    }
    
   $listing->update($dataStore);
       return back()->with('message', 'Listing updated successfully!');
}
// delete listing
    public function delete(Listing $listing)
    {
       $listing->delete();
       return redirect('/')->with('message','Listing Deleted Successfully');
    }

    //manage listing
    public function manage(){
        return view('listings.manage',['listing'=>auth()->user()->listings()->get()]);
    }
}



