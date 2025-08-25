<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GenericSubmissionNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function submit(Request $request, $type)
    {
        $request->validate([
            'firstName' => 'required|string',
            'lastName'  => 'required|string',
            'email'     => 'required|email',
        ]);

        $data = $request->except('fileUpload');
        $attachments = [];

        if ($request->hasFile('fileUpload')) {
            $files = $request->file('fileUpload');
            
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $file) {
                if ($file->isValid()) {
                    $attachments[] = [
                        'content' => $file->get(),
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getClientMimeType(),
                    ];
                }
            }
            
            if (!empty($attachments)) {
                $data['attachments'] = $attachments;
            }
        }

        try {
            Notification::route('mail', $data['email'])
                ->notify(new GenericSubmissionNotification($data, $type));
                
        } catch (\Exception $e) {
            \Log::error('Notification failed: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Failed to process your submission. Please try again.'
            ], 500);
        }

        return response()->json(['success' => true, 'message' => 'Your submission has been received.']);
    }
}