<div class="form-card">
    <div class="form-row">
        <div class="form-group">
            <label for="title" class="form-label">Course Title</label>
            <input type="text" id="title" name="title" class="form-control" 
                   value="{{ old('title', $course->title ?? '') }}" required>
            @error('title')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ (old('category_id', $course->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description', $course->description ?? '') }}</textarea>
        @error('description')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="catch_phrase" class="form-label">Catch Phrase (Max 90 chars)</label>
        <input type="text" id="catch_phrase" name="catch_phrase" class="form-control" 
            value="{{ old('catch_phrase', $course->catch_phrase ?? '') }}" maxlength="90" required>
        @error('catch_phrase')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="instructor_id" class="form-label">Instructor</label>
            <select id="instructor_id" name="instructor_id" class="form-control" required>
                <option value="">Select Instructor</option>
                @foreach($instructors as $instructor)
                    <option value="{{ $instructor->id }}" 
                        {{ (old('instructor_id', $course->instructor_id ?? '') == $instructor->id) ? 'selected' : '' }}>
                        {{ $instructor->name }}
                    </option>
                @endforeach
            </select>
            @error('instructor_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="plan_type" class="form-label">Plan Type</label>
            <select id="plan_type" name="plan_type" class="form-control" required>
                <option value="free" {{ (old('plan_type', $course->plan_type ?? '') == 'free' ? 'selected' : '' )}}>Free</option>
                <option value="paid" {{ (old('plan_type', $course->plan_type ?? '') == 'paid' ? 'selected' : '' )}}>Paid</option>
            </select>
            @error('plan_type')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" id="price-field" style="{{ (old('plan_type', $course->plan_type ?? '') == 'free') ? 'display:none;' : '' }}">
            <label for="price" class="form-label">Price ($)</label>
            <input type="number" id="price" name="price" class="form-control" 
                   value="{{ old('price', $course->price ?? '0') }}" min="0" step="0.01">
            @error('price')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="level" class="form-label">Level</label>
            <select id="level" name="level" class="form-control" required>
                <option value="">Select Level</option>
                @foreach(['beginner', 'intermediate', 'advanced', 'expert', 'all levels'] as $lvl)
                    <option value="{{ $lvl }}" {{ old('level', $course->level ?? '') == $lvl ? 'selected' : '' }}>
                        {{ ucfirst($lvl) }}
                    </option>
                @endforeach
            </select>
            @error('level')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="total_duration" class="form-label">Total Duration (minutes)</label>
            <input type="number" id="total_duration" name="total_duration" class="form-control" 
                   value="{{ old('total_duration', $course->total_duration ?? '') }}" min="1" required>
            @error('total_duration')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="noEpisodes" class="form-label">Number of Episodes</label>
            <input type="number" id="noEpisodes" name="noEpisodes" class="form-control" 
                   value="{{ old('noEpisodes', $course->noEpisodes ?? '') }}" min="1" required>
            @error('noEpisodes')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="thumbnail" class="form-label">Thumbnail URL</label>
        <input type="url" id="thumbnail" name="thumbnail" class="form-control" 
               value="{{ old('thumbnail', $course->thumbnail ?? '') }}" required>
        @error('thumbnail')
            <div class="error-message">{{ $message }}</div>
        @enderror
        @if(isset($course) && $course->thumbnail)
            <div style="margin-top: 10px;">
                <img src="{{ $course->thumbnail }}" alt="Course Thumbnail" style="max-width: 200px; border-radius: 8px;">
            </div>
        @endif
    </div>

    <div class="form-group">
        <label for="software_app_icon" class="form-label">Software/App Icon URL</label>
        <input type="url" id="software_app_icon" name="software_app_icon" class="form-control" 
               value="{{ old('software_app_icon', $course->software_app_icon ?? '') }}" required>
        @error('software_app_icon')
            <div class="error-message">{{ $message }}</div>
        @enderror
        @if(isset($course) && $course->software_app_icon)
            <div style="margin-top: 10px;">
                <img src="{{ $course->software_app_icon }}" alt="Software Icon" style="max-width: 50px;">
            </div>
        @endif
    </div>

    <!-- <div class="form-group">
        <label for="is_active" class="form-label">Status</label>
        <select id="is_active" name="is_active" class="form-control">
            <option value="1" {{ (old('is_active', $course->is_active ?? true) ? 'selected' : '') }}>Active</option>
            <option value="0" {{ !(old('is_active', $course->is_active ?? true)) ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('is_active')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div> -->

    <div class="form-group" style="margin-top: 1.5rem;">
        <button type="submit" class="btn btn-primary">
            {{ isset($course) ? 'Update Course' : 'Create Course' }}
        </button>
        <a href="{{ route('content-manager.courses.index') }}" class="btn btn-outline">
            Cancel
        </a>
    </div>
</div>

<script>
    document.getElementById('plan_type').addEventListener('change', function() {
        const priceField = document.getElementById('price-field');
        if (this.value === 'paid') {
            priceField.style.display = 'block';
            document.getElementById('price').required = true;
        } else {
            priceField.style.display = 'none';
            document.getElementById('price').required = false;
        }
    });
</script>