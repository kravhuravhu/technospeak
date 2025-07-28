@if(
    auth()->user() &&
    (
        (is_null(auth()->user()->preferred_category_id) && !session('skipped_preference')) ||
        ((empty(auth()->user()->userType) || is_null(auth()->user()->userType)) && !session('skipped_userType') && !is_null(auth()->user()->preferred_category_id))
    )
)
    <div id="onboarding-modal">
        <div class="on-bord">
            @if(is_null(auth()->user()->preferred_category_id))
                <h2>Tell us what you're into</h2>
                <p>Select a category that best fits your interests.</p>
            @elseif(empty(auth()->user()->userType) || is_null(auth()->user()->userType))
                <h2>What's Your Employment Status?</h2>
                <p>Help us understand where you are in your journey.</p>
            @endif

            <form method="POST" action="{{ route('completeOnboarding') }}">
                @csrf

                @if(is_null(auth()->user()->preferred_category_id))
                    <div>
                        <select name="preferred_category_id" required>
                            <option value="" disabled selected>-- Select Your Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif(empty(auth()->user()->userType) || is_null(auth()->user()->userType))
                    <div>
                        <select name="userType" required>
                            <option value="" disabled selected>-- Select Your Status --</option>
                            <option value="Student">I'm still figuring things out</option>
                            <option value="Professional">I'm already working on something</option>
                        </select>
                    </div>
                @endif

                <button type="submit">Continue</button>
            </form>

            <a href="{{ route('skipOnboarding') }}">Skip for now →</a>
        </div>
    </div>
@endif
