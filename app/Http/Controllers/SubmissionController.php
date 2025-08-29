<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GenericSubmissionNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ProblemFeedbackNotification;

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

    // report/feedback
public function supportFeedbackSubmit(Request $request, $type)
{
    $user = Auth::user();
    $request->merge([
        'firstName' => $user->firstName ?? $user->name ?? 'User',
        'lastName'  => $user->surname ?? '',
        'email'     => $user->email ?? '',
    ]);

    $data = $request->except('fileUpload');
    $attachments = [];

    // attachments
    if ($request->hasFile('fileUpload')) {
        $files = $request->file('fileUpload');
        if (!is_array($files)) $files = [$files];

        foreach ($files as $file) {
            if ($file->isValid()) {
                $attachments[] = [
                    'content' => $file->get(),
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                ];
            }
        }
    }

    // prepare relevant fields
    $fieldsToInclude = [];
    if ($type === 'problem') {
        $fields = ['supportSubject','supportMessage','supportPriority'];
    } else {
        $fields = ['feedbackExperience','feedbackEase','feedbackRecommend','feedbackComment'];
    }

    foreach ($fields as $field) {
        if (!empty($data[$field])) {
            $fieldsToInclude[$field] = $data[$field];
        }
    }

    // map numeric feedback to human-readable text
    if ($type === 'feedback') {
        $ratingsMap = [
            'feedbackExperience' => [
                5 => 'Excellent ⭐⭐⭐⭐⭐',
                4 => 'Good ⭐⭐⭐⭐',
                3 => 'Average ⭐⭐⭐',
                2 => 'Poor ⭐⭐',
                1 => 'Very Poor ⭐',
            ],
            'feedbackEase' => [
                5 => 'Very Easy',
                4 => 'Easy',
                3 => 'Neutral',
                2 => 'Difficult',
                1 => 'Very Difficult',
            ],
            'feedbackRecommend' => [
                5 => 'Definitely',
                4 => 'Probably',
                3 => 'Maybe',
                2 => 'Unlikely',
                1 => 'Definitely Not',
            ],
        ];

        foreach (['feedbackExperience','feedbackEase','feedbackRecommend'] as $field) {
            if (!empty($fieldsToInclude[$field])) {
                $fieldsToInclude[$field] = $ratingsMap[$field][$fieldsToInclude[$field]] ?? $fieldsToInclude[$field];
            }
        }
    }
    
    $fieldsToInclude['First Name'] = $data['firstName'] ?? '-';
    $fieldsToInclude['Last Name']  = $data['lastName'] ?? '-';
    $fieldsToInclude['Email']      = $data['email'] ?? '-';

    $emailData = [
        'fields' => $fieldsToInclude,
        'attachments' => $attachments
    ];

    // email notification
    try {
        Notification::route('mail', $data['email'])
            ->notify(new ProblemFeedbackNotification($emailData, $type));
    } catch (\Exception $e) {
        \Log::error('Notification failed: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to process your submission. Please try again.'
        ], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'Your ' . ($type === 'problem' ? 'problem report' : 'feedback') . ' has been received.'
    ]);
}
 
}