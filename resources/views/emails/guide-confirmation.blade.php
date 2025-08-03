@component('mail::message')
# Personal Guide Scheduled

Hello {{ $guideRequest->user->name }},

Your personal guide session has been scheduled:

**Topic:** {{ $guideRequest->topic }}  
**Date/Time:** {{ $guideRequest->scheduled_time->format('F j, Y g:i a') }}  
**Instructor:** {{ $guideRequest->instructor->name }}  
**Meeting Link:** [Join Meeting]({{ $guideRequest->meeting_link }})

**Total Cost:** R{{ $guideRequest->hours_requested * 110 }}

@component('mail::button', ['url' => route('personal-guide.payment', $guideRequest->id)])
Process Payment
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent


/* Form Styles */
.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-group input[type="text"],
.form-group input[type="number"],
.form-group input[type="date"],
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-group textarea {
    min-height: 100px;
}

.radio-group {
    display: flex;
    gap: 1rem;
}

.radio-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: normal;
}

/* Success Modal */
#success-modal .popup-content {
    text-align: center;
    padding: 2rem;
}

#success-modal h3 {
    margin: 1rem 0;
    color: var(--primary-color);
}

#success-modal p {
    margin-bottom: 1.5rem;
}