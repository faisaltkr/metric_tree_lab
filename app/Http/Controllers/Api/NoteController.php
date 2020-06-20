<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Note as NoteResource;

class NoteController extends BaseController
{

   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::all();
        return $this->sendResponse(NoteResource::collection($notes), 'Notes retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules =[
            'note_text' => 'required',
            'file_or_image' => 'mimes:pdf,doc,jpg,png'
        ];


        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->only(['note_text']);
        if($request->has('file_or_image')){
            $file_name = time().'.'.$request->file_or_image->extension();
            $path = $request->file_or_image->storeAs('public/doc', $file_name);
            $input['file_or_image'] = $path;
        }
        $input['user_id'] = Auth::id();
        $input['user_profile_id'] = Auth::user()->profile->id;

        $note = Note::create($input);
        if($note){
            return $this->sendResponse(new NoteResource($note), 'Note created successfully.');
        }
        return $this->sendError('Error.', 'Error while creating note'); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        if($note){
            return $this->sendResponse(new NoteResource($note), 'Note retrived successfully.');
        }
        return $this->sendError('Error.', 'Error while fetching note');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $rules =[
            'note_text' => 'required',
            'file' => 'pdf,doc,jpg,png'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->only(['note_text']);
        if($request->has('file_or_image')){
            //unlink already uploaded image
            Storage::delete($note->file_or_image);
            $file_name = time().'.'.$request->file_or_image->extension();
            $path = $request->file_or_image->storeAs('public/doc', $file_name);
            $input['file_or_image'] = $path;
        }

        $input['user_id'] = Auth::id();
        $input['user_profile_id'] = Auth::user()->profile->id;

        $note->update($input);
        if($note){
            return $this->sendResponse(new NoteResource($note), 'Note updated successfully.');
        }
        return $this->sendError('Error.', 'Error while updating note');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if($note){
            $note->delete();
            return $this->sendResponse([], 'Note deleted successfully.');
        }
        return $this->sendError('Error.', 'Error while deleting note');
    }
}
